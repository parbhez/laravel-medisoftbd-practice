<?php

namespace App\Http\Controllers\Billings;

use Illuminate\Http\Request;

class BillingsController extends Controller
{
    public function index()
    {
    	return 'Billings';
    }

    public function updateStatus($modelReference, $action, $id)
    {
        $modelName = '';
        foreach (explode('-', $modelReference) as $value) {
            $modelName .= ucwords($value);
        }
        $filterColumn = implode('_', explode('-', $modelReference)) . '_id';
        $modelPath = 'App\Models\Billings\\' . $modelName;
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
}
