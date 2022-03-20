<?php

namespace App\Http\Controllers\Outdoor;

use App\Custom\Helper;
use App\Http\Requests\PatientRequest;
use App\Models\Outdoor\Patient;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OutdoorController extends Controller
{
    public function index()
    {
        return 'Outdoor';
    }

    public function addPatient()
    {
        return view('outdoor.patient.addPatient');
    }

    public function patientList()
    {
        $patients = Patient::whereIn('status', [0, 1])
            ->get();
        // return $employee->user->full_name;
        return view('outdoor.patient.patient', compact('patients'));
    }

    public function savePatientInfo(PatientRequest $request)
    {
        DB::beginTransaction();
        try {
            $saveUser = User::insertGetId([
                'branch_id' => 1,
                'full_name' => $request->full_name,
                'user_name' => $request->user_name,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'present_address' => $request->present_address,
                'permanent_address' => $request->permanent_address,
                'mobile_no' => $request->mobile_no,
                'gender' => $request->gender,
                'dob' => date('Y-m-d', strtotime($request->dob)),
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'remember_token' => $request->_token,
                'user_type' => 1,
                'created_by' => 1
            ]);
            if ($saveUser) {
                // Create a row at Employee
                $savePatient = Patient::insertGetId([
                    'user_id' => $saveUser,
                    'blood_group' => $request->blood_group,
                    'created_by' => 1
                ]);
                //Image upload and update path at User
                if (strlen($request->file('profile_image')) > 0) {
                    $folderPath = 'images/patient/';
                    $fileName = Helper::imageUploadRaw($saveUser, $request->file('profile_image'), $folderPath, 75, 75);
                    if ($fileName != null) {
                        $savePatient = User::where('user_id', $saveUser)
                            ->update([
                                'profile_image' => $fileName,
                                'updated_by' => 1
                            ]);
                    }
                }
                Session::flash('success', 'Patient Addedd Successfull !!');
                DB::commit();
            } else {
                Session::flash('error', 'Something Went Wrong !!');
                DB::rollBack();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', $e->errorInfo[2]);
        }
        return redirect()->route('outdoor.patient');
    }


    function editPatient($patiendId)
    {
        $patient = Patient::where('patient_id', $patiendId)
            ->first();
        return view('outdoor.patient.editPatient', compact('patient'));
    }

}
