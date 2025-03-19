<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Price;
use App\Models\Transaction;

class PaymentController extends Controller
{
    public function getSnapToken()
    {
        $price = Price::first();

        $transaction = Transaction::create([
            'payment_method' => 'cashless',
            'payment_status' => 'pending',
            'amount' => $price->photobox_price,
        ]);

        session(['transaction_id' => $transaction->id]);

        // Set Midtrans configuration
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Order details
        $order_id = "ORDER-" . time();
        $gross_amount = $price->photobox_price; // Example: 10,000 IDR

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => $gross_amount,
            ],
            'payment_type' => 'qris'
        ];

        try {
            // Generate Snap token
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
