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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <title>Post Page</title>

    <style>
        .w-5 {
        width: 12px;
        height: 12px;
    }
    .leading-5 {
        margin-top: 10px;
    }
    </style>
</head>

<body>


    @include('website/layout/navbar')


    <div class="container">
        <div class="row">

            <div class="col-md-8 p-4">

                <p class="small text-muted">{{count($posts)}} Posts</p>

                <div class="row border p-2">
                    @if($user != null && $user != "" && $user->profile_pic != null && $user->profile_pic != "")
                    <div class="col-md-2">
                        <img style="width:100px;height:90px;border-radius:100px;" 
                            src="{{asset('users')}}/{{$user->profile_pic}}" class="img-fluid mx-auto mt-1 d-block" alt="">
                    </div>
                    @endif
                    <div class="col-md-10">
                        <h3>{{$user->name}}</h3>
                        <p class="small text-muted">
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates, omnis error. Quibusdam
                            amet ea aliquid porro accusamus labore illum ratione, sed et, vitae quidem architecto id
                            debitis ullam fugit ipsam iste, eaque aliquam doloribus! Omnis doloribus laboriosam
                        </p>
                    </div>
                </div>


                <div class="row">
                    @foreach($posts as $post) 
                        <div class="col-md-6 mt-2">
                            <a href="{{url('post')}}/{{$post->slug}}">
                                <div class="project_post mt-3">
                                    <div class="project_img">
                                        <img src="{{asset('images')}}/{{$post->image}}" style="width:100%; min-height:150px; height:100px" class="img-fluid" alt="">
                                        <span style="position:absolute;bottom:5px;left:5px;" class="badge badge-pill bg-dark text-white pt-1 pr-3 pl-3 pb-1">{{$post->post_category->name}}</span>
                                    </div>
                                    <div class="project_content">
                                        <h5 class="pt-2"><?php echo substr($post->title . '...', 0, 50); ?> </h5>
                                        <p class="small text-dark"><i class="far fa-calendar-alt"></i> {{$post->created_at}}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                    <span class="small">{{$posts->links()}}</span>
                </div>
                

            </div>


            <!-- category & recent post div -->
            <div class="col-md-4 p-4">

                @include('website/layout/rightside')

            </div>

        </div>

    </div>

    @include('website/layout/footer')

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

</body>
</html>