<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Attendance,Leave,TaskWorkingHours,Task,Timer,User,State,District,City,EmployeeDetails};
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DateTime;
use DatePeriod;
use DateInterval;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rolesToInclude = ['Employee'];

        $users = User::whereHas('role', function ($query) use ($rolesToInclude) {
            $query->whereIn('name', $rolesToInclude);
        })->orderBy('id', 'desc')->paginate(10);

        return view('employee.index', compact('users', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $roles = Role::where('name','Employee')->first();

        return view('employee.create',compact('roles'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
             'name'         =>'required',
             'role'         =>'required',
             'email'        =>'required|email|unique:users',
             'password'     =>'required',
        ]);

        $params['name'] = $request->name;
        $params['role'] = $request->role;
        $params['email'] = $request->email;
        $params['phone'] = $request->phone;
        $params['password'] = Hash::make($request->password);
        $user= User::create($params);
        if($user)
        {
            $data['emp_id']=$user->id;
            $data['currency']=$request->currency;
            $data['cost']=$request->cost;
            EmployeeDetails::create($data);

        }
        $user->assignRole($request->role);

        return redirect('/employee/users')->with('success', 'Employee Create successfully.');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $id=decrypt($id);
        $user= User::find($id);
        $emp_info=EmployeeDetails::where('emp_id',$user->id)->first();

        if(!empty($emp_info)){
            $user->currency=$emp_info->currency;
            $user->cost=$emp_info->cost;
        }
        
        return view('employee.edit',compact('user'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
             'name'         =>  'required',
             'email'        =>  'required|email|unique:users,email,'.$id,
        ]);

        $user= User::find($id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        $user->update($data);

        if($user)
        {
            $emp_info= EmployeeDetails::where('emp_id',$user->id)->first();

            $info=[

                'currency'=>$request->currency,
                'cost'=>$request->cost
            ];

            $emp_info->update($info);

        }
       
        return redirect('employee/users')->with('success', 'Employee updated successfully.');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $id=decrypt($id);

        $emp_info=EmployeeDetails::where('emp_id',$id)->first();

        $emp_info->delete();

        $user=User::find($id);

        $user->delete();

        return redirect('employee/users')->with('error','Employee deleted successfully.');
    }

    public function User_Viewmore($id)
    {
        $id = decrypt($id);

        $users = User::find($id);

        if (!$users) {
            return redirect()->route('error.page')->with('message', 'Employee not found');
        }

        $tasks = Task::where('assign_to', $users->id)->orderBy('created_at', 'desc')->get();

        $revenue=0;


        $totalcost=EmployeeDetails::where('emp_id',$id)->first();

        $totalhours = 0;

        foreach ($tasks as $task) 
        {
            $task_hours=0;

            $workingHours = TaskWorkingHours::where('task_id', $task->id)->pluck('hours');

            foreach ($workingHours as $hour) 
            {

                if (!empty($hour)) 
                {
                    $totalhours += $this->convertToMinutes($hour);
                    $task_hours += $this->convertToMinutes($hour);
                }

            }

            $task->taskhours=$this->convertToHoursAndMinutes($task_hours);
            

            $task->taskcost = $this->costCalculation($task->taskhours, $task->cost);

        }

        $totalhours = $this->convertToHoursAndMinutes($totalhours);

        $sdate=date("Y-m-d", strtotime(" -1 months"));
        $edate=date('Y-m-d');

        $attendances = Attendance::where('emp_id',$users->id)->get();

        if($attendances)
        {
                $leave_dates=$this->getDatesFromRange($sdate, $edate);


                 $atten_date = array();
                 foreach ($attendances as $row)
                 {
                    $atten_date[]=$row->date;
                    $row->day=$day = date('l', strtotime($row->date));
                    $row->label='';
                 }

                 $date_range = array_merge(array_diff($leave_dates, $atten_date));

                 $attendances=array();

                 foreach ($leave_dates as $leave_value) {

                    if(in_array($leave_value,$atten_date))
                    {
                        $attend = Attendance::where('emp_id',$users->id)->whereDate('date', $leave_value)->first();
                        $day = date('l', strtotime($leave_value));
                        $attendances[] = (object) array( 'id'=>'', 'user_id'=>$users->id, 'date' => $leave_value, 'time_in'=>$attend->time_in, 'time_out'=>$attend->time_out,'time_status'=>'',  'day' => $day, 'label' => 'Attendance' );
                    }

                    // elseif( !in_array( $leave_value, $date_range ))
                    // {
                    //     continue;
                    // }

                    elseif( date('l', strtotime($leave_value)) == 'Sunday' ){
                        $attendances[] = (object) array( 'id'=>'', 'user_id'=>$users->id, 'date' => $leave_value, 'time_in'=>'', 'time_out'=>'','time_status'=>'',  'day' => 'Sunday', 'label' => 'Holiday' );
                    }

                    else
                    {

                        $leave_check=Leave::where('emp_id',$users->id)->where('application_start_date','<=', $leave_value)->where('application_end_date','>=', $leave_value)->get();



                        // if($leave_check)
                        if(count($leave_check)!=0)
                        {
                            $day = date('l', strtotime($leave_value));
                            $attendances[] = (object) array( 'id'=>'', 'user_id'=>$users->id, 'date' => $leave_value, 'time_in'=>'', 'time_out'=>'','time_status'=>'', 'day' => $day, 'label' => 'Leave' );
                        }
                        else
                        {
                            $day = date('l', strtotime($leave_value));
                            $attendances[] = (object) array('id'=>'', 'user_id'=>$users->id, 'date' => $leave_value, 'time_in'=>'', 'time_out'=>'','time_status'=>'', 'day' => $day, 'label' => 'Absent' );
                        }
                    }
                 }

                $totalHours = 0;
                $totalMinutes = 0; 

                $wek=array();
                foreach ($attendances as $key => $row)
                {

                    $wek[$key]  = $row->date;

                    $workingTime = $this->calculateWorkingHours($row->time_in, $row->time_out);

                    // Accumulate hours and minutes
                    $totalHours += $workingTime['hours'];
                    $totalMinutes += $workingTime['minutes'];

                    // If total minutes exceed 60, convert excess minutes to hours
                    $totalHours += floor($totalMinutes / 60);
                    $totalMinutes = $totalMinutes % 60;

                }

                $t_hours=sprintf('%02d', $totalHours);

                $t_minutes=sprintf('%02d', $totalMinutes);
                

        }
        else
        {
            $t_hours = 0;
            $t_minutes = 0; 
        }


        $timers = Timer::where('user_id',  $users->id)->orderBy('created_at', 'desc')->get();
           
        return view('employee.view_more', compact('users', 'tasks','timers','totalhours','revenue','t_hours','t_minutes','totalcost'));
    }

    function costCalculation($time,$hourlyRate)
    {

        list($hours, $minutes) = explode(':', $time);
        $totalHours = $hours + ($minutes / 60);

        $cost = $totalHours * $hourlyRate;

        return $cost;

    }

    function convertToMinutes($time)
    {

        list($hours, $minutes) = explode(':', $time);
        return $hours * 60 + $minutes;

    }

    function convertToHoursAndMinutes($totalMinutes)
    {

        $totalHours = floor($totalMinutes / 60);
        $remainingMinutes = $totalMinutes % 60;

        return sprintf("%02d:%02d", $totalHours, $remainingMinutes);

    }


    public function Attendance_index($id,Request $request)
    {

        $u_id=decrypt($id);

        if($request->month)
        {
            if($request->year)
            {

                $month = $request->month; 
                $year = $request->year;

                $date = Carbon::create($year, $month, 1);

            }

            else
            {
                $month = $request->month; 
                $year = Carbon::now()->year;

                $date = Carbon::create($year, $month, 1);
            }
            
            $sdate = $date->toDateString();
            $edate = $date->endOfMonth()->toDateString();

        }

        else
        {

            $sdate=date("Y-m-d", strtotime(" -1 months"));
            $edate=date('Y-m-d');

        }
        
        $user_id=User::find($u_id);

        $attendances = Attendance::where('emp_id',$user_id->id)->get();

        if($attendances)
        {
            $leave_dates=$this->getDatesFromRange($sdate, $edate);


                 $atten_date = array();
                 foreach ($attendances as $row)
                 {
                    $atten_date[]=$row->date;
                    $row->day=$day = date('l', strtotime($row->date));
                    $row->label='';
                 }

                 $date_range = array_merge(array_diff($leave_dates, $atten_date));



                 $attendances=array();

                 foreach ($leave_dates as $leave_value) {

                    if(in_array($leave_value,$atten_date))
                    {
                        $attend = Attendance::where('emp_id',$user_id->id)->whereDate('date', $leave_value)->first();
                        $day = date('l', strtotime($leave_value));
                        $attendances[] = (object) array( 'id'=>'', 'user_id'=>$user_id->id, 'date' => $leave_value, 'time_in'=>$attend->time_in, 'time_out'=>$attend->time_out,'time_status'=>'',  'day' => $day, 'label' => 'Attendance' );
                    }

                    // elseif( !in_array( $leave_value, $date_range ))
                    // {
                    //     continue;
                    // }

                    elseif( date('l', strtotime($leave_value)) == 'Sunday' ){
                        $attendances[] = (object) array( 'id'=>'', 'user_id'=>$user_id->id, 'date' => $leave_value, 'time_in'=>'', 'time_out'=>'','time_status'=>'',  'day' => 'Sunday', 'label' => 'Holiday' );
                    }

                    else
                    {

                        $leave_check=Leave::where('emp_id',$user_id->id)->where('application_start_date','<=', $leave_value)->where('application_end_date','>=', $leave_value)->get();



                        // if($leave_check)
                        if(count($leave_check)!=0)
                        {
                            $day = date('l', strtotime($leave_value));
                            $attendances[] = (object) array( 'id'=>'', 'user_id'=>$user_id->id, 'date' => $leave_value, 'time_in'=>'', 'time_out'=>'','time_status'=>'', 'day' => $day, 'label' => 'Leave' );
                        }
                        else
                        {
                            $day = date('l', strtotime($leave_value));
                            $attendances[] = (object) array('id'=>'', 'user_id'=>$user_id->id, 'date' => $leave_value, 'time_in'=>'', 'time_out'=>'','time_status'=>'', 'day' => $day, 'label' => 'Absent' );
                        }
                    }
                 }

                $totalHours = 0;
                $totalMinutes = 0; 

                $wek=array();
                foreach ($attendances as $key => $row)
                {

                    $wek[$key]  = $row->date;

                    $workingTime = $this->calculateWorkingHours($row->time_in, $row->time_out);

                    // Accumulate hours and minutes
                    $totalHours += $workingTime['hours'];
                    $totalMinutes += $workingTime['minutes'];

                    // If total minutes exceed 60, convert excess minutes to hours
                    $totalHours += floor($totalMinutes / 60);
                    $totalMinutes = $totalMinutes % 60;

                }

                $t_hours=sprintf('%02d', $totalHours);

                $t_minutes=sprintf('%02d', $totalMinutes);


                // // Sort the data with wek ascending order, add $mar as the last parameter, to sort by the common key
                array_multisort($wek, $attendances);

                

        }
        else
        {
            $attendances=0;
            $t_hours = 0;
            $t_minutes = 0; 
        }
       
        return view('attendance.all_user_attendance',compact('attendances','request','t_hours','t_minutes'));
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



    // Function to get all the dates in given range
    public function getDatesFromRange($start, $end, $format = 'Y-m-d')
    {

            // Declare an empty array
            $array = array();
            // Variable that store the date interval
            // of period 1 day
            $interval = DateInterval::createFromDateString('1 day');
            $realEnd = new DateTime($end);
            $realEnd->add($interval);
            $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
            // Use loop to store date into array
            foreach($period as $date) {
                $array[] = $date->format($format);
            }
            // Return the array elements
            return $array;
    }

}


