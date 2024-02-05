<?php

namespace App\Http\Controllers\API;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tickets = Ticket::latest()->get();

        return response()->json(
            [
                'tickets'=>$tickets,
            ],200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'order_by'=>'required|integer',
            'event_id'=>'required|integer',
            'order_number'=>'required|string',
            'quantity'=>'required|integer',
            'unit_price'=>'required|integer',

        ]);



        if($validator->fails()){
             return response()->json(
                [
                    'message'=>'Validation error',
                    'error'=>$validator->errors(),
                ],401
             );
        }

        $input = $request->all();
        $input['cost'] = $input['quantity'] * $input['unit_price'];

        Ticket::create($input);

        return response()->json([
            'message'=>'Ticket created. ',
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        //
        return response()->json(
            [
                'ticket'=>$ticket
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
        $validator = Validator::make($request->only('status'),[
            'status'=>'required|string',
        ]);



        if($validator->fails()){
             return response()->json(
                [
                    'message'=>'Validation error',
                    'error'=>$validator->errors(),
                ],401
             );
        }

        $ticket->update($request->only('status'));

        return response()->json(
            [
                'message'=>'Ticket status updated',
            ],200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
        $ticket->delete();

        return response()->json(
            [
                'message'=>'Ticket deleted. ',
            ],200
        );

    }
}
