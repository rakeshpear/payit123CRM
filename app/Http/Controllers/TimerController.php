<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timer;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;

class TimerController extends Controller
{
    public function index(Request $request)
    {

    $excludeRoleIds = Role::whereIn('name', ['Admin', 'Super Admin'])->pluck('id')->toArray();

    $users = User::whereNotIn('role', $excludeRoleIds)->get();

    $usersIds = $users->pluck('id')->toArray();


    $timers = Timer::whereIn('user_id', $usersIds)->paginate(20);

    return view('timer.index', compact('timers', 'request'));
}

    public function index11(Request $request)
    {

        $excludeRoleIds = Role::whereIn('name', ['Admin', 'Super Admin'])->pluck('id')->toArray();

        $users = User::whereNotIn('role', $excludeRoleIds)->get();

        $usersIds = $users->pluck('id')->toArray();

        // Get the current date
        $currentDate = Carbon::now()->toDateString();

        // Get the previous date
        $previousDate = Carbon::now()->subDay()->toDateString();

        $timers = Timer::whereIn('user_id', $usersIds)
            ->whereBetween('date', [$previousDate, $currentDate])
            ->select('user_id', 'date',
                DB::raw('SUM(total_hours) as total_hours'),
                DB::raw('MIN(start_time) as start_time'),
                DB::raw('MAX(end_time) as end_time'))
            ->groupBy('user_id', 'date')
            ->paginate(10);

        return view('timer.index', compact('timers', 'request'));
    }


    public function startTimer(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $timer = Timer::where('user_id', $user->id)->latest()->first();

            // Check if there is an active timer or if the user has no timers
            if (!$timer || $timer->end_time) {
                Timer::create([
                    'user_id' => $user->id,
                    'start_time' => now(),
                    'date' => now(),
                ]);
            }
        }

        return response()->json(['message' => 'Timer started']);
    }

    public function stopTimer(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $timer = Timer::where('user_id', $user->id)->latest()->first();

            if ($timer && !$timer->end_time) {
                $start_time = $timer->start_time;
                $end_time = now();
                $total_minutes = $end_time->diffInMinutes($start_time);

                $timer->update([
                    'end_time' => $end_time,
                    'total_hours' => $total_minutes,
                ]);
            }
        }

        return response()->json(['message' => 'Timer stopped']);
    }
}
