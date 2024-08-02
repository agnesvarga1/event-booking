<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\MeetingRoom;
use Inertia\Inertia;
use Carbon\Carbon;

class WeeklyScheduleController extends Controller
{
    //

    public function index()
    {
        $now = Carbon::now();
        $weekStart = $now->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');
        $weekEnd = $now->endOfWeek(CARBON::SATURDAY)->format('Y-m-d');
        //dd($weekStart,$weekEnd);
        $events = Event::where(function($query) use ($weekStart, $weekEnd) {
            $query->whereBetween('start_date', [$weekStart, $weekEnd])
                  ->orWhereBetween('end_date', [$weekStart, $weekEnd]);
        })->with('meetingroom')->get();
        //dd($events);
        return Inertia::render('Events/WeeklyView', [
            'events' => $events
        ]);
    }

    public function handlePost(Request $request)
    {
        //dd($request);

        $weekStart = Carbon::parse($request->startOfWeek);
        $weekEnd =Carbon::parse($request->endOfWeek);
       // dd($weekStart,$weekEnd);
        $events = Event::where(function($query) use ($weekStart, $weekEnd) {
            $query->whereBetween('start_date', [$weekStart, $weekEnd])
                  ->orWhereBetween('end_date', [$weekStart, $weekEnd]);
        })->with('meetingroom')->get();
        //dd($events);
        return Inertia::render('Events/WeeklyView', [
            'events' => $events
        ]);
    }
}


