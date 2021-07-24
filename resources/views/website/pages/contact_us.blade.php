<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/5fcfcbf541.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('website/custom.css').'?ver='.rand()}}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <title>Categories Page</title>
</head>

<style>
    .w-5 {
        width: 12px;
        height: 12px;
    }
    .leading-5 {
        margin-top: 10px;
    }
</style>
<body>

    @include('website/layout/navbar')
    
    <div class="container mt-5" style="height:70vh;">
        <div class="row">
            <!-- <div class="col-md-6">

                <form action="{{url('save_contact')}}" method="post">
                    @csrf
                    <div class="row">
                            @if(session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                            @endif
                    
                        <div class="col-md-6">
                            <label for="name" class="small font-weight-bold">Your Name </label>
                            <input type="text" class="form-control" name="name" value="{{old('name')}}">
                            @error('name')
                                <div class="small text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="small font-weight-bold">Your Email </label>
                            <input type="text" class="form-control" name="email" value="{{old('email')}}">
                            @error('email')
                                <div class="small text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label for="subject" class="small font-weight-bold"> Subject </label>
                            <input type="text" class="form-control" name="subject" value="{{old('subject')}}">
                            @error('subject')
                                <div class="small text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <label for="message" class="small font-weight-bold"> Message </label>
                            <textarea name="message" cols="30" rows="5" class="form-control">{{old('message')}}</textarea>
                            @error('message')
                                <div class="small text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Send</button>
                </form>

            </div> -->
            
            <div class="col-md-12">
                <h1>Contact Us</h1>
                <p>Feel free to contact us if you have any queries. We will get back to you promptly.  </p>

                Email: <a href="mailto:laravelproject4u@gmail.com">laravelproject4u@gmail.com</a>
            </div>
        </div>
    </div>

    @include('website/layout/footer')

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

</body>

</html>