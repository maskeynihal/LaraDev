<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\KhaltiServerVerification;
use App\Services\PaymentResponseService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

class KhaltiFrontendController extends Controller
{
	public function pinVerify(Request $request)
	{
		$validated = $request->only([
			'public_key',
			'mobile',
			'transaction_pin',
			'amount',
			'product_identity',
			'product_name',
			'product_url'
		]);
		$response = Http::post("https://khalti.com/api/v2/payment/initiate/", $validated);
		// return Response::json(["token" => "BVNKCiLZhZipkMGws5hgS8"], 200);
		return Response::json($response->json(), $response->status());
		// return $response->json();
	}

	public function confirmPayment(Request $request)
	{
		$validated = $request->only([
			'public_key',
			'token',
			'confirmation_code',
			'transaction_pin',
		]);
		//add here amount to chek if frontend and backend amount is same
		$amount = 2000;

		$response = Http::post("https://khalti.com/api/v2/payment/confirm/", $validated);

		if(
			$response->successful() &&
			!empty($response->json()['token']) &&
			!empty($response->json()['amount']) &&
			!empty($response->json()['mobile']) &&
			!empty($response->json()['product_identity']) &&
			!empty($response->json()['product_name'])
		){
			$verified = KhaltiServerVerification::verify($response->json(), $amount);
			PaymentResponseService::save($verified->json(), $verified->status());
			return Response::json($verified->json(), $verified->status());
		}
		return Response::json($response->json(), $response->status());

	}
}
