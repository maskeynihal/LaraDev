{{-- @extends('layouts.app') --}}

{{-- @section('content') --}}
{{ $amount }}
<a href="http://">Khalti Wallet</a>
<a href="http://">Khalti e-banking</a>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
<script>
	const config = {
		"public_key": "live_public_key_546eb6da05544d7d88961db04fdb9721",
		"mobile": "9842XXXXXX",
		"transaction_pin": "1234",
		"amount": {!! $amount !!},
		"product_identity": "book/id-120",
		"product_name": "A Song of Ice and Fire",
		"product_url": "http://bookexample.com"
	}
	console.log(config)
	axios.get('https://khalti.com/api/v2/payment/initiate/', config)
		.then(function(response){
			console.log(response.data)
		})
		.catch(function(err){
			console.log(err)
		})
</script>
{{-- @endsection --}}