<?php

namespace App\Http\Controllers\Diagnostic;

use App\Models\Diagnostic\DiagnosticTest;
use App\Models\Diagnostic\ServiceGroup;
use App\Models\Diagnostic\ServiceGroupItem;
use App\Models\Diagnostic\ServicePackageItem;
use App\Models\Settings\ServiceCategory;
use App\Models\Settings\ServiceSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\DB;
use App\Custom\Helper;
use Yajra\Datatables\Datatables;

class DiagnosticController extends Controller
{
    public function index()
    {
        return 'Diagnostic';
    }
    
    public function diagnosticTestList()
    {
        Session::forget('saleItems');
        return view('diagnostic.test.test');
    }

    public function serviceGroupList()
    {
        $service_groups = ServiceGroup::whereIn('status', [0, 1])->get();
        return view('diagnostic.test.serviceGroup', compact('service_groups'));
    }


    public function editServiceGroup($id)
    {
        $serviceGroup = ServiceGroup::where('service_group_id', $id)->get()->first();
        $service_categories = ServiceCategory::all()->pluck('service_category_name', 'service_category_id');
        $service_sub_categories = ServiceSubCategory::where('service_category_id', $serviceGroup->service_category_id)->pluck('service_sub_category_name', 'service_sub_category_id');
        $serviceGroupItemsId = ServiceGroupItem::where('service_group_id', $id)->get()->pluck('diagnostic_test_id')->toArray();
        $services = DiagnosticTest::whereIn('diagnostic_test_id', $serviceGroupItemsId)->get();
        return view('diagnostic.test.editServiceGroup', compact('serviceGroup', 'services', 'service_categories', 'service_sub_categories'));
    }

    public function updateServiceGroup(Request $request)
    {

        $this->validate($request, [
            'service_category_id' => 'required',
            'diagnostic_test_id.*' => 'required',
            'service_group_name' => 'required'
        ]);

        $serviceGroupID = ServiceGroup::where('service_group_id', $request->service_group_id)
            ->update([
                'service_group_name' => $request->service_group_name,
                'service_category_id' => $request->service_category_id,
                'service_sub_category_id' => $request->service_sub_category_id,
                'created_by' => 1
            ]);

        if ($serviceGroupID) {

            ServiceGroupItem::where('service_group_id', $request->service_group_id)->delete();

            $input = Input::all();
            $data = [];
            for ($idx = 0; $idx < count(Input::get('diagnostic_test_id')); $idx++) {
                $data[] = [
                    'service_group_id' => $request->service_group_id,
                    'diagnostic_test_id' => $input['diagnostic_test_id'][$idx],
                    'created_by' => 1,
                ];
            }

            ServiceGroupItem::insert($data);

            Session::flash('success', 'Total ' . count($data) . ' Service has been Updated Successfull as a Group : ' . $request->service_group_name . ' !!');

            return redirect()->route('view-diagnostic-service-group');
        }

    }


    public function getDiagnosticTestAjax()
    {
        $model = DiagnosticTest::orderBy('diagnostic_test_id', 'DESC')
            ->whereIn('status', [0, 1]);
        return Datatables::of($model)
            ->addColumn('service_category', function ($diagnostic) {
                return $diagnostic->service_category->service_category_name;
            })
            ->addColumn('service_sub_category', function ($diagnostic) {
                return $diagnostic->service_sub_category->service_sub_category_name;
            })
            ->editColumn('status', function ($diagnostic) {
                $html = '';
                $html .= "<label class='label label-warning'";
                if ($diagnostic->status == 1) {
                    $html .= "style='display:none'";
                }
                $html .= ">Inactive</label>";

                $html .= "<label class='label label-success'";
                if ($diagnostic->status == 0) {
                    $html .= "style='display:none'";
                }
                $html .= ">Active</label>";
                return $html;
            })
            ->addColumn('action', function ($diagnostic) {
                return view('common.statusButon', compact('diagnostic'));
            })
            ->rawColumns(['service_category', 'service_sub_category', 'status', 'action'])
//            ->orderColumn('diagnostic_test_name', '-diagnostic_test_name $1')
            ->make();
            // explode(delimiter, string)
    }

    public function getServiceGroupAjax()
    {
        $model = ServiceGroup::orderBy('diagnostic_test_id', 'DESC')
            ->whereIn('status', [0, 1]);
        return Datatables::of($model)
            ->addColumn('service_category', function ($diagnostic) {
                return $diagnostic->service_category->service_category_name;
            })
            ->addColumn('service_sub_category', function ($diagnostic) {
                return $diagnostic->service_sub_category->service_sub_category_name;
            })
            ->editColumn('status', function ($diagnostic) {
                $html = '';
                $html .= "<label class='label label-warning'";
                if ($diagnostic->status == 1) {
                    $html .= "style='display:none'";
                }
                $html .= ">Inactive</label>";

                $html .= "<label class='label label-success'";
                if ($diagnostic->status == 0) {
                    $html .= "style='display:none'";
                }
                $html .= ">Active</label>";
                return $html;
            })
            ->addColumn('action', function ($diagnostic) {
                return view('common.statusButon', compact('diagnostic'));
            })
            ->rawColumns(['service_category', 'service_sub_category', 'status', 'action'])
//            ->orderColumn('diagnostic_test_name', '-diagnostic_test_name $1')
            ->make();
    }

