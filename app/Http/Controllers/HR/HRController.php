<?php

namespace App\Http\Controllers\HR;

use App\Http\Requests\ScheduleRequest;
use App\Models\HR\AppointmentBlock;
use App\Models\HR\Schedule;
use App\Models\HR\ScheduleBlock;
use App\Models\HR\ScheduleSlot;
use Illuminate\Http\Request;
use App\Models\HR\Employee;
use App\User;
use App\Models\HR\Doctor;
use App\Models\Settings\Designation;
use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\DoctorRequest;
use App\Custom\Helper;
use Illuminate\Support\Facades\DB;
use Session;
use App\Models\Settings\Department;
use Illuminate\Support\Facades\File;
use App\Models\HR\Appointment;
use App\Http\Requests\AppointmentRequest;
use App\Models\HR\AppointmentSlot;
use DateTime;
use Nahid\JsonQ\Jsonq;

class HRController extends Controller
{
    public function index()
    {
        return 'HR';
    }
    //======================@@ Employee Panel Start @@===============
    public function employeeList()
    {
        $employees = Employee::whereIn('status', [0, 1])
            ->get();
        $designations = ['' => 'Please Select Designation'] + 
            Designation::where('status', 1)
                ->where('designation_type', 1)
                ->pluck('designation_name', 'designation_id')
                ->all();
        // return $employee->user->full_name;
        return view('hr.employee.employee', compact('employees','designations'));
    }
    // public function addEmployee()
    // {
    //     $designations = ['' => 'Please Select Designation'] + 
    //         Designation::where('status', 1)
    //             ->where('designation_type', 1)
    //             ->pluck('designation_name', 'designation_id')
    //             ->all();
    //     return view('hr.employee.addEmployee', compact('designations'));
    // }
    
