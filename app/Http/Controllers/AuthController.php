<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class AuthController extends Controller
{
    
    public function signIn(Request $request){
        $user = User::where('email', $request->email)->first();
        if ($user != null) {
            $user = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

            if ($user) {
                return redirect('/dashboard/voucher');
            } else {
                return redirect()->back()->with('ERR', 'Email atau password yang anda masukan salah.');
            }
        } else {
            return redirect()->back()->with('ERR', 'Email atau password yang anda masukan salah.');
        }
    }

    public function signUp(Request $request){
        $user = User::where('nik', $request->nik)->first();

        if ($user != null) {
            return redirect()->back()->with('ERR', 'NIK yang anda masukan telah terdaftar.');
        }

        $user = User::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect('/login')->with('OK', 'Berhasil melakukan pendaftaran akun, silahkan login.');
    }

    public function signOut(){
        Auth::logout();
        return redirect('/login')->with('OK', 'Berhasil melakukan logout.');
    }

}
