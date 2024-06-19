<!DOCTYPE html>
<html lang="en">

<head>
	<title> PASSWORD RESET | {{ env("APP_NAME")  }} </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="<?php asset('images/logo/logo.png') ?>" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_assets/vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_assets/vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_assets/vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_assets/vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_assets/vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_assets/vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="login_assets/css/main.css">
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
		.login100-form-back-btn{
			    width: 0%;
		}
		
	</style>

</head>

<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background-image: url('login_assets/images/bg-01.jpg');">
					<span class="login100-form-title-1">
						Reset Password
					</span>
				</div>
                @if (Session::has('message'))
                    <div style="text-align: center; margin-top: 15px; margin-bottom: 15px;">
                        <span style="color: green;" role="alert">
                            <strong>{{ Session::get('message') }}</strong>
                        </span>
                    </div>
                @endif
				<form id="loginForm" class="login100-form validate-form" method="POST" action="{{ route('forget.password.post') }}">
					@csrf


					<div class="wrap-input100 validate-input m-b-26" data-validate="Email is required">

						<input id="emailInput" class="input100" type="email" required="required" name="email" required>
						<span class="focus-input100"></span>
						<span class="label-input100">Email :</span>

					</div>
					<div class="mb-2" style="display: flex;flex-direction:column">
						<div>
							@error('email')
							<span style="color: red;" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
						
					</div>
					<div class="container-login100-form-btn d-flex justify-content-end">
						<button type="submit" class="login100-form-btn " id="loginBtn" onclick="submitForm()">
							<span id="btnText">Send Password Reset Link</span>
							<div class="loader" id="loader"></div>
						</button>
					</div>
					<div class="container-login100-form-btn d-flex justify-content-center mt-2">
						<a href="#" onclick="javascript:window.history.back(-1);return false;" class="login100-form-btn login100-form-back-btn">
							<span id="btnText" class="text-white">Back</span>
						</a>
					</div>
				</form>


			</div>
		</div>
	</div>


	<script>
		function validateEmail(email) {
            var re = /\S+@\S+\.\S+/;
            return re.test(email);
        }

    function submitForm() {
        var emailInput = document.getElementById('emailInput');
        var loader = document.getElementById('loader');
        var btnText = document.getElementById('btnText');

        if (!validateEmail(emailInput.value)) {
            return;
        }

        loader.style.display = 'inline-block';
        btnText.style.display = 'none';

        document.getElementById('loginBtn').disabled = true;

        document.getElementById('loginForm').submit();
    }
	</script>

	<!--===============================================================================================-->
	<script src="login_assets/vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="login_assets/vendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
	<script src="login_assets/vendor/bootstrap/js/popper.js"></script>
	<script src="login_assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="login_assets/vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="login_assets/vendor/daterangepicker/moment.min.js"></script>
	<script src="login_assets/vendor/daterangepicker/daterangepicker.js"></script>
	<!--===============================================================================================-->
	<script src="login_assets/vendor/countdowntime/countdowntime.js"></script>
	<!--===============================================================================================-->
	<script src="login_assets/js/main.js"></script>

</body>

</html>