    public function saveEmployeeInfo(EmployeeRequest $request)
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
                $saveEmployee = Employee::insertGetId([
                    'user_id' => $saveUser,
                    'designation_id' => $request->designation,
                    'created_by' => 1
                ]);
                //Image upload and update path at User
                if (strlen($request->file('profile_image')) > 0) {
                    $folderPath = 'images/employee/';
                    $fileName = Helper::imageUploadRaw($saveUser, $request->file('profile_image'), $folderPath, 75, 75);
                    if ($fileName != null) {
                        $saveEmployee = User::where('user_id', $saveUser)
                            ->update([
                                'profile_image' => $fileName,
                                'updated_by' => 1
                            ]);
                    }
                }
                Session::flash('success', 'Employee Addedd Successfull !!');
                DB::commit();
            } else {
                Session::flash('error', 'Something Went Wrong !!');
                DB::rollBack();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $e;
            Session::flash('error', $e->errorInfo[2]);
        }
        return redirect()->route('hr.employee');
    }

    public function updateEmployeeStatus($action, $userId = null)
    {
        // return $userId;
        DB::beginTransaction();
        try {
            $result = User::where('user_id', $userId)
                ->update([
                    'status' => Helper::getStatus($action),
                    'updated_by' => 1,
                ]);
            if ($result) {
                // Inactive Employee
                $activeEmployee = Employee::where('user_id', $userId)
                    ->update([
                        'status' => Helper::getStatus($action),
                        'updated_by' => 1,
                    ]);
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

    public function editEmployee($employeeId = null)
    {
        // return $employeeId;
        $employee = Employee::where('employee_id', $employeeId)
            ->first();
        $designations = Designation::where('status', 1)
            ->where('designation_type', 1)
            ->get();
        return view('hr.employee.editEmployee', compact('designations', 'employee'));
    }

    public function updateSaveEmployeeInfo(Request $request, $employeeId)
    {
        // return $employeeId;
        $findEmployee = Employee::where('employee_id', $employeeId)
            ->first();
        if ($findEmployee) {
            DB::beginTransaction();
            try {
                $updateUser = User::where('user_id', $findEmployee->user_id)
                    ->update([
                        'full_name' => $request->full_name,
                        'user_name' => $request->user_name,
                        'father_name' => $request->father_name,
                        'mother_name' => $request->mother_name,
                        'present_address' => $request->present_address,
                        'permanent_address' => $request->permanent_address,
                        'mobile_no' => $request->mobile_no,
                        'gender' => $request->gender,
                        'dob' => date('Y-m-d', strtotime($request->dob)),
                        'updated_by' => 1
                    ]);

                if ($updateUser) {
                    //Update row at Employee
                    $updateEmployee = Employee::where('employee_id', $employeeId)
                        ->update([
                            'designation_id' => $request->designation,
                            'created_by' => 1
                        ]);
                    //Image upload and update path at User
                    if (strlen($request->file('profile_image')) > 0) {
                        $oldImage = $findEmployee->user->profile_image;
                        $folderPath = 'images/employee/';
                        $fileName = Helper::imageUploadRaw($findEmployee->user_id, $request->file('profile_image'), $folderPath, 75, 75);
                        if ($fileName != null) {
                            $updateUserImage = User::where('user_id', $findEmployee->user_id)
                                ->update([
                                    'profile_image' => $fileName,
                                    'updated_by' => 1
                                ]);
                            if (file_exists(public_path() . '/' . $folderPath . '/' . $fileName)) {

                                if (file_exists(public_path() . '/' . $folderPath . $oldImage)) {
                                    unlink(public_path() . '/' . $folderPath . $oldImage);
                                }
                            }
                        }
                    }
                    Session::flash('success', 'Employee Update Successfull !!');
                    DB::commit();
                } else {
                    Session::flash('error', 'Something Went Wrong !!');
                    DB::rollBack();
                }
            } catch (\Exception $e) {
                DB::rollBack();
                // return $e;
                Session::flash('error', $e->errorInfo[2]);
            }
        }
        return redirect()->route('hr.employee');
    }
    //======================@@ Employee Panel End @@===============

    //======================@@ Doctors Panel Start @@===============

    public function addDoctor()
    {
        $designations = Designation::where('status', 1)
            ->where('designation_type', 1)
            ->pluck('designation_name', 'designation_id');

        $departments = Department::all()->pluck('department_name', 'department_id');

        $educational_qualifications = DB::table('educational_qualifications')->get()->pluck('educational_qualification_name', 'educational_qualification_id');

        $medical_degrees = DB::table('medical_degrees')->get()->pluck('medical_degree_name', 'medical_degree_id');

        return view('hr.doctor.addDoctor', compact('designations', 'departments', 'educational_qualifications', 'medical_degrees'));
    }

    public function saveDoctorInfo(DoctorRequest $request)
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
                'user_type' => 2,
                'created_by' => 1
            ]);

            if ($saveUser) {
                // Create a row at Employee
                $saveEmployee = Doctor::insertGetId([
                    'user_id' => $saveUser,
                    'designation_id' => $request->designation,
                    'department_id' => $request->department,
                    'educational_qualification_id' => $request->educational_qualification,
                    'medical_degree_id' => $request->medical_degree,
                    'speciality' => $request->speciality,
                    'allow_prescription_fee' => isset($request->allow_prescription_fee) ? 1 : 0,
                    'prescription_fee' => $request->prescription_fee,
                    'payment_receiving_process' => $request->payment_receiving_process,
                    'commission_type' => $request->commission_type,
                    'commission' => $request->commission,
                    'created_by' => 1
                ]);

                //Image upload and update path at User
                if (strlen($request->file('profile_image')) > 0) {
                    $folderPath = 'images/doctor/';
                    $fileName = Helper::imageUploadRaw($saveUser, $request->file('profile_image'), $folderPath, 75, 75);
                    if ($fileName != null) {
                        $saveEmployee = User::where('user_id', $saveUser)
                            ->update([
                                'profile_image' => $fileName,
                                'updated_by' => 1
                            ]);
                    }
                }
                Session::flash('success', 'Doctor Addedd Successfull !!');
                DB::commit();
            } else {
                Session::flash('error', 'Something Went Wrong !!');
                DB::rollBack();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // return $e;
            Session::flash('error', $e->errorInfo[2]);
        }
        return redirect()->route('hr.doctor');
    }

    public function doctorList()
    {
        $doctors = Doctor::whereIn('status', [0, 1])
            ->get();
        // return $employee->user->full_name;
        return view('hr.doctor.doctor', compact('doctors'));
    }

    public function editDoctor($doctorId = null)
    {
        $doctor = Doctor::where('user_id', $doctorId)
            ->first();
        $designations = Designation::where('status', 1)
            ->where('designation_type', 1)
            ->pluck('designation_name', 'designation_id');

        $departments = Department::all()->pluck('department_name', 'department_id');

        $educational_qualifications = DB::table('educational_qualifications')->get()->pluck('educational_qualification_name', 'educational_qualification_id');

        $medical_degrees = DB::table('medical_degrees')->get()->pluck('medical_degree_name', 'medical_degree_id');

        return view('hr.doctor.editDoctor', compact('doctor', 'designations', 'departments', 'educational_qualifications', 'medical_degrees'));
    }

    public function test()
    {
        $data = file_get_contents(dirname(__FILE__) . '/old_data/CreateEducational_QualificationsTable.tbl');
        $data = json_decode($data, true);
        if (is_array($data) && count($data) > 0) {
            foreach ($data as $key => $value) {
                $allData = [];

                foreach ($value as $k => $v) {
                    array_push($allData, array($k => $v));
                }

                dd($value);
            }
        }
    }

    public function updateDoctorInfo(Request $request)
    {
        $this->validate($request, [
            'full_name' => 'required',
            'designation' => 'required|numeric',
            'gender' => 'required|numeric',
            'department' => 'required|numeric',
            'educational_qualification' => 'required|numeric',
            'medical_degree' => 'required|numeric',
            'speciality' => 'required',
            'allow_prescription_fee' => 'required',
            'payment_receiving_process' => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            $saveUser = User::where('user_id', $request->user_id)
                ->update([
                    'branch_id' => 1,
                    'full_name' => $request->full_name,
                    'father_name' => $request->father_name,
                    'mother_name' => $request->mother_name,
                    'present_address' => $request->present_address,
                    'permanent_address' => $request->permanent_address,
                    'mobile_no' => $request->mobile_no,
                    'gender' => $request->gender,
                    'dob' => date('Y-m-d', strtotime($request->dob))
                ]);

            if ($saveUser) {
                $saveDoctor = Doctor::where('user_id', $request->user_id)
                    ->update([
                        'designation_id' => $request->designation,
                        'department_id' => $request->department,
                        'educational_qualification_id' => $request->educational_qualification,
                        'medical_degree_id' => $request->medical_degree,
                        'speciality' => $request->speciality,
                        'allow_prescription_fee' => isset($request->allow_prescription_fee) ? 1 : 0,
                        'prescription_fee' => $request->prescription_fee,
                        'payment_receiving_process' => $request->payment_receiving_process,
                        'commission_type' => $request->commission_type,
                        'commission' => $request->commission,
                        'created_by' => 1
                    ]);

                if ($request->hasFile('profile_image')) {
                    $folderPath = 'images/doctor/';
                    $fileName = Helper::imageUploadRaw($saveUser, $request->file('profile_image'), $folderPath, 75, 75);
                    if ($fileName != null) {
                        if (File::exists(public_path($folderPath . $saveUser->profile_image))) {
                            File::delete(public_path($folderPath . $saveUser->profile_image));
                        }
                        User::where('user_id', $request->user_id)
                            ->update([
                                'profile_image' => $fileName,
                                'updated_by' => 1
                            ]);
                    }
                }

                Session::flash('success', 'Doctor Updated Successfull !!');
                DB::commit();
            } else {
                Session::flash('error', 'Something Went Wrong !!');
                DB::rollBack();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $e;
            Session::flash('error', $e->errorInfo[2]);
        }
        return redirect()->route('hr.doctor');
    }

    //======================@@ Doctors Panel End @@===============


    public function scheduleList()
    {
        $schedules = Schedule::whereIn('status', [0, 1])
            ->get();
        // return $employee->user->full_name;
        return view('hr.schedule.schedule', compact('schedules'));
    }

    public function addSchedule()
    {
        $doctors = User::where('user_type', 2)
            ->get()->pluck('full_name', 'user_id');
        return view('hr.schedule.addSchedule', compact('doctors'));
    }

    public function saveScheduleInfo(ScheduleRequest $request)
    {
        DB::beginTransaction();

        try {

            $saveAppointment = Schedule::insertGetId([
                'user_id' => 21,
                'schedule_date' => $request->schedule_date,
                'created_by' => 1
            ]);

            if ($saveAppointment) {

                $start_time = [];

                foreach ($request->start_time as $key => $value) {
                    array_push($start_time, $value);
                }

                $end_time = [];

                foreach ($request->end_time as $key => $value) {
                    array_push($end_time, $value);
                }

                $visitor_limit = [];

                foreach ($request->visitor_limit as $key => $value) {
                    array_push($visitor_limit, $value);
                }

                for ($i = 0; $i < count($start_time); $i++) {

                    ScheduleSlot::insertGetId([
                        'schedule_id' => $saveAppointment,
                        'start_time' => date('H:i:s', strtotime($start_time[$i])),
                        'end_time' => date('H:i:s', strtotime($end_time[$i])),
                        'visitor_limit' => $visitor_limit[$i],
                        'created_by' => 21,
                    ]);

                }

                Session::flash('success', 'Schedule Schedule Addedd Successfull !!');
                DB::commit();
            } else {
                Session::flash('error', 'Something Went Wrong !!');
                DB::rollBack();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // return $e;
            Session::flash('error', $e->errorInfo[2]);
        }
        return redirect()->route('hr.schedule');
    }

    public function editSchedule($scheduleId = null)
    {
        $schedule = Schedule::where('schedule_id', $scheduleId)
            ->first();
        $doctors = User::where('user_type', 2)
            ->get()->pluck('full_name', 'user_id');

        return view('hr.schedule.editSchedule', compact('doctors', 'schedule'));
    }

    public function UpdateScheduleInfo(Request $request)
    {

        $this->validate($request, [
            'schedule_id' => 'required',
            'schedule_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        DB::beginTransaction();
        try {

            $updateSchedule = Schedule::where('schedule_id', $request->schedule_id)
                ->update([
                    'user_id' => $request->user_id,
                    'schedule_date' => $request->schedule_date,
                    'created_by' => 1
                ]);

            if ($updateSchedule) {

                $start_time = [];

                foreach ($request->start_time as $key => $value) {
                    array_push($start_time, $value);
                }

                $end_time = [];

                foreach ($request->end_time as $key => $value) {
                    array_push($end_time, $value);
                }

                $visitor_limit = [];

                foreach ($request->visitor_limit as $key => $value) {
                    array_push($visitor_limit, $value);
                }

                $schedule_slot_id = [];

                foreach ($request->schedule_slot_id as $key => $value) {
                    array_push($schedule_slot_id, $value);
                }

                for ($i = 0; $i < count($start_time); $i++) {

                    ScheduleSlot::where('schedule_slot_id', $schedule_slot_id[$i])
                        ->update([
                            'start_time' => date('H:i:s', strtotime($start_time[$i])),
                            'end_time' => date('H:i:s', strtotime($end_time[$i])),
                            'visitor_limit' => $visitor_limit[$i],
                            'created_by' => 21,
                        ]);

                }

                Session::flash('success', 'Schedule has been Updated Successfull !!');
                DB::commit();
            } else {
                Session::flash('error', 'Something Went Wrong !!');
                DB::rollBack();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // return $e;
            Session::flash('error', $e->errorInfo[2]);
        }
        return redirect()->route('hr.schedule');
    }

    public function blockSchedule()
    {
        $doctors = User::where('user_type', 2)
            ->get()->pluck('full_name', 'user_id');

        return view('hr.schedule.blockSchedule', compact('doctors'));
    }

    public function getSchedule(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
        ]);
        try {
            $schedules = Schedule::where('user_id', $request->user_id)
                ->get();

            if (count($schedules) > 0) {
                $allschedulesdata = [];
                $from_date = new DateTime($request->start_date);
                $to_date = new DateTime($request->end_date);
                $dateArray = [];
                for ($date = $from_date; $date <= $to_date; $date->modify('+1 day')) {
                    array_push($dateArray, array('day' => $date->format('l'), 'date' => $date->format('d-m-Y')));
                }

                $rawData = json_encode($dateArray, JSON_FORCE_OBJECT);
                foreach ($schedules as $schedule) {
                    $rawjson = new Jsonq();
                    $rawjson->json($rawData);
                    $rawjson->from('0');
                    $rawjson->where('day', '=', $schedule->schedule_date);
                    $res = $rawjson->get();
                    foreach ($res as $r) {
                        $r['schedule_obj'] = $schedule;
                        array_push($allschedulesdata, $r);
                    }
                }

                if (count($allschedulesdata) > 0) {
                    $view = view('hr.schedule.table', compact('allschedulesdata'))->render();
                    return response()->json(['success' => true, 'view' => $view, 'message' => 'Update Successfull !']);
//                    return view('hr.appointment.table', compact('allappointmentsdata'));
                } else {
                    return response()->json(['error' => true, 'message' => 'No Data Found.']);
                }
            }

        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->errorInfo[2]]);
        }

    }

    public function updateSchedule(Request $request)
    {
        $this->validate($request, [
            'schedule_slot_id' => 'required',
            'schedule_block_date' => 'required',
        ]);
        try {
            if ($request->type == 0) {
                $ScheduleBlock = ScheduleBlock::firstOrNew([
                        'schedule_slot_id' => $request->schedule_slot_id,
                        'schedule_block_date' => date('Y-m-d', strtotime($request->schedule_block_date))
                    ]
                );
                $ScheduleBlock->created_by = 1;
                $ScheduleBlock->save();
                return response()->json(['success' => true, 'message' => 'Appointment has been blocked.']);
            } else {
                ScheduleBlock::where('schedule_slot_id', $request->schedule_slot_id)
                    ->where('schedule_block_date', date('Y-m-d', strtotime($request->schedule_block_date)))->delete();
                return response()->json(['success' => true, 'message' => 'Schedule has been removed from block list.']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->errorInfo[2]]);
        }
    }

    public function updateScheduleStatus($action, $scheduleId = null)
    {
        DB::beginTransaction();
        try {
            $schedule_block = [];
            $schedule = Schedule::where('schedule_id', $scheduleId)
                ->update([
                    'status' => Helper::getStatus($action),
                    'updated_by' => 1,
                ]);

            if ($schedule) {

                $schedule_slot = ScheduleSlot::where('schedule_id', $scheduleId)
                    ->update([
                        'status' => Helper::getStatus($action),
                        'updated_by' => 1,
                    ]);

                if ($schedule_slot) {

                    $schedule_slot_array = ScheduleSlot::where('schedule_id', $scheduleId)->get();

                    if (is_array($schedule_slot_array) && count((array)$schedule_slot_array) > 0) {

                        foreach ($schedule_slot_array as $slot) {

                            $schedule_block[] = ScheduleBlock::where('schedule_slot_id', $slot->schedule_slot_id)
                                ->update([
                                    'status' => Helper::getStatus($action),
                                    'updated_by' => 1,
                                ]);
                        }

                        if (in_array(false, $schedule_block)) {
                            DB::rollBack();
                        } else {
                            DB::commit();
                            return response()->json(['success' => true, 'message' => ucwords($action) . ' Successfull !']);
                        }

                    } else {

                        DB::commit();
                        return response()->json(['success' => true, 'message' => ucwords($action) . ' Successfull !']);
                    }

                } else {
                    DB::rollBack();
                }
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->errorInfo[2]]);
        }
    }

}
