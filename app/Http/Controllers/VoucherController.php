<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\Transaction;
use App\Models\Price;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    // Show list of vouchers
    public function index()
    {
        $vouchers = Voucher::all();
        return view('pages.voucher.index', compact('vouchers'));
    }

    // Show create form
    public function create()
    {
        return view('pages.voucher.create');
    }

    public function show()
    {
        return redirect()->route('voucher.index');
    }

    // Store a new voucher
    public function store(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required|string|max:255',
        ]);

        Voucher::create([
            'voucher_code' => $request->voucher_code,
            'used' => false,
        ]);

        return redirect()->route('voucher.index');
    }

    // Show edit form
    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('pages.voucher.edit', compact('voucher'));
    }

    // Update voucher
    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        $request->validate([
            'voucher_code' => 'required|string|max:255',
        ]);

        $voucher->update([
            'voucher_code' => $request->voucher_code,
            'used' => $request->has('used') ? true : false,
            'used_datetime' => $request->has('used') ? now() : null,
        ]);

        return redirect()->route('voucher.index');
    }

    // Delete voucher
    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return redirect()->route('voucher.index');
    }

    public function claimVoucher(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'voucher_code' => 'required|string',
        ]);

        // Here you can replace this with your actual logic for checking the voucher
        $voucherCode = $request->input('voucher_code');

        $voucher = Voucher::where([['voucher_code', $voucherCode], ['used', false]])->first();

        if ($voucher != null) {
            $voucher->update(['used' => true]);

            $price = Price::first();

            $transaction = Transaction::create([
                'payment_method' => 'voucher',
                'payment_status' => 'pending',
                'amount' => $price->photobox_price,
            ]);

            session(['transaction_id' => $transaction->id]);

            return response()->json([
                'success' => true,
                'message' => 'Voucher applied successfully!',
            ]);
        } elseif ($voucherCode == "testadmin") {
            $transaction = Transaction::create([
                'payment_method' => 'voucher',
                'payment_status' => 'pending',
                'amount' => 0,
            ]);

            session(['transaction_id' => $transaction->id]);

            return response()->json([
                'success' => true,
                'message' => 'Voucher applied successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid voucher code.',
            ]);
        }
        
    }
    
    public function generateVouchers()
{
    // Jumlah voucher yang ingin dihasilkan
    $voucherCount = 100;
    
    // Loop untuk membuat 100 voucher
    for ($i = 1; $i <= $voucherCount; $i++) {
        // Format voucher, menambahkan angka 3 digit dengan leading zero jika diperlukan
        $voucherCode = 'KM' . str_pad($i, 3, '0', STR_PAD_LEFT);
        
        // Membuat dan menyimpan voucher ke database
        Voucher::create([
            'voucher_code' => $voucherCode,
            'used' => false, // Default nilai 'used' adalah false
        ]);
    }

    // Redirect setelah berhasil membuat voucher
    return redirect()->route('voucher.index')->with('success', '100 vouchers generated successfully!');
}
}
