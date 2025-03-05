<?php

namespace App\Http\Controllers;

use App\Models\Statistics;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Screening;
use App\Models\Purchase;
use App\Models\Ticket;
use Illuminate\View\View;

use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index(Request $request): View
    {
        // Obtém todas as sessões com o relacionamento do filme e das compras
        /*$screenings = Screening::with(['movie', 'ticket.purchase'])
            ->whereHas('ticket.purchase')
            ->join('movies', 'screenings.movie_id', '=', 'movies.id')
            ->orderBy('screenings.date')
            ->orderBy('screenings.start_time')
            ->orderBy('movies.title')
            ->select('screenings.*') 
            ->get();*/

        $screeningsQuery = Screening::query();
        
        $today = date('Y-m-d');
        $fourteenDaysFromNow = date('Y-m-d', strtotime('+14 days'));

        $screeningsQuery->where('date', '>=', $today)->where('date', '<=', $fourteenDaysFromNow);
                    

        $screenings =  $screeningsQuery->get();

        foreach ($screenings as $screening) {
            $screening->tickets_sold_count = $screening->ticket->count();
        }
        
        // Calcular o total de bilhetes vendidos por hora de sessão
        $totalTicketsByHour = Screening::with('ticket')
            ->select(DB::raw('HOUR(start_time) as hour'), DB::raw('COUNT(tickets.id) as total_tickets'))
            ->join('tickets', 'screenings.id', '=', 'tickets.screening_id')
            ->groupBy(DB::raw('HOUR(start_time)'))
            ->orderBy('total_tickets', 'desc')
            ->get();

        // Contagem dos diferentes tipos de pagamento
        $paymentTypes = Purchase::select('payment_type', DB::raw('COUNT(*) as count'))
           ->groupBy('payment_type')
           ->get();

        return view('Statistics.index', compact('screenings', 'totalTicketsByHour', 'paymentTypes'));
    }

    public function show(Movie $movie): View
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
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
