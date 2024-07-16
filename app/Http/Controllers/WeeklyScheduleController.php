<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\MeetingRoom;
use Inertia\Inertia;

class WeeklyScheduleController extends Controller
{
    //

    public function index()
    {

        return Inertia::render('Events/WeeklyView');
    }
}
