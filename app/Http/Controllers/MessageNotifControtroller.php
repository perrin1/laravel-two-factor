<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\CodeSecret;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\CodeNotification;
use Illuminate\Support\Facades\Crypt;

class MessageNotifControtroller extends Controller
{
    function edit(Request $request)
    {
        $code = mt_rand(10000, 99999);
        $secret = Crypt::encryptString($code);
        $dure = Carbon::now();
        $dure->addMinutes(30);

        // dd($secret, $code, $dure);
        $codes = CodeSecret::create(([
            'code' => $code,
            'codecypte' => $secret,
            'dure' => $dure,
            'user_id' => Auth::user()->id,
        ]));

        $user = Auth::user();
        $user->notify(new CodeNotification($code));


        $data = CodeSecret::where('user_id', Auth::user()->id)->first();
        return redirect()->route('dashboard');
    }
    function regenere()
    {
        $code = mt_rand(10000, 99999);
        $secret = Crypt::encryptString($code);
        $dure = Carbon::now();
        $dure->addMinutes(30);

        $codes = CodeSecret::where('user_id', Auth::user()->id)->first();
        $codes->code = $code;
        $codes->codecypte = $secret;
        $codes->dure = $dure;

        $codes->save();


        $user = Auth::user();
        $user->notify(new CodeNotification($code));

        $data = CodeSecret::where('user_id', Auth::user()->id)->first();
        return redirect()->route('dashboard');
    }
    function send(Request $request)
    {
        $code = $request->code;
        $codes = CodeSecret::where('user_id', Auth::user()->id)->first();
        $decryptedCode = Crypt::decryptString($codes->codecypte);
        $dure = Carbon::now();
        $difference = Carbon::parse($dure)->diffInMinutes(Carbon::parse($codes->created_at));
        // dd($code, $decryptedCode,$difference);
        if ($code != $decryptedCode) {
            return response()->json(['message' => 'erreur']);
        } else {
            if ($difference > 30) {
                return response()->json(['message' => 'erreur']);
            } else {
                # code...
                return response()->json(['message' => 'bien']);
            }

        }




    }
}
