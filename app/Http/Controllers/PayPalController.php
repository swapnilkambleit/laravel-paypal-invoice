<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use App\Services\PayPalInvoiceService;
use stdClass;

class PayPalController extends Controller
{
   
    public function  index(Request $request) 
    {
        $page_id = $request->query('page', 1);

        $arr = range(1,1000);

        if(!in_array($page_id, $arr)){
            $page_id = 1;
        }

        $paypal = new PayPalInvoiceService();

        $listInvoices = $paypal->listInvoices($page_id);
 
        return view('web.paypal.invoice-list',compact([ 'listInvoices', 'page_id' ]));
    }

    public function invoiceCreate(Request $request) 
    { 
        return view('web.paypal.invoice-create');
    }

    public function invoiceCreateSubmit (Request $request)
    { 
       
        $request->validate([
            'first_name' => 'required', 
            'last_name' => 'required', 
            'amount' => 'required', 
            'email' => 'required|email',
            'mobile' => 'required',
            'address' => 'required',
            'city' => 'required', 
            'state' => 'required',
            'country' => 'required', 
            'postal_code' => 'required' 
        ]);
        
        $telCode = $request->tel_code ?? '';
        $request->mobile = $telCode . ' ' . $request->mobile; 

        $amount = number_format((float)$request->amount, 2, '.', '');

        // Example items
        $items = [
                    [
                        "name" => "Trade Service", 
                        "quantity" => "1",
                        "unit_amount" => [
                            "currency_code" => "USD",
                            "value" => $amount
                        ],
                        "description" => "Trade Service for your business."
                    ],
                ];

        try {   
            $paypal = new PayPalInvoiceService();
            $note = "Thank you for your business! We appreciate your prompt payment.";
           
            // Create invoice
            $invoice = $paypal->createInvoice($request, $items, $note);
 
            $invoiceId = basename($invoice['href']);  

            return redirect()->back()->with('success', 'Invoice successfully created - '.$invoiceId .'.!');

        } catch (\Exception $e) {
            
            return redirect()->back()->with('error', 'Invoice creation failed. Please double-check your details and try again.');
            
        }
       
    }

    
    public function invoiceDelete($slug) 
    { 
        try {   
            $paypal = new PayPalInvoiceService();

            $deleteInvoice = $paypal->deleteInvoice($slug);
  
            return redirect()->back()->with('success', 'Invoice delete successfully!');

        } catch (\Exception $e) {
            
            return redirect()->back()->with('error', 'Invoice delete failed. Please try again.');
           
        }
       
    }
}
