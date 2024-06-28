<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\MeetingRoom;
use Inertia\Inertia;

class FilterController extends Controller
{
    public function filter(Request $request){
        $data = $request->validate([
            // 'name' => 'required|string|max:50|unique:'.Event::class,
            // 'description' => 'string|max:700',
            // 'image' => 'mimes:jpg,bmp,png,pdf',
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);
    $startDate = $data['start_date'];
    $endDate = $data['end_date'];
   // dd($startDate,$endDate );
     //return free rooms logic
        $availableRooms = MeetingRoom::whereDoesntHave('events', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('start_date', [$startDate, $endDate])
                  ->orWhereBetween('end_date', [$startDate, $endDate])
                  ->orWhere(function ($query) use ($startDate, $endDate) {
                      $query->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                  });
        })->get();
    //  dd($availableRooms);



    return Inertia::render('Events/CreateEvent', [
        'meetingrooms' => $availableRooms,
    ]);
    }
}
