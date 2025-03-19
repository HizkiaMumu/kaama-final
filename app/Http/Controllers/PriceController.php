<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Price;

class PriceController extends Controller
{
    
    public function updatePrice(Request $request){
        $price = Price::first();
        $price->update([
            'photobox_price' => $request->photobox_price
        ]);

        return redirect()->back()->with('OK', 'Berhasil mengupdate price setting');
    }

}
