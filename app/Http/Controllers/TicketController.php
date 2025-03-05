<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Screening;
use App\Models\Seat;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * Mostra pagina para compra de bilhetes de filme selecionado
     */
    public function show(Movie $movie): View
    {
        $screeningsQuery = Screening::query();

        $screeningsQuery->where('movie_id', $movie->id);

        $today = date('Y-m-d');
        $fourteenDaysFromNow = date('Y-m-d', strtotime('+14 days'));

        $todayHour = date('G:i:s');

        $screeningsQuery->where(function ($query) use($today, $todayHour) {
            $query->where('date', '>', $today)
                  ->orWhere(function ($subQuery) use($today, $todayHour){
                    $subQuery->where('date', '=', $today)->where('start_time', '>=', $todayHour);
                  });
        });

        $screenings =  $screeningsQuery->where('date', '<=', $fourteenDaysFromNow)->get();


        return view('tickets.show')->with('movie', $movie)->with('screenings', $screenings);
    }

    public function validateTicket(Request $request, Screening $screening)
    {
        $ticketId = $request->input('ticket_id');

        $tickets = Ticket::where('screening_id', $screening->id)->get();
        $ticket = $tickets->find($ticketId);
        //query for testing
        //$ticket = Ticket::find($ticketId);
        if ($ticket) {
            // Ticket válido
            return view('tickets.ticketHtml')->with('ticket', $ticket);
        } else {
            // Ticket inválido
            $htmlMessage = "O Bilhete não está associado à screening session";
            return redirect()->back()
                ->with('alert-type', 'warning')
                ->with('alert-msg', $htmlMessage);
        }
    }

    public function numberOfSeats(Screening $screening): View
    {

        return view('tickets.numberOfSeats')->with('screening', $screening);
    }


    public function mostrarBilhetes(Request $request, Screening $screening): View
    {

        
        $seatsQuery = Seat::query();
        $screening_id = $screening->id;
        $seatsQuery->where('theater_id', $screening->theater_id);
        $seatsQuery->whereHas('ticket', function($ticketQuery) use($screening_id){
            $ticketQuery->where('screening_id', $screening_id);
        });
        $seatIDsComTickets = $seatsQuery->pluck('id')->toArray();

        $seatsQuery2 = Seat::query();
        $seatsQuery2->where('theater_id', $screening->theater_id);

        $seatsQuery2->whereNotIn('id', $seatIDsComTickets);
        $seats = $seatsQuery2->get();
        
        return view('tickets.seats')->with('screening', $screening)->with('seats', $seats);
    }
    /**
     * Show the form for creating a new resource.
     */

    public function myTickets(){
        
        $user = Auth::user();

        if($user->type == 'C'){
            

            $ticketQuery = Ticket::query();

            $ticketQuery->whereHas(
                'purchase',
                function ($userQuery) use ($user) {
                    $userQuery->where('customer_id', $user->id);
                }
            );
            
            $tickets = $ticketQuery->paginate(20);

            debug($tickets);
            return view('tickets.myTickets',compact('tickets'));
        }
        else{
            
            $tickets = Ticket::paginate(20);
            return view('tickets.myTickets',compact('tickets'));
        }

    }

    public function myTicketsGetTicket(Ticket $ticket)
    {


        /*$ticket_id = $ticket->id;
        $screening = $ticket->screening->date . $ticket->screening->start_time;
        $movie_name = $ticket->screening->movie->title;
        $user_name = $ticket->purchase->customer_name;
        $email = $ticket->purchase->customer_email;
        $theater_name = $ticket->screening->theater->name;
        $seat = $ticket->seat->row . $ticket->seat->seat_number;*/


        return view('Tickets.ticketHtml',compact('ticket'));

    }
}