    public function addDiagnosticTest()
    {
        return view('diagnostic.test.addTest');
    }

    public function addDiagnosticTestNew()
    {
        $service_categories = ServiceCategory::all()->pluck('service_category_name', 'service_category_id');
        return view('diagnostic.test.addTestNew', compact('service_categories'));
    }

    public function addServiceGroup()
    {
        $service_categories = ServiceCategory::all()->pluck('service_category_name', 'service_category_id');
        return view('diagnostic.test.addServiceGroup', compact('service_categories'));
    }

    public function addServicePackage()
    {
        $service_categories = ServiceCategory::all()->pluck('service_category_name', 'service_category_id');
        return view('diagnostic.test.addServicePackage', compact('service_categories'));
    }

    public function viewServiceGroup()
    {

        $service_categories = ServiceCategory::all()->pluck('service_category_name', 'service_category_id');
        return view('diagnostic.test.addServicePackage', compact('service_categories'));

    }

    public function search(Request $request)
    {
        if (Input::has('service_type')) {
            if ($request->service_type == 'group') {
                $result = ServiceGroup::where('service_group_name', 'LIKE', "%{$request->input('q')}%")->get();
            } else {
                $result = DiagnosticTest::where('diagnostic_test_name', 'LIKE', "%{$request->input('q')}%")->get();
            }
        } else {
            $result = DiagnosticTest::where('diagnostic_test_name', 'LIKE', "%{$request->input('q')}%")->get();
        }
        return response()->json($result);
    }

    public function addService(Request $request)
    {
        $service_group_name = null;
        if ($request->type == 'service') {
            $services = DiagnosticTest::where('diagnostic_test_id', $request->dtid)->get();
            return view('diagnostic.test.addService', compact('services', 'service_group_name'));
        } else {
            $service_group_name = ServiceGroup::where('service_group_id', $request->dtid)->select('service_group_name')->first()->service_group_name;
            $services_id = ServiceGroupItem::where('service_group_id', $request->dtid)->pluck('diagnostic_test_id')->toArray();
            $services = DiagnosticTest::whereIn('diagnostic_test_id', $services_id)->get();
            $service_group_id = $request->dtid;
            return view('diagnostic.test.addServiceG', compact('services', 'service_group_name', 'service_group_id'));
        }

    }

    public function getSubCategories(Request $request)
    {
        $service_sub_categories = ServiceSubCategory::where('service_category_id', $request->id)->pluck('service_sub_category_name', 'service_sub_category_id');
        return response()->json($service_sub_categories->toArray());
    }

    public function addContent()
    {
        return view('diagnostic.test.addForm');
    }

    public function saveDiagnosticTest(Request $request)
    {
        $this->validate($request, [
            'service_category_id' => 'required',
            'diagnostic_test_name.*' => 'required'
        ]);

        $data = [];

        $input = Input::all();

        for ($idx = 0; $idx < count(Input::get('diagnostic_test_name')); $idx++) {

            $data[] = [
                'service_category_id' => $input['service_category_id'],
                'service_sub_category_id' => $input['service_sub_category_id'],
                'diagnostic_test_name' => $input['diagnostic_test_name'][$idx],
                'diagnostic_test_price' => $input['diagnostic_test_price'][$idx],
                'diagnostic_test_sale_price' => $input['diagnostic_test_sale_price'][$idx],
                'diagnostic_test_result_type' => $input['diagnostic_test_result_type'][$idx],
                'created_by' => 1,
            ];
        }

        DiagnosticTest::insert($data);

        Session::flash('success', 'Total ' . count($data) . ' Diagnostic Test Addedd Successfull !!');

        return redirect()->route('diagnostic-test');
    }

    public function saveServiceGroup(Request $request)
    {

        $this->validate($request, [
            'service_category_id' => 'required',
            'diagnostic_test_id.*' => 'required',
            'service_group_name' => 'required|unique_with:service_groups,service_group_name ,service_category_id, service_sub_category_id'
        ]);

        $serviceGroupID = \Illuminate\Support\Facades\DB::table('service_groups')->insertGetId([
            'service_group_name' => $request->service_group_name,
            'service_category_id' => $request->service_category_id,
            'service_sub_category_id' => $request->service_sub_category_id,
            'created_by' => 1
        ]);

        if ($serviceGroupID) {

            $input = Input::all();

            $data = [];

            for ($idx = 0; $idx < count(Input::get('diagnostic_test_id')); $idx++) {
                $data[] = [
                    'service_group_id' => $serviceGroupID,
                    'diagnostic_test_id' => $input['diagnostic_test_id'][$idx],
                    'created_by' => 1,
                ];
            }

            ServiceGroupItem::insert($data);

            Session::flash('success', 'Total ' . count($data) . ' Service has been Addedd Successfull as a Group : ' . $request->service_group_name . ' !!');

            return redirect()->route('view-diagnostic-service-group');
        }

    }

