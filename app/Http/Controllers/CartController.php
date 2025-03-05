<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Ticket;
use App\Models\Seat;
use App\Models\Screening;
use App\Models\Configuration;


class CartController extends Controller
{
    public function show(): View
    {
        $cart = session('cart', []);

        $configuration = Configuration::first();
        
        $price = $configuration->ticket_price;
        $discount = $configuration->registered_customer_ticket_discount;


        
        $screening_ids = array_keys($cart);
        $screenings = Screening::whereIn('id', $screening_ids)->get()->keyBy('id');

        

        return view('cart.show', compact('cart', 'screenings'))->with('price', $price)->with('discount', $discount);
    }


    public function addToCart(Request $request, Seat $seat, Screening $screening): RedirectResponse
    {
        
        $cart = session('cart', []);

        
        if (isset($cart[$screening->id])) {
            
            $seatExists = collect($cart[$screening->id])->firstWhere('id', $seat->id);

            if ($seatExists) {
                $alertType = 'warning';
                $htmlMessage = "Ticket <p> Line: {$seat->row} Number: {$seat->seat_number}</p>
                    <strong>\"{$seat->id}\"</strong> was not added to the cart
                    because it is already there!";
                return back()->with('alert-msg', $htmlMessage)->with('alert-type', $alertType);
            } else {
                
                $cart[$screening->id][] = $seat;
            }
        } else {
            
            $cart[$screening->id] = [$seat];
        }

        
        $request->session()->put('cart', $cart);

        $alertType = 'success';
        $htmlMessage = "Ticket <p>Line: {$seat->row} Number: {$seat->seat_number}</p>
            <strong>\"{$seat->id}\"</strong> was added to the cart.";
        return back()->with('alert-msg', $htmlMessage)->with('alert-type', $alertType);
    }


    public function removeFromCart(Request $request, Seat $seat): RedirectResponse
{
    
    $cart = session('cart', []);

    if (!$cart) {
        $alertType = 'warning';
        $htmlMessage = "Ticket <p> Line: {$seat->row} Number: {$seat->seat_number}</p>
            <strong>\"{$seat->id}\"</strong> was not removed from the cart because cart is empty!";
        return back()->with('alert-msg', $htmlMessage)->with('alert-type', $alertType);
    } else {
        
        foreach ($cart as $screeningId => $seats) {
            
            $elementKey = collect($seats)->search(function ($item) use ($seat) {
                return $item->id === $seat->id;
            });

            if ($elementKey !== false) {
                
                unset($cart[$screeningId][$elementKey]);

                
                if (empty($cart[$screeningId])) {
                    unset($cart[$screeningId]);
                }

                
                $request->session()->put('cart', $cart);

                $alertType = 'success';
                $htmlMessage = "Ticket <p> Line: {$seat->row} Number: {$seat->seat_number}</p>
                    <strong>\"{$seat->id}\"</strong> was removed from the cart.";
                return back()->with('alert-msg', $htmlMessage)->with('alert-type', $alertType);
            }
        }

        
        $alertType = 'warning';
        $htmlMessage = "Ticket <p> Line: {$seat->row} Number: {$seat->seat_number}</p>
            <strong>\"{$seat->id}\"</strong> was not removed from the cart because it was not found!";
        return back()->with('alert-msg', $htmlMessage)->with('alert-type', $alertType);
    }
}

    public function destroy(Request $request): RedirectResponse
    {
        $request->session()->forget('cart');
        return back()->with('alert-type', 'success')->with('alert-msg', 'Shopping Cart has been cleared');
    }



    
    public function confirm()
    {
        $ticket_query = Ticket::query();

        $cart = session('cart', []);

        
        $screening_ids = array_keys($cart);
        $screenings = Screening::whereIn('id', $screening_ids)->get()->keyBy('id');


        foreach($screening_ids as $id){
            $ticket_query->where('screening_id', $id);
        }


        $tickets_existentes = $ticket_query->get();
        //dd($tickets_existentes);
        $falhanco = false;
        $htmlMessage = "";
        foreach ($cart as $screening_idd => $seats){

            foreach($seats as $seat){

                foreach($tickets_existentes as $ticket){

                    if($ticket->screening_id == $screening_idd and $ticket->seat_id == $seat->id){
                        //dd($ticket->screening_id, $screening_idd, $ticket->seat_id, $seat->id);
                        
                        $falhanco = true;
                        $htmlMessage = $htmlMessage . "<p> <strong>\"ERROR\"</strong> Ticket  Line: {$seat->row} Number: {$seat->seat_number}
                             is no longer available !</p>";
                        

                    }

                }

            }

        }

        if($falhanco){
            return back()->with('alert-msg', $htmlMessage)->with('alert-type', 'insuccess');
        }else{
            return view('payment.index')->with('cart', $cart);
        }
        
    }


    public function confirmAuth()
    {
        $ticket_query = Ticket::query();

        $cart = session('cart', []);

        
        $screening_ids = array_keys($cart);
        $screenings = Screening::whereIn('id', $screening_ids)->get()->keyBy('id');


        foreach($screening_ids as $id){
            $ticket_query->where('screening_id', $id);
        }


        $tickets_existentes = $ticket_query->get();
        //dd($tickets_existentes);
        $falhanco = false;
        $htmlMessage = "";
        foreach ($cart as $screening_idd => $seats){

            //$screening = $screenings[$screening_idd];

            foreach($seats as $seat){

                foreach($tickets_existentes as $ticket){

                    if($ticket->screening_id == $screening_idd and $ticket->seat_id == $seat->id){
                        //dd($ticket->screening_id, $screening_idd, $ticket->seat_id, $seat->id);
                        
                        $falhanco = true;
                        $htmlMessage = $htmlMessage . "<p> <strong>\"ERROR\"</strong> Ticket  Line: {$seat->row} Number: {$seat->seat_number}
                             is no longer available !</p>";
                        

                    }

                }

            }

        }

        if($falhanco){
            return back()->with('alert-msg', $htmlMessage)->with('alert-type', 'insuccess');
        }else{
            return view('payment.indexAuth')->with('cart', $cart);
        }
        
    }
}


