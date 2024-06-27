<?php

namespace App\Http\Controllers;

use App\Models\MeetingRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
//use Inertia\Response;

class MeetingRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meetingrooms = MeetingRoom::all();
        return Inertia::render('MeetingRooms/Index', ['meetingrooms' => $meetingrooms]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('MeetingRooms/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $data = $request->validate([
            'name' => 'required|string|max:50|unique:'.MeetingRoom::class,
            'description' => 'string|max:700',
            'available_places' => 'required|integer|max:2000'
        ]);


        $data['name']= 'Room-'.$request->name;
        $slug = MeetingRoom::generateSlug($data['name']);
        $data['slug']= $slug;

        MeetingRoom::create($data);
        return to_route('dashboard.meetingrooms.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(MeetingRoom $meetingRoom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MeetingRoom $meetingRoom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MeetingRoom $meetingRoom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MeetingRoom $meetingRoom)
    {
        //
    }
}
