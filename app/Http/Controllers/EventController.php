<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\MeetingRoom;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with('meetingroom')->get();
        return Inertia::render('Events/IndexEvents', ['events' => $events]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Events/CreateEvent');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->color);
        $data = $request->validate([
             'name' => 'required|string|max:50|unique:'.Event::class,
             'description' => 'nullable|string|max:700',
             'color' => ['nullable','string','max:7','regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
             'image' => 'nullable|mimes:jpg,bmp,png,pdf',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'meeting_room_id' => 'required|exists:meeting_rooms,id',
        ]);
         $slug = Str::slug($data['name']);

         if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public'); // Store in public disk
            $data['image'] = $path;
        }

        $data['slug']= $slug;
       $event =  Event::create($data);
        return Inertia::location(route('dashboard.events.show', $event->slug));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
      $event->load('meetingroom');
     // $event = Event::with('meetingroom')->find($event->id);

      // dd($event);
        return Inertia::render('Events/SingleEvent',[ 'event'=>$event]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
