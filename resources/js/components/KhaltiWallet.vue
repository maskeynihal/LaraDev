<template>
    <div class="container">
        <button id="payment-button" style="background-color: #773292; cursor: pointer; color: #fff; border: none; padding: 5px 10px; border-radius: 2px" data-toggle="modal" data-target="#khaltiWallet">Pay with Khalti Wallet</button>

		<!-- Modal -->
		<div id="khaltiWallet" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="khaltiWalletLabel" aria-hidden="true">

		<div class="modal-dialog">
			<div class="modal-content" v-if="!success">
				<div class="modal-header">
					<h5 class="modal-title" id="khaltiWalletLabel">Khalti Wallet Payment</h5>
				</div>
				<div class="modal-body">
					<div class="alert alert-danger"
						v-show="!noError"
					>
						Please correct the information
					</div>
					<div
						class="alert alert-danger"
						v-if="responseError.length"
					>
						<ul class="list-unstyled">
							<li v-for="(error, index) in responseError" :key="index">
								<span
									v-html="error[0]"
								>
								</span>
							</li>
						</ul>
					</div>
					<form class="form ">
						<div class="form-group" v-if="!hasConfirmCode">
							<label for="mobileNumber" class="col-form-label" >Mobile Number</label>
							<input type="text" class="form-control" :class="!error.mobileNumber && !mobileNumberError ? 'is-valid' : ''" id="mobileNumber" v-model="mobileNumber">
							<div class="invalid-feedback d-block" v-if="error.mobileNumber">
								{{ error.mobileNumber }}
							</div>
						</div>
						<div class="form-group" v-if="!hasConfirmCode">
							<label for="pin" class="col-form-label" >Khalti Pin</label>
							<input type="text" class="form-control"  :class="!error.pin && !pinError ? 'is-valid' : ''" id="pin" v-model="pin">
							<div class="invalid-feedback d-block">
								{{ error.pin }}
							</div>
						</div>
						<div class="form-group" v-if="hasConfirmCode">
							<label for="pin" class="col-form-label" >Verification Pin</label>
							<input type="text" class="form-control"  :class="!error.confirmCode && !confirmCodeError ? 'is-valid' : ''" id="confirmCode" v-model="confirmCode">
							<div class="invalid-feedback d-block">
								{{ error.confirmCode }}
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" @click="close()">Close</button>
					<button id="payment-button" style="background-color: #773292; cursor: pointer; color: #fff; border: none; padding: 5px 10px; border-radius: 2px" @click="khaltiPay()" data-toggle="modal" v-if="token">Confirm</button>
					<button id="payment-button" style="background-color: #773292; cursor: pointer; color: #fff; border: none; padding: 5px 10px; border-radius: 2px" @click="khaltiWallet()" data-toggle="modal" v-else>Pay with Khalti</button>
				</div>
			</div>
			<div class="modal-content" v-else>
				<div class="modal-header">
					Payment Success
				</div>
				<div class="modal-body">
					Your Payment has been successful
				</div>
				<div class="modal-footer">
					<a :href="successRoute" class="btn btn-success">
						Okay
					</a>
				</div>
			</div>
		</div>
		</div>
    </div>
</template>

<script>
import axios from "axios";
    export default {
        mounted() {
		},
		data(){
			return{
				mobileNumber: '',
				pin: '',
				confirmCode: '',
				token: '',
				error:{},
				responseError:{},
				pinError: true,
				mobileNumberError: true,
				confirmCodeError: true,
				noError: true,
				hasConfirmCode: false,
				success: false,
			}
		},
		watch: {
			mobileNumber(value){
				this.validateMobileNumber(value);
			},
			pin(value){
				this.validatePin(value);
			},
			confirmCode(value){
				this.validateConfirmCode(value);
			}
		},
		props: {
			successRoute: {
				default: ""
			},
			amount: {
				default: 1000
			},
			public_key:{
				default: "test_public_key_546eb6da05544d7d88961db04fdb9721"
			},
			product_identity:{
				default: "uniqueId"
			},
			product_name:{
				default: "Test Product Name"
			},
			product_url:{
				default: "https://google.com"
			}
		},
		methods: {
			freshOut(){
				this.mobileNumber = '',
				this.pin = '',
				this.confirmCode = '',
				this.token = '',
				this.error ={},
				this.responseError ={},
				this.pinError = true,
				this.mobileNumberError = true,
				this.confirmCodeError = true,
				this.noError = true,
				this.hasConfirmCode = false
			},
			validatePin(pin){
				if(pin.length != 4){
					this.error.pin = "Enter 4 digits pin";
				}else{
					this.error.pin = "";
					this.pinError = false;
				}
			},
			validateMobileNumber(mobileNo){
				if(mobileNo.length != 10 || mobileNo < 9000000000){
					this.error.mobileNumber = "Enter valid mobile number";
				}else{
					this.error.mobileNumber = "";
					this.mobileNumberError = false;
				}
			},
			validateConfirmCode(confirmCode){
				if(confirmCode.length != 6){
					this.error.confirmCode = "Enter 6 digit code sent in your mobile number"
				}else{
					this.error.confirmCode = "";
					this.confirmCodeError = false;
				}
			},
			async khaltiWallet(){
				this.noError = true;
				this.responseError = {};
				if(!this.pinError && !this.mobileNumberError){
					const config = {
						"public_key": this.public_key,
						"mobile": this.mobileNumber,
						"transaction_pin": this.pin,
						"amount": this.amount,
						"product_identity": this.product_identity,
						"product_name": this.product_name,
						"product_url": this.product_url,
					}
					try {
						const token = await axios.post("api/pin-verify", config);
						if(token.data){
							this.token = token.data.token;
							this.hasConfirmCode = true;
						}else{
							this.freshOut();
						}
					} catch (error) {
						if(Object.keys(error.response.data).includes("detail")){
							this.responseError = [[error.response.data.detail]]
						}else{
							this.responseError = Object.keys(error.response.data)
														.map(key => error.response.data[key])
														.filter(item => Array.isArray(item))
						}
					}
				}else{
					this.noError = false;
				}
			},
			async khaltiPay(){
				try {
					const response = await axios.post('/api/khalti-confirm-payment', {
						public_key: this.public_key,
						token: this.token,
						confirmation_code: this.confirmCode,
						transaction_pin: this.pin
					});
					this.success = true;
					this.freshOut();
				} catch (error) {
					this.freshOut();
					this.responseError = Object.keys(error.response.data)
													.map(key => error.response.data[key])
													.filter(item => Array.isArray(item))
					setTimeout(() => {
						this.responseError = {}
					}, 3000);
				}
			},
			close(){
				this.freshOut();
			}
		}
    }
</script>
