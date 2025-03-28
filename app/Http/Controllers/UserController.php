<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Timer;
use App\Models\{Task,TaskWorkingHours,Comment,CommissionSchedule,Charges,Payment};
use App\Models\AgentSettlementLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
use Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    public function index(Request $request)
    {
        $rolesToExclude = ['Employee','Agent','Customer'];

        $users = User::whereDoesntHave('role', function ($query) use ($rolesToExclude) {
            $query->whereIn('name', $rolesToExclude);
        })->orderBy('id', 'desc')->paginate(10);

        return view('user.index', compact('users', 'request'));
    }


    public function create()
    {
        $roles = Role::whereNotIn('name',['Customer'])->get();
        return view('user.create',compact('roles'));
    }

    public function store(Request $request)
    {
        $params['name'] = $request->name;
        $params['role'] = $request->role;
        $params['email'] = $request->email;
        $params['phone'] = $request->phone;
        $params['password'] = Hash::make($request->password);
        $user=User::create($params);
        $user->assignRole($request->role);
        return redirect('users')->with('success', 'User Create successfully.');
    }

    public function edit($id)
    {
        $id=decrypt($id);
        $user= User::find($id);
        $roles = Role::whereNotIn('name',['Customer'])->get();
        return view('user.edit',compact('user','roles'));
    }

    
    public function update(Request $request, $id)
    {
       
        $user= User::find($id);

        $data = [
            'name' => $request->name,
            'role' => $request->role,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        $user->update($data);
        $user->assignRole($request->role);
        return redirect('users')->with('success', 'User updated successfully.');
    }


    public function delete($id)
    {
        $id=decrypt($id);

        $user=User::find($id);

        $user->delete();

        return redirect('users')->with('error','User deleted successfully.');
    }

    public function User_Viewmore($id)
    {
        $id = decrypt($id);

        $users = User::find($id);

        if (!$users) {
            return redirect()->route('error.page')->with('message', 'User not found');
        }

        $tasks = Task::where('assign_to', $users->id)->orderBy('created_at', 'desc')->get();

        $revenue=0;

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

        $timers = Timer::where('user_id',  $users->id)->orderBy('created_at', 'desc')->get();
           
        return view('user.view_more', compact('users', 'tasks','timers','totalhours','revenue'));
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


    public function Save_Task_Working_Hours(Request $request)
    {

        $params['task_id'] = $request->input('task_id');
        $params['hours'] = $request->input('hours');
        $params['user_id']=Auth::user()->id;
        TaskWorkingHours::create($params);
        return back()->with('success', 'Working Hours Saved Successfully');
        // return response()->json(['success' => 'Working Hours Saved Successfully']);
       

    }


    public function index_Agent(Request $request)
    {

        $rolesToInclude = ['Agent'];
        
        if(Auth::check() && Auth::user()->getRoleNames()[0] && Auth::user()->getRoleNames()[0]=='Agent'){

            $users = Auth::user();

            if (!$users) 
            {
                return redirect()->route('error.page')->with('message', 'User not found');
            }

            $customer_payments=[];


            if($users->customers!=null)
            {
                foreach(json_decode($users->customers, true) as $customer)
                {

                    $payments=Payment::where('customer',$customer)->get();
                    foreach($payments as $payment)
                    {

                        array_push($customer_payments,$payment);

                    }
                    
                }
            }

            $agent_client=User::where('registered_by',$users->id)->count();

            $revenue=0;

            $timers = Timer::where('user_id',  $users->id)->orderBy('created_at', 'desc')->get();
               
            return view('user.agent_view_more', compact('users','timers','revenue','customer_payments','agent_client'));

        } else {

            $users = User::whereHas('role', function ($query) use ($rolesToInclude) {
                $query->whereIn('name', $rolesToInclude);
            })->orderBy('id', 'desc')->paginate(10);

             $agentSettlementLogs = AgentSettlementLog::get() ?? collect();
             
            //  dd($agentSettlementLogs);

            return view('user.index-agent', compact('users', 'request', 'agentSettlementLogs'));

        }        

    }

    public function create_Agent()
    {

        $roles = Role::where('name','Agent')->first();

        $rolesToInclude = ['Customer'];

        $customers=User::whereHas('role', function ($query) use ($rolesToInclude) {
            $query->whereIn('name', $rolesToInclude);
        })->orderBy('id', 'desc')->get();

        return view('user.create-agent',compact('roles','customers'));

    }

    public function store_Agent(Request $request)
    {
    
        $params['name'] = $request->name;
        $params['role'] = $request->role;
        $params['email'] = $request->email;
        $params['phone'] = $request->phone;
        $params['commission'] = $request->commission;
        $params['payout'] = $request->payout;
        $params['amount_limit'] = $request->amount_limit;
        $params['password'] = Hash::make($request->password);
        $params['commission_schedule']=$request->commission_schedule;

        if ($request->has('customers')) {
            $params['customers'] = json_encode($request->input('customers'));
        }

        $user=User::create($params);
        $user->assignRole($request->role);
        return redirect('/agent/users')->with('success', 'Agent Create successfully.');

    }

    public function edit_Agent($id)
    {
        $id=decrypt($id);
        $user= User::find($id);

        $rolesToInclude = ['Customer'];

        $customers=User::whereHas('role', function ($query) use ($rolesToInclude) {
            $query->whereIn('name', $rolesToInclude);
        })->orderBy('id', 'desc')->get();
        return view('user.edit-agent',compact('user','customers'));
    }

    public function update_Agent(Request $request,$id)
    {
        $user= User::find($id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'commission' => $request->commission,
            'payout' => $request->payout,
            'amount_limit' => $request->amount_limit,
            'commission_schedule' => $request->commission_schedule,
        ];

        if ($request->has('customers')) {
            $data['customers'] = json_encode($request->input('customers'));
        }

        $user->update($data);
        // $user->assignRole($request->role);
        return redirect('/agent/users')->with('success', 'Agent updated successfully.');
    }

    public function Agent_Viewmore($id)
    {
        $id = decrypt($id);

        $users = User::find($id);

        if (!$users) 
        {
            return redirect()->route('error.page')->with('message', 'User not found');
        }

        $customer_payments=[];


        if($users->customers!=null)
        {
            foreach(json_decode($users->customers, true) as $customer)
            {

                $payments=Payment::where('customer',$customer)->get();
                foreach($payments as $payment)
                {

                    array_push($customer_payments,$payment);

                }
                
            }
        }

        $agent_client=User::where('registered_by',$id)->count();

        
        $revenue=0;


        $timers = Timer::where('user_id',  $users->id)->orderBy('created_at', 'desc')->get();
           
        return view('user.agent_view_more', compact('users','timers','revenue','customer_payments','agent_client'));
    }

    public function delete_Agent($id)
    {
        $id=decrypt($id);

        $user=User::find($id);

        $user->delete();

        return back()->with('error','Agent deleted successfully.');

    }

    public function Agent_Setting()
    {
        $fixed_commission=CommissionSchedule::where('type','Fixed')->first();

        $scalable_commission=CommissionSchedule::where('type','Scalable')->get();

        $charges=Charges::get();

        return view('setting.index',compact('fixed_commission','scalable_commission','charges'));

    }

    public function Commission_Update(Request $request)
    {
        

        if($request->fixed_commission_id)
        {

            $comm=CommissionSchedule::find($request->fixed_commission_id)
            ->update([

                'rate'=>$request->rate,
            ]);

            return back()->with('success','Fixed Commission Updated Successfully');

        }
        else
        {

            foreach($request->addmore as $commission)
            {
               

                $comm=CommissionSchedule::find($commission['commission_id'])
                ->update([

                    'rate'=>$commission['rate'],
                    'volume_from'=>$commission['volume_from'],
                    'volume_to'=>$commission['volume_to'],

                ]);
                
            }

            return back()->with('success','Scalable Commission Updated Successfully');

        }

    }

    public function Charges_Update(Request $request)
    {

        foreach($request->addcharges as $charges)
            {
               

                $charge=Charges::find($charges['charges_id'])
                ->update([

                    'fixed_amt'=>$charges['fixed_amt'],
                    'percent_amt'=>$charges['percent_amt'],

                ]);
                
            }

            return back()->with('success','Charges Updated Successfully');

    }

}

