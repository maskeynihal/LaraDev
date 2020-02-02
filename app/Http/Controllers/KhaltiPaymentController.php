<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KhaltiPaymentController extends Controller
{
    public function serverValidation(Request $request)
    {
        $args = http_build_query(array(
            'token' => $request->token, //token send from client integration; Client side payment initiation
            'amount'  => $request->amount //amount should be checked and keep real amount to be paid, 
        ));

        $url = "https://khalti.com/api/v2/payment/verify/";

        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $headers = ['Authorization: Key '.env('KHALTI_SECRET_KEY')];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Response
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $response; //validate response, store response 
    }
}
