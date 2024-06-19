<!DOCTYPE html>
<html lang="en">

<head>
	<title> PASSWORD RESET | {{ env("APP_NAME")  }} </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="<?php asset('images/logo/logo.png') ?>" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/login_assets/vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/login_assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/login_assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/login_assets/vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/login_assets/vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/login_assets/vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/login_assets/vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/login_assets/vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/login_assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="/login_assets/css/main.css">
	<!--===============================================================================================-->

	<style>
		.loader {
			border: 4px solid #f3f3f3;
			border-top: 4px solid #3498db;
			border-radius: 50%;
			width: 20px;
			height: 20px;
			animation: spin 1s linear infinite;
			display: none;
		}

		@keyframes spin {
			0% {
				transform: rotate(0deg);
			}

			100% {
				transform: rotate(360deg);
			}
		}
		.relative {
			position: relative;
		}

		.toggle-password {
			position: absolute;
			right: 10px;
			top: 50%;
			transform: translateY(-50%);
			cursor: pointer;
		}

		.input100 {
			padding-right: 30px;
		}

	

		.toggle-password:hover::after {
			content: attr(title);
			position: absolute;
			top: 100%;
			left: 50%;
			transform: translateX(-50%);
			background-color: rgba(0, 0, 0, 0.7);
			color: #fff;
			padding: 5px;
			border-radius: 5px;
			font-size: 12px;
			white-space: nowrap;
		}
	</style>

</head>

<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background-image: url('/login_assets/images/bg-01.jpg');">
					<span class="login100-form-title-1">
						Reset Password
					</span>
				</div>
				<form id="loginForm" class="login100-form validate-form" method="POST" action="{{ route('reset.password.post') }}">
					@csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $userEmail }}">

				

					<div class="wrap-input100 validate-input m-b-26" data-validate="Password is required">
						<div class="relative">
							<input class="input100" type="password" required="required" name="password" id="password">
							<span class="focus-input100"></span>
							<span class="label-input100">Password :</span>
							<span class="toggle-password" onclick="togglePasswordVisibility()" title="Show Password">
								<i class="fa fa-eye" id="toggleIcon"></i>
							</span>
						</div>
					</div>
					
          
					<div class="wrap-input100 validate-input m-b-26" data-validate="Password is required">
						<div class="relative">
							<input class="input100" type="password" required="required" name="password_confirmation" id="password_confirmation">
							<span class="focus-input100"></span>
							<span class="label-input100">Confirm Password :</span>
							<span class="toggle-password" onclick="toggleConfirmPasswordVisibility()" title="Show Password">
								<i class="fa fa-eye" id="toggleIconConfirm"></i>
							</span>
						</div>
					</div>
					@if ($errors->has('password'))
                        <div style="text-align: center; margin-top: 15px; margin-bottom: 15px;">
                            <span style="color: red;" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        </div>
                    @endif
                    @if ($errors->has('password_confirmation'))
                        <div style="text-align: center; margin-top: 15px; margin-bottom: 15px;">
                            <span style="color: red;" role="alert">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        </div>
                    @endif
					<div class="container-login100-form-btn d-flex justify-content-end">
						<button class="login100-form-btn " id="loginBtn">
							<span id="btnText">Reset Password</span>
							<div class="loader" id="loader"></div>
						</button>
					</div>
				</form>


			</div>
		</div>
	</div>


	<script>
		function togglePasswordVisibility() {
			var passwordInput = document.getElementById('password');
			var toggleIcon = document.getElementById('toggleIcon');

			if (passwordInput.type === "password") {
				passwordInput.type = "text";
				toggleIcon.classList.remove('fa-eye');
				toggleIcon.classList.add('fa-eye-slash');
				toggleIcon.parentElement.setAttribute('title', 'Hide Password');
			} else {
				passwordInput.type = "password";
				toggleIcon.classList.remove('fa-eye-slash');
				toggleIcon.classList.add('fa-eye');
				toggleIcon.parentElement.setAttribute('title', 'Show Password');
			}
		}
		function toggleConfirmPasswordVisibility() {
			var passwordInput = document.getElementById('password_confirmation');
			var toggleIcon = document.getElementById('toggleIconConfirm');

			if (passwordInput.type === "password") {
				passwordInput.type = "text";
				toggleIcon.classList.remove('fa-eye');
				toggleIcon.classList.add('fa-eye-slash');
				toggleIcon.parentElement.setAttribute('title', 'Hide Password');
			} else {
				passwordInput.type = "password";
				toggleIcon.classList.remove('fa-eye-slash');
				toggleIcon.classList.add('fa-eye');
				toggleIcon.parentElement.setAttribute('title', 'Show Password');
			}
		}
		function showLoader() {
			var loader = document.getElementById('loader');
			var btnText = document.getElementById('btnText');

			loader.style.display = 'inline-block';
			btnText.style.display = 'none';

			// Optionally, you can disable the button to prevent multiple submissions
			document.getElementById('loginBtn').disabled = true;

			// Submit the form (you may want to use AJAX for asynchronous form submission)
			document.getElementById('loginForm').submit();
		}
	</script>

	<!--===============================================================================================-->
	<script src="/login_assets/vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="/login_assets/vendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
	<script src="/login_assets/vendor/bootstrap/js/popper.js"></script>
	<script src="/login_assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="/login_assets/vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="/login_assets/vendor/daterangepicker/moment.min.js"></script>
	<script src="/login_assets/vendor/daterangepicker/daterangepicker.js"></script>
	<!--===============================================================================================-->
	<script src="/login_assets/vendor/countdowntime/countdowntime.js"></script>
	<!--===============================================================================================-->
	<script src="/login_assets/js/main.js"></script>

</body>

</html>