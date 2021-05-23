<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!--  -->
	<link href="{{asset('admin/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
	<link class="main-stylesheet" href="{{asset('admin/pages/css/themes/corporate.css')}}" rel="stylesheet" type="text/css" />
	<script src="https://kit.fontawesome.com/5fcfcbf541.js" crossorigin="anonymous"></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<!--  -->
	<title></title>
</head>

<body style="background-color: #f4f4f4;">

	<div class="container" style="height:100vh;position: relative;">
		<div class="row" style="  margin: 0; position: absolute; top: 50%; -ms-transform: translateY(-50%); transform: translateY(-50%);">
			<div class="col-md-7">
				<img src="{{asset('website/login_bg.svg')}}" style="width:80%; height: auto;" class="img-fluid" alt="">
			</div>
			<div class="col-md-5">
				<div class="p-3 m-sm-3">
					<h2 class="font-weight-bolder">Get Started with your Dashboard</h2>
					<span>Sign in to Your Account</span>
					<form method="POST" action="{{url('login_user')}}" class="mt-3">
						@csrf
						<div class="row">
							<div class="form-group form-group-default mb-0">
								<label class="text-muted small">Email <span class="text-danger">*</span></label> </label> 
								<input name="email" type="email" class="form-control"  placeholder="Your Email Address">
							</div>
							@error('email')
								<div class="small text-danger">{{ $message }}</div>
							@enderror
							@if (\Session::has('nouser'))
								<span class="text-danger small">
									{!! \Session::get('nouser') !!}
								</span>
							@endif

							<div class="user-password-div w-100 mt-2">
								<span class="block input-icon input-icon-right">
									<div class="form-group form-group-default mb-0">
										<label class="text-muted small">Password <span class="text-danger">*</span></label>
										<input type="password" name="password" placeholder="User Password" class="form-control">
										<span toggle="#password-field" class="fa fa-fw fa-eye field-icon show-password-btn mr-2" style="float: right; margin-top: -25px; cursor:pointer"></span>
									</div>
								</span>
							</div>
							@error('password')
								<div class="text-danger small">{{ $message }}</div>
							@enderror

							
							@if (\Session::has('deactive'))
								<span class="text-danger small">
									{!! \Session::get('deactive') !!}
								</span>
							@endif
							<button type="submit" class="btn btn-primary btn-lg btn-block mt-3">Login</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>



	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script>
		$(".user-password-div").on('click', '.show-password-btn', function() {
			$(this).toggleClass("fa-eye fa-eye-slash");
			var input = $(".user-password-div input[name='password']");
			if (input.attr("type") === "password") {
				input.attr("type", "text");
			} else {
				input.attr("type", "password");
			}
		});
	</script>
</body>

</html>