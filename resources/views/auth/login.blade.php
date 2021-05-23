<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
	<meta name="author" content="Bootlab">

	<title>Login</title>
	<link rel="canonical" href="dashboard-default.html" />
	<link rel="shortcut icon" href="img/favicon.ico">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

</head>
<body>

<div class="main w-100">
		<main class="content d-flex p-0">
			<div class="container d-flex flex-column">
				<div class="row h-100">
					<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
						<div class="d-table-cell align-middle">

							<div class="text-center mt-4">
								<h1 class="h2">Welcome.</h1>
								<p class="lead">
									Sign in to your account to continue
								</p>
							</div>

							<div class="card" style="box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);">
								<div class="card-body">
									<div class="m-sm-4">
										<form id="loginForm">
											<div class="form-group">
												<label>Email</label>
												<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
											</div>
											<div class="form-group">
												<label>Password</label>
												<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
											</div>
											<div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="remember">
                                                        {{ __('Remember Me') }}
                                                    </label>
                                                </div>
											</div>
											<div class="text-center mt-3">
                                                <div class="">
                                                    <button type="submit" class="btn btn-block btn-primary">
                                                        {{ __('Login') }}
                                                    </button>
                                                </div>
											</div>
										</form>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</main>
	</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
		
<script>
    $(document).ready(function () {

		var notyf = new Notyf( {
			duration: 1500,
			position: {
				x: 'right',
				y:'top'
			}
		});


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }  
        })

        $("#loginForm").submit(function(event) {
            event.preventDefault();

            var loginData = {
                'email' : $('input[name=email]').val(),
                'password' : $('input[name=password]').val(),
                'remember' : $('input[name=remember]').is(':checked'),
            }

            $.ajax({
                type: 'POST',
                url: '/login_user',
                data: loginData,
                success:function(data) {
                    console.log(data , "a");
					
					if(data.status == 200 & data.success == true) {
						notyf.success(data.message);
						setTimeout(() => {
							window.location  = "{{route('dashboard.index')}}";
						}, 800);
					}else{
						notyf.error(data.message);
					}
                },
                error:function(e) {
                    console.log(e);
                }
                
            })

        })



    })
</script>
</body>
</html>

