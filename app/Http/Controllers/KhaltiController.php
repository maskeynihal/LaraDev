<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KhaltiController extends Controller
{
	public function selectPaymentMethod()
	{
		$amount = 1000;
		return view('khalti', compact('amount'));
	}
}
