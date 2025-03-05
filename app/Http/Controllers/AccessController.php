<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Ticket;
use App\Models\Screening;
use Illuminate\View\View;

use Illuminate\Support\Facades\DB;

class AccessController extends Controller
{
    public function index(): View
    {

        $today = date('Y-m-d');
        $fourteenDaysFromNow = date('Y-m-d', strtotime('+14 days'));
        $todayHour = date('G:i:s');

        $screenings = Screening::where(function ($query) use($today, $todayHour) {
            $query->where('date', '>', $today)
                  ->orWhere(function ($subQuery) use($today, $todayHour){
                    $subQuery->where('date', '=', $today)->where('start_time', '>=', $todayHour);
                  });
        })->where('date', '<=', $fourteenDaysFromNow)->paginate(5);


       

        return view('AccessControl.index', compact('screenings'));
    }

    public function show(Screening $screening): View
    {
        return view('AccessControl.show', compact('screening'));
    }


    public function ticketInvalidate(Ticket $ticket)
    {
        $ticket->status = 'invalid';
        $ticket->save();

        $htmlMessage = "{$ticket->id} ficou invalido";
        return redirect()->route('access.show',  ['screening' => $ticket->screening])
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }



    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    /**public function show(Ticket $ticket)
    {
        //
    }*/

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
