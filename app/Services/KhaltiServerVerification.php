<?php


namespace App\Services;

use Illuminate\Support\Facades\Http;


class KhaltiServerVerification
{
	public static function verify($response, $amount)
	{
		$payload = [
			'token' => $response['token'],
			'amount' => $amount
		];

		$response = Http::withHeaders([
			"Authorization" => "Key test_secret_key_d554e9ada4f94e5bb674deed7b1112eb"
		])->post("https://khalti.com/api/v2/payment/verify/", $payload);

		return $response;
	}
}