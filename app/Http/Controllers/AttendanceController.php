<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Attendance,Leave,Role,User,LeaveType};
use Carbon\Carbon;
use Auth;

class AttendanceController extends Controller
{
    //

    public function index(Request $request)
    {

        $attendances=Attendance::where('emp_id',Auth::user()->id)->orderby('id','desc')->paginate(15);
        foreach ($attendances as $attendance) 
        {
            $workingTime = $this->calculateWorkingHours($attendance->time_in, $attendance->time_out);
            $attendance->working_hours = $workingTime['hours'];
            $attendance->working_minutes = $workingTime['minutes'];
        }
       
        return view('attendance.index',compact('attendances'));

    }

    public function calculateWorkingHours($timeIn, $timeOut)
    {

        $startTime = \Carbon\Carbon::parse($timeIn);
        $endTime = \Carbon\Carbon::parse($timeOut);

        $diffInHours = $endTime->diffInHours($startTime);
        $diffInMinutes = $endTime->diffInMinutes($startTime) % 60;

        return [
            'hours' => $diffInHours,
            'minutes' => $diffInMinutes,
        ];

    }

    public function Attendance_In_Store(Request $request)
    {
        
        $date_time_input = $request->input('punch_in_time');

        // Parse the input string as a Carbon instance
        $carbonInstance = Carbon::parse($date_time_input);

        // Separate date and time
        $date = $carbonInstance->toDateString(); // Output: '2023-12-14'
        $time = $carbonInstance->toTimeString(); // Output: '17:13:00'


        $params['emp_id']  = $request->employee_id;
        $params['date']    = $date;
        $params['time_in'] = $time;

        Attendance::create($params);

        return back()->with('success','Attendance marked successfully');


    }



    public function Attendance_Out_Store(Request $request)
    {

        $date_time_input = $request->input('punch_out_time');

        // Parse the input string as a Carbon instance
        $carbonInstance = Carbon::parse($date_time_input);

        // Separate date and time
        $date = $carbonInstance->toDateString(); // Output: '2023-12-14'
        $time = $carbonInstance->toTimeString(); // Output: '17:13:00'

        $attendance = Attendance::where('emp_id', $request->employee_id)->whereDate('date',$date)->first();

        $attendance->update([
            'time_out' => $time
        ]);

        return back()->with('success','Attendance marked successfully');

    }


    public function Monthly_Attendance_Index(Request $request)
    {

        $adminRole = Role::where('name', 'Admin')->first();
        $employeeRole = Role::where('name','Employee')->first();

        if(Auth::user()->role==$adminRole->id)
        {
            
            if($request->employee_id)
            {
              

                $attendances=Attendance::where('emp_id',$request->employee_id)->whereYear('date',$request->year)->whereMonth('date',$request->month)->orderBy('id','DESC')->paginate(15);

                foreach ($attendances as $attendance) 
                {
                    $workingTime = $this->calculateWorkingHours($attendance->time_in, $attendance->time_out);
                    $attendance->working_hours = $workingTime['hours'];
                    $attendance->working_minutes = $workingTime['minutes'];
                }

            }

            else
            {

                $attendances=0;

            }

            $users=User::where('role',$employeeRole->id)->get();

            return view('attendance.monthly_attendance',compact('attendances','users','request'));


        }

        else
        {

            if($request->employee_id)
            {
            

                $attendances=Attendance::where('emp_id',$request->employee_id)->whereYear('date',$request->year)->whereMonth('date',$request->month)->orderBy('id','DESC')->paginate(15);

                foreach ($attendances as $attendance) 
                {
                    $workingTime = $this->calculateWorkingHours($attendance->time_in, $attendance->time_out);
                    $attendance->working_hours = $workingTime['hours'];
                    $attendance->working_minutes = $workingTime['minutes'];
                }

            }

            else
            {

                $attendances=0;

            }

            $users=0;


            return view('attendance.monthly_attendance',compact('attendances','users','request'));


        }



    }


    public function Attendance_Details($id)
    {
        $e_id=decrypt($id);
        return view('attendance.details',compact('attendances'));

    }


    public function Leave_Index(Request $request)
    {
        $adminRole = Role::where('name', 'Admin')->first();

        if(Auth::user()->role==$adminRole->id)
        {   
            $leave= Leave::select();
            $users= User::get(['id','name']);
        }

        else
        {
            $leave= Leave::where('emp_id', Auth::user()->id)->select();
            $users=0;
        }

        if($request->user)
        {
            $leave->where('emp_id',$request->user);
        }

        $leaves=$leave->orderby('id','desc')->get();
        
        return view('leave.index',compact('leaves','users','request')); 

    }

    public function Leave_Create()
    {
        $leaveType=LeaveType::get();
        return view('leave.create',compact('leaveType'));


    }

    public function Leave_Store(Request $request)
    {

        
        $startDate = Carbon::parse($request->application_start_date);
        $endDate = Carbon::parse($request->application_end_date);
        
        $dayDifference = $endDate->diffInDays($startDate);

        $apply_day = $dayDifference+1;

        if($request->hasFile('application_hardcopy'))
        {

            $file=$request->file('application_hardcopy');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('/leave'), $filename);

            $params['application_hardcopy'] = $filename;

        }



        $params['emp_id']                       = $request->employee_id;
        $params['leave_type']                   = $request->leave_type;
        $params['application_start_date']       = $request->application_start_date;
        $params['application_end_date']         = $request->application_end_date;
        $params['reason']                       = $request->reason;
        $params['approve_start_date']           = $request->approve_start_date;
        $params['approve_end_date']             = $request->approve_end_date;
        $params['approve_by']                   = $request->approve_by;
        $params['apply_day']                    = $apply_day;
        $params['approve_day']                  = $request->approve_day;

        Leave::create($params);

        return redirect('employee/leaves')->with('success','Application Submit successfully');

    }


    public function Leave_Type_Index()
    {

        $leaves=LeaveType::orderby('id','desc')->paginate(15);

        return view('leave_type.index',compact('leaves'));


    }

    public function Leave_Type_Create()
    {

        return view('leave_type.create');
    }

    public function Leave_Type_Store(Request $request)
    {
       

        $params['leave_name']=$request->leave_name;
        $params['no_of_days']=$request->no_of_days;

        LeaveType::create($params);

        return redirect('leave_types/index/')->with('success','Leave Type Created Successfully');

    }

    public function Leave_Type_Edit($id)
    {
       

        $leave=LeaveType::find($id);

        return view('leave_type.edit',compact('leave'));

    }

    public function Leave_Type_Update($id,Request $request)
    {
        

        $leave=LeaveType::find($id);

        $leave->update([
            'leave_name'=>$request->leave_name,
            'no_of_days'=>$request->no_of_days
        ]);

        return redirect('leave_types/index/')->with('success','Leave Type Edit Successfully');

    }


}
