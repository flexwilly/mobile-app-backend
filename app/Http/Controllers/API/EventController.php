<?php

namespace App\Http\Controllers\API;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get all tickets
        $events = Event::latest()->get();

        return response()->json([
            'events'=>$events,
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'event_name'=>'required|max:100',
            'event_description'=>'required|max:100',
            'event_date'=>'required|date',
        ]);

        if($validator->fails()){
            return response()->json([
                'message'=>'Validation error',
                'errors'=>$validator->errors()
            ],401);
        }

        Event::create($request->all());

        return response()->json([
            'message'=>'Event created. ',
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
        return response()->json(
            [
                'event'=>$event,
            ],200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
        $validator = Validator::make($request->all(),[
            'event_name'=>'required|max:100',
            'event_description'=>'required|max:100',
            'event_date'=>'required|date',
        ]);

        if($validator->fails()){
            return response()->json([
                'message'=>'Validation error. ',
                'errors'=>$validator->errors()
            ],401);
        }

        $input = $request->all();

        $event->update($input);

        return response()->json([
            'message'=>'Event updated. ',
        ],200);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //delete an event
       $event->delete();

        return response()->json([
            'message'=>'Event deleted. ',
        ],200);
    }
}
