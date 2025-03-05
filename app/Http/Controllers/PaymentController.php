<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Ticket;
use App\Models\Seat;
use App\Models\Screening;
use App\Models\Purchase;
use App\Services\Payment;

class PaymentController extends Controller
{
    //

    
    
    public function showPaymentType(Request $request): View
    {
        // Valida os dados do formulário
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nif' => 'required|digits:9|numeric',
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $nif = $request->input('nif');

        $dados = ['name' => $name, 'email' => $email, 'nif' => $nif, ];

        return view('payment.paymenttype')->with('dados', $dados);
    }

    public function showPaymentTypeAuth(Request $request): View
    {
        // Valida os dados do formulário
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nif' => 'required|digits:9|numeric',
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $nif = $request->input('nif');

        $dados = ['name' => $name, 'email' => $email, 'nif' => $nif, ];

        return view('payment.paymenttypeAuth')->with('dados', $dados);
    }

    public function showPaymentInfo(Request $request): View
    {
        
        
        $name = $request->input('name');
        $email = $request->input('email');
        $nif = $request->input('nif');
        $paymentType = $request->input('paymenttype');

        $dados = [
            'name' => $name,
            'email' => $email,
            'nif' => $nif,
            'paymenttype' => $paymentType,
        ];

        return view('payment.paymentinfo')->with('dados', $dados);
    }

    

    public function showPaymentInfoAuth(Request $request): View
    {

        
        
        $name = $request->input('name');
        $email = $request->input('email');
        $nif = $request->input('nif');
        $paymentType = $request->input('paymenttype');

        $dados = [
            'name' => $name,
            'email' => $email,
            'nif' => $nif,
            'paymenttype' => $paymentType,
        ];

        return view('payment.paymentinfoAuth')->with('dados', $dados);
    }

    public function showPaymentFinalInfo(Request $request): View
    {
        
        $validatedData = [];
        $paymentType = $request->input('paymenttype');

        if ($paymentType === 'MBWay') {
            $validatedData = $request->validate([
                'phone' => ['required','string','size:9','regex:/^[9]\d{8}$/'],
            ]);
        } elseif ($paymentType === 'Visa') {
            $validatedData = $request->validate([
                'visa_card_number' => 'required|digits:16|numeric',
                'visa_ccv' => 'required|digits:3|numeric',
            ]);
        } elseif ($paymentType === 'Paypal') {
            $validatedData = $request->validate([
                'paypal_email' => 'required|email|max:255',
            ]);
        }

        

        $name = $request->input('name');
        $email = $request->input('email');
        $nif = $request->input('nif');
        $paymentType = $request->input('paymenttype');

        $dados = [
            'name' => $name,
            'email' => $email,
            'nif' => $nif,
            'paymenttype' => $paymentType,
        ];

        

        if ($paymentType === 'MBWAY') {
            $dados['phone'] = $request->input('phone');
            
        } elseif ($paymentType === 'VISA') {
            $dados['visa_card_number'] = $request->input('visa_card_number');
            $dados['visa_ccv'] = $request->input('visa_ccv');
            
        } elseif ($paymentType === 'PAYPAL') {
            $dados['paypal_email'] = $request->input('paypal_email');
            
        }

        if ($paymentType === 'MBWay') {
            $dados['phone'] = $request->input('phone');
            
        } elseif ($paymentType === 'Visa') {
            $dados['visa_card_number'] = $request->input('visa_card_number');
            $dados['visa_ccv'] = $request->input('visa_ccv');
            
        } elseif ($paymentType === 'Paypal') {
            $dados['paypal_email'] = $request->input('paypal_email');
            
        }

        return view('payment.paymentfinalinfo')->with('dados', $dados);
    }


    public function store(Request $request): View
    {
        
        $validatedData = [];
        $paymentType = $request->input('paymenttype');

        $purchase;
        $name = $request->input('name');
        $email = $request->input('email');
        $nif = $request->input('nif');
        $paymentType = $request->input('paymenttype');

        $dados = [
            'name' => $name,
            'email' => $email,
            'nif' => $nif,
            'paymenttype' => $paymentType,
        ];

        $pagamento = false;

        $processaPagamento = new Payment();

        $paymentRef = "";
        
        if ($paymentType === 'MBWAY') {
            $dados['phone'] = $request->input('phone');
            $pagamento = $processaPagamento->payWithMBway($dados['phone']);
            $paymentRef = $dados['phone'];

        } elseif ($paymentType === 'VISA') {
            $dados['visa_card_number'] = $request->input('visa_card_number');
            $dados['visa_ccv'] = $request->input('visa_ccv');
            $pagamento = $processaPagamento->payWithVisa($dados['visa_card_number'], $dados['visa_ccv']);
            $paymentRef = $dados['visa_card_number'];
        } elseif ($paymentType === 'PAYPAL') {
            $dados['paypal_email'] = $request->input('paypal_email');
            $pagamento = $processaPagamento->payWithPaypal($dados['paypal_email']);
            $paymentRef = $dados['paypal_email'];
        }

        if ($paymentType === 'MBWay') {
            $dados['phone'] = $request->input('phone');
            $pagamento = $processaPagamento->payWithMBway($dados['phone']);
            $paymentRef = $dados['phone'];

        } elseif ($paymentType === 'Visa') {
            $dados['visa_card_number'] = $request->input('visa_card_number');
            $dados['visa_ccv'] = $request->input('visa_ccv');
            $pagamento = $processaPagamento->payWithVisa($dados['visa_card_number'], $dados['visa_ccv']);
            $paymentRef = $dados['visa_card_number'];
        } elseif ($paymentType === 'Paypal') {
            $dados['paypal_email'] = $request->input('paypal_email');
            $pagamento = $processaPagamento->payWithPaypal($dados['paypal_email']);
            $paymentRef = $dados['paypal_email'];
        }

        if($pagamento){
            $htmlMessage = "Compra efetuada COM SUCESSO já pode voltar à página inicial";
            $alertType = 'success';
            $result = 1; 
            
            $price = session('price');
            $total_price = session('total_price');

            $purchase = Purchase::create([
                'customer_id' => auth()->id() ?: null, 
                'date' => date('Y-m-d'), 
                'total_price' => $total_price,
                'customer_name' => $name,
                'customer_email' => $email,
                'nif' => $nif,
                'payment_type' => $paymentType,
                'payment_ref' => $paymentRef,
            ]);
            
            $purchaseId = $purchase->id;

            $seats = session('cart', []);

            foreach ($seats as $screening_id => $seatsByScreening){
                foreach($seatsByScreening as $seat){
                   
                    $ticket = Ticket::create([
                        'screening_id' => $screening_id,
                        'seat_id' => $seat->id,
                        'purchase_id' => $purchaseId, 
                        'price' => $price,
                
                    ]);
                    
                }
            }

            


            $request->session()->forget('cart');

            return view('payment.paymentResult')->with('result', $result)->with('purchase', $purchase);
            
        }else{
            $htmlMessage = "Compra efetuada SEM SUCESSO, volte à página inicial e tente novamente";
            $alertType = 'danger';
            $result = 0; 

            return view('payment.paymentResultUnsuccess')->with('result', $result);

        }

        
    }
    

    
}
