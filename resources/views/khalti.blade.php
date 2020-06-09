@extends('layouts.app')

@section('content')
<khalti-wallet
	:amount="{{ $amount }}"
	:success-route="{{ json_encode(route('home')) }}"
	:product_identity="{{json_encode("hello")}}"
	:product_name="{{json_encode("A Song of Ice and Fire")}}"
	:product_url="{{json_encode("http://bookexample.com")}}"
	:public_key="{{json_encode("test_public_key_0c4da1f36d52491db216151b1767407b")}}"
></khalti-wallet>
@endsection