<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Customer;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Purchase;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;

class PdfController extends Controller
{
    //o nome deste devia ser generateReceipt
    public function generateTicket(Purchase $purchase)//: RedirectResponse
    {

        $data = [
            'purchase_id' => $purchase->id,
            'date' => $purchase->date,
            'payment_reference' => $purchase->payment_ref,
            'payment_type' => $purchase->payment_type,
            'customer_name' => $purchase->customer_name,
            'customer_nif' => $purchase->nif,
            'customer_email' => $purchase->customer_email
        ];

        $tickets = Ticket::query()->where('purchase_id', $purchase->id)->get();
        $data['tickets'] = $tickets;
        $price_total = 0;
        foreach($tickets as $ticket){
            $price_total = $price_total + $ticket->price;
        }

        $data['price_total'] = $price_total;
        $user_id = $purchase->customer_id;
        $purchase_id = $purchase->id;
        $file_name= $user_id .'_'. $purchase_id . '.pdf';
        $pdf = Pdf::loadView('pdf.receipt', $data)->save('storage/tickets/'.$file_name);
        $purchase->receipt_pdf_filename =  $file_name;
        

        
        Session::flash('pdf', $purchase_id);
        return Redirect::to('/');
        
        
    }


    public function downloadTicket(Ticket $ticket){
        
        $data = [
            'ticket_id' => $ticket->id,
            'screening' => $ticket->screening->date . ' '. $ticket->screening->start_time,
            'movie_name' => $ticket->screening->movie->title,
            'user_name' => $ticket->purchase->customer_name,
            'email' => $ticket->purchase->customer_email,
            'theater_name' => $ticket->screening->theater->name,
            'seat' => $ticket->seat->row . $ticket->seat->seat_number
        
        ];
        $file_name= $ticket->id;
        $pdf = Pdf::loadView('pdf.ticket', $data);
        return $pdf->download($file_name . '.pdf');
        
    }

    public function downloadReceiptAndTicket(String $purchase_id){
        
    
        $purchase = Purchase::find($purchase_id);
        
        $data = [
            'purchase_id' => $purchase->id,
            'date' => $purchase->date,
            'payment_reference' => $purchase?->payment_reference,
            'payment_type' => $purchase?->payment_type,
            'customer_name' => $purchase->customer_name,
            'customer_nif' => $purchase?->nif,
            'customer_email' => $purchase->customer_email
        ];
        
        $tickets = $purchase->ticket;
        
        $data['tickets'] = $tickets;
        $price_total = 0;
        foreach($tickets as $ticket){
            $price_total = $price_total + $ticket->price;
        }
        $data['price_total'] = $price_total;
        
        return Pdf::loadView('pdf.receiptETickets', $data)->download('talaoEBilhetes.pdf');
        
    }


    //Usar no css
        //page-break-after: always;
}
