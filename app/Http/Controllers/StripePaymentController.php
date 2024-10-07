<?php

namespace App\Http\Controllers;

use App\Models\cart;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripePaymentController extends Controller
{
//    public function index()
//    {
//        return view('cart.view');
//    }
    public function checkout(Request $request)
    {
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->quantity * $item->product->price;
        }
        Stripe::setApiKey(env('STRIPE_SECRET'));
//
        $checkout_session = session::create ([
//            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd', // or the currency you need
                    'product_data' => [
                        'name' => 'Total Cart Payment',
                    ],
                    'unit_amount' => $total * 100, // Stripe uses cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success'),
            'cancel_url' => route('payment.cancel'),
        ]);

        return redirect($checkout_session->url, 303);
    }
    public function paymentSuccess()
    {
        Cart::where('user_id', auth()->id())->delete();
        return view('payment.success');
    }
    public function paymentCancel()
    {
        return view('payment.cancel');
    }
}
