<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Models\Settings\Designation;
use App\Models\Settings\Department;
use App\Models\Settings\EducationalQualification;
use App\Models\Settings\MedicalDegree;
use App\Models\Settings\ServiceCategory;
use App\Models\Settings\ServiceSubCategory;
use Session;
use DB;
use Helper;

class SettingsController extends Controller
{
    public function setup()
    {
        return view('settings.setup.setup');
    }

//===============@@ Designation Panel Start @@===================
    public function addDesignation()
    {
        return view('settings.setup.designation.addDesignation');
    }

    public function saveDesignation(Request $request)
    {
        //Validate this for request
        $this->validate($request, [
            'designation_name' => 'required|unique_with:designations,designation_name,designation_type,status',
            'designation_type' => 'required',
        ]);
        try {
            $saveDesignation = Designation::insert([
                'designation_name' => $request->designation_name,
                'designation_type' => $request->designation_type,
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            if ($saveDesignation) {
                Session::flash('success', 'Designation Save Successfull !');
            } else {
                Session::flash('error', 'Something Went Wrong !');
            }
        } catch (\Exception $e) {
            Session::flash('error', $e->errorInfo[2]);
        }
        return redirect()->route('settings.setup');
    }

    public function viewDesignation()
    {
        $designations = Designation::whereIn('status', [0, 1])
            ->get();
        return view('settings.setup.designation.viewDesignation', compact('designations'));
    }

    public function updateStatus($modelReference, $action, $id)
    {
        $modelName = '';
        foreach (explode('-', $modelReference) as $value) {
            $modelName .= ucwords($value);
        }
        $filterColumn = implode('_', explode('-', $modelReference)) . '_id';
        $modelPath = 'App\Models\Settings\\' . $modelName;
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

    public function updateSaveDesignation(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'designation_name' => 'required',
            'designation_type' => 'required',
        ]);
        try {
            $updateDesignation = Designation::where('designation_id', $request->designation_id)
                ->update([
                    'designation_name' => $request->designation_name,
                    'designation_type' => $request->designation_type,
                    'updated_by' => 1,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            if ($updateDesignation) {
                return response()->json(['success' => true, 'message' => 'Update Successfull !']);
            } else {
                return response()->json(['error' => true, 'message' => 'Something Went Wrong !']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->errorInfo[2]]);
        }
    }

//===============@@ Designation Panel End @@===================

//===============@@ Department Panel Start @@===================

    public function addDepartment()
    {
        return view('settings.setup.department.addDepartment');
    }

    public function saveDepartment(Request $request)
    {
        //Validate this for request
        $this->validate($request, [
            'department_name.*' => 'required|unique_with:departments,department_name,status',
        ]);

        try {
            foreach ($request->department_name as $department_name) {
                $saveDepartment = Department::insert([
                    'department_name' => $department_name,
                    'created_by' => 1,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
            if ($saveDepartment) {
                Session::flash('success', 'Department Save Successfull !');
            } else {
                Session::flash('error', 'Something Went Wrong !');
            }
        } catch (\Exception $e) {
            Session::flash('error', $e->errorInfo[2]);
        }
        return redirect()->route('settings.setup');
    }

    public function viewDepartment()
    {
        $departments = Department::whereIn('status', [0, 1])
            ->get();
        return view('settings.setup.department.viewDepartment', compact('departments'));
    }

    public function updateSaveDepartment(Request $request)
    {
        $this->validate($request, [
            'department_name' => 'required',
        ]);
        try {
            $updateDepartment = Department::where('department_id', $request->department_id)
                ->update([
                    'department_name' => $request->department_name,
                    'updated_by' => 1,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            if ($updateDepartment) {
                return response()->json(['success' => true, 'message' => 'Update Successfull !']);
            } else {
                return response()->json(['error' => true, 'message' => 'Something Went Wrong !']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->errorInfo[2]]);
        }
    }
//===============@@ Department Panel End @@===================


//===============@@ Educational Qualification Panel Start @@=================

    public function addEducationalQualification()
    {
        return view('settings.setup.education.addEducationalQualification');
    }

    public function saveEducationalQualification(Request $request)
    {
        //Validate this for request
        $this->validate($request, [
            'educational_qualification_name.*' => 'required',
        ]);
        try {
            foreach ($request->educational_qualification_name as $educational_qualification_name) {
                $saveEducation = EducationalQualification::insert([
                    'educational_qualification_name' => $educational_qualification_name,
                    'created_by' => 1,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
            if ($saveEducation) {
                Session::flash('success', 'Educational Qualification Save Successfull !');
            } else {
                Session::flash('error', 'Something Went Wrong !');
            }
        } catch (\Exception $e) {
            Session::flash('error', $e->errorInfo[2]);
        }
        return redirect()->route('settings.setup');
    }

    public function viewEducationalQualification()
    {
        $qualifications = EducationalQualification::whereIn('status', [0, 1])
            ->get();
        return view('settings.setup.education.viewEducationalQualification', compact('qualifications'));
    }

    public function updateSaveEducationalQualification(Request $request)
    {
        $this->validate($request, [
            'educational_qualification_name' => 'required',
        ]);
        try {
            $updateEducationalQualification = EducationalQualification::where('educational_qualification_id', $request->educational_qualification_id)
                ->update([
                    'educational_qualification_name' => $request->educational_qualification_name,
                    'updated_by' => 1,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            if ($updateEducationalQualification) {
                return response()->json(['success' => true, 'message' => 'Update Successfull !']);
            } else {
                return response()->json(['error' => true, 'message' => 'Something Went Wrong !']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->errorInfo[2]]);
        }
    }

//===============@@ Educational Qualification Panel End @@===================

//=================@@ Medical Degree Panel Start @@====================

    public function addMedicalDegree()
    {
        return view('settings.setup.medicalDegree.addMedicalDegree');
    }

    public function saveMedicalDegree(Request $request)
    {
        //Validate this for request
        $this->validate($request, [
            'medical_degree_name.*' => 'required|unique_with:medical_degrees,medical_degree_name,status',
        ]);
        try {
            foreach ($request->medical_degree_name as $medical_degree_name) {
                // return $medical_degree_name;
                $saveMedicalDegree = MedicalDegree::insert([
                    'medical_degree_name' => $medical_degree_name,
                    'created_by' => 1,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
            if ($saveMedicalDegree) {
                Session::flash('success', 'Medical Degree Save Successfull !');
            } else {
                Session::flash('error', 'Something Went Wrong !');
            }
        } catch (\Exception $e) {
            Session::flash('error', $e->errorInfo[2]);
        }
        return redirect()->route('settings.setup');
    }

    public function viewMedicalDegree()
    {
        $medicalDegrees = MedicalDegree::whereIn('status', [0, 1])
            ->get();
        return view('settings.setup.medicalDegree.viewMedicalDegree', compact('medicalDegrees'));
    }

    public function updateSaveMedicalDegree(Request $request)
    {
        $this->validate($request, [
            'medical_degree_name' => 'required',
        ]);
        try {
            $updateMedicalDegree = MedicalDegree::where('medical_degree_id', $request->medical_degree_id)
                ->update([
                    'medical_degree_name' => $request->medical_degree_name,
                    'updated_by' => 1,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            if ($updateMedicalDegree) {
                return response()->json(['success' => true, 'message' => 'Update Successfull !']);
            } else {
                return response()->json(['error' => true, 'message' => 'Something Went Wrong !']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->errorInfo[2]]);
        }
    }

//===============@@ Educational Qualification Panel End @@===================

//===============@@ Service Category Panel Start @@===================

    public function addServiceCategory()
    {
        return view('settings.setup.serviceCategory.addServiceCategory');
    }

    public function saveServiceCategory(Request $request)
    {
        //Validate this for request
        $this->validate($request, [
            'service_category_name.*' => 'required',
        ]);

        try {
            foreach ($request->service_category_name as $service_category_name) {
                $result = ServiceCategory::insert([
                    'service_category_name' => $service_category_name,
                    'created_by' => 1,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
            if ($result) {
                Session::flash('success', 'Service Category Save Successfull !');
            } else {
                Session::flash('error', 'Something Went Wrong !');
            }
        } catch (\Exception $e) {
            return $e;
            Session::flash('error', $e->errorInfo[2]);
        }
        return redirect()->route('settings.setup');
    }

    public function viewServiceCategory()
    {
        $serviceCategories = ServiceCategory::whereIn('status', [0, 1])
            ->get();
        return view('settings.setup.serviceCategory.viewServiceCategory', compact('serviceCategories'));
    }

    public function updateSaveServiceCategory(Request $request)
    {
        $this->validate($request, [
            'service_category_name' => 'required',
        ]);
        try {
            $result = ServiceCategory::where('service_category_id', $request->service_category_id)
                ->update([
                    'service_category_name' => $request->service_category_name,
                    'updated_by' => 1,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            if ($result) {
                return response()->json(['success' => true, 'message' => 'Update Successfull !']);
            } else {
                return response()->json(['error' => true, 'message' => 'Something Went Wrong !']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->errorInfo[2]]);
        }
    }
//===============@@ Service Category Panel End @@===================

//===============@@ Service Sub Category Panel Start @@===================

    public function addServiceSubCategory()
    {
        $serviceCategories = ['' => 'Please Select Category'] + 
            ServiceCategory::where('status', 1)
                ->pluck('service_category_name', 'service_category_id')
                ->all();
        return view('settings.setup.serviceSubCategory.addServiceSubCategory',compact('serviceCategories'));
    }

    public function saveServiceSubCategory(Request $request)
    {
        //Validate this for request
        $this->validate($request, [
            'service_category_name' => 'required',
            'service_sub_category_name' => 'required',
        ]);
        try {
            $result = ServiceSubCategory::insert([
                'service_category_id' => $request->service_category_name,
                'service_sub_category_name' => $request->service_sub_category_name,
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            if ($result) {
                Session::flash('success', 'Service Sub Category Save Successfull !');
            } else {
                Session::flash('error', 'Something Went Wrong !');
            }
        } catch (\Exception $e) {
            // return $e;
            Session::flash('error', $e->errorInfo[2]);
        }
        return redirect()->route('settings.setup');
    }

    public function viewServiceSubCategory()
    {
        $serviceCategories = ['' => 'Please Select Category'] + 
            ServiceCategory::where('status', 1)
                ->pluck('service_category_name', 'service_category_id')
                ->all();
        $serviceSubCategories = ServiceSubCategory::whereIn('status', [0, 1])
            ->get();
        return view('settings.setup.serviceSubCategory.viewServiceSubCategory', compact('serviceSubCategories','serviceCategories'));
    }

    public function updateSaveServiceSubCategory(Request $request)
    {
        $this->validate($request, [
            'service_category_name' => 'required',
            'service_sub_category_name' => 'required',
        ]);
        try {
            $result = ServiceSubCategory::where('service_sub_category_id', $request->service_sub_category_id)
                ->update([
                    'service_category_id' => $request->service_category_name,
                    'service_sub_category_name' => $request->service_sub_category_name,
                    'updated_by' => 1,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            if ($result) {
                return response()->json(['success' => true, 'message' => 'Update Successfull !']);
            } else {
                return response()->json(['error' => true, 'message' => 'Something Went Wrong !']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->errorInfo[2]]);
        }
    }
//===============@@ Service Sub Category Panel End @@===================
}