    public function saveServicePackage(Request $request)
    {
        $this->validate($request, [
            'service_package_name' => 'required|unique_with:service_packages,service_package_name'
        ]);

        $packageID = \Illuminate\Support\Facades\DB::table('service_packages')->insertGetId([
            'service_package_name' => $request->service_package_name,
            'created_by' => 1
        ]);

        $serviceGroupId = [];

        if (Input::has('service_group_id')) {
            $service_group_id = Input::get('service_group_id');
            foreach ($service_group_id as $id) {
                array_push($serviceGroupId, $id);
            }
        }
        $groupServicesId = [];
        if (count($serviceGroupId) > 0) {
            $groupServicesId = ServiceGroupItem::whereIn('service_group_id', $serviceGroupId)->pluck('diagnostic_test_id')->toArray();
        }

        $diagnosticTestId = [];

        if (Input::has('diagnostic_test_id')) {
            $dti = Input::get('diagnostic_test_id');
            foreach ($dti as $id) {
                array_push($diagnosticTestId, $id);
            }
        }

        if (count($serviceGroupId) > 0) {

            $onlyServicesId = array_diff($diagnosticTestId, $groupServicesId);

            $serviceData = [];
            foreach ($onlyServicesId as $id) {
                array_push($serviceData,
                    [
                        'type' => 1,
                        'service_package_id' => $packageID,
                        'service_item_id' => $id,
                        'created_by' => 1
                    ]
                );
            }

            ServicePackageItem::insert($serviceData);

            $groupData = [];
            foreach ($serviceGroupId as $id) {
                array_push($groupData,
                    [
                        'type' => 2,
                        'service_package_id' => $packageID,
                        'service_item_id' => $id,
                        'created_by' => 1
                    ]
                );
            }

            ServicePackageItem::insert($groupData);

        } else {

            $serviceData = [];
            foreach ($diagnosticTestId as $id) {
                array_push($serviceData,
                    [
                        'type' => 1,
                        'service_package_id' => $packageID,
                        'service_item_id' => $id,
                        'created_by' => 1
                    ]
                );
            }

            ServicePackageItem::insert($serviceData);
        }

        Session::flash('success', 'Service Package has been Addedd Successfull !!');

        return redirect()->route('view-diagnostic-service-group');

    }

    public function editdiagnosticTest($testId = null)
    {
        $diagnosticTest = DiagnosticTest::where('diagnostic_test_id', $testId)
            ->first();
        return view('diagnostic.test.editTest', compact('diagnosticTest'));
    }

    public function updateDiagnosticTest(Request $request)
    {
        $this->validate($request, [
            'diagnostic_test_name' => 'required',
            'diagnostic_test_price' => 'required|numeric',
            'diagnostic_test_sale_price' => 'required|numeric'

        ]);

        DiagnosticTest::where('diagnostic_test_id', $request->diagnostic_test_id)
            ->update([
                'diagnostic_test_name' => $request->diagnostic_test_name,
                'diagnostic_test_price' => $request->diagnostic_test_price,
                'diagnostic_test_sale_price' => $request->diagnostic_test_sale_price
            ]);

        Session::flash('success', 'Existing Diagnostic Test has been Updated Successfull !!');

        return redirect()->route('diagnostic-test');
    }

    public function updateStatus($modelReference, $action, $id)
    {
        $modelName = '';
        foreach (explode('-', $modelReference) as $value) {
            $modelName .= ucwords($value);
        }
        $filterColumn = implode('_', explode('-', $modelReference)) . '_id';
        $modelPath = 'App\Models\Diagnostic\\' . $modelName;
        $model = new $modelPath();

        DB::beginTransaction();
        try {
            $result = $model::where($filterColumn, $id)
                ->update([
                    'status' => Helper::getStatus($action),
                    'updated_by' => 1,
                ]);
            if ($result) {
                DB::commit();
                return response()->json(['success' => true, 'message' => ucwords($action) . ' Successfull !']);
            } else {
                DB::rollBack();
                return response()->json(['error' => true, 'message' => 'Something Went Wrong !']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->errorInfo[2]]);
        }
    }

    public function saleFormDiagnoticTest()
    {
        return view('diagnostic.sale.testSaleForm');
    }
}
