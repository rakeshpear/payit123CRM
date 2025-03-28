<?php

namespace App\Http\Middleware;
use App\Models\Timer;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecordUserTime
{
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $timer = Timer::where('user_id', $user->id)->latest()->first();

            if ($request->is('logout')) {
                // User is logging out
                if ($timer && !$timer->end_time) {

                    $start_time = $timer->start_time;
                    $end_time = now();

                    $total_minutes = $end_time->diffInMinutes($start_time); 

                    $timer->update([
                        'end_time' => $end_time,
                        'total_hours' => $total_minutes,
                    ]);
                }
            } elseif (!$timer || $timer->end_time) {
                // User is logging in or creating a new session
                Timer::create([
                    'user_id' => $user->id,
                    'start_time' => now(),
                    'date' => now(),
                ]);
            }
        }

    return $next($request);
}

}