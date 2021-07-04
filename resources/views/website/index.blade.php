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
    <title>Home Page</title>
</head>
<style>
    .dropdown:hover>.dropdown-menu {
        display: block;
    }

    .img {
        width: 100%;
        height: 100%;
    }

    .small_nav li {
        display: inline;
        margin-right: 20px;
    }

    .small_nav li a {
        text-decoration: none;
    }

    .alltags:hover {
        background-color: #282828 !important;
        transition: 0.3s ease-in-out;
        color: #fff;
    }

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

    <section class="container">
        <div class="row">
            <div class="col-md-7 col-lg-7 col-sm-12">
                <a href="{{url('post')}}/{{$singleheader['slug']}}">
                    <div class="header_post mt-2" style="position:relative">
                        <div class="gradient"></div>
                        <img src="{{asset('images')}}/{{$singleheader['image']}}" style='height:420px; width: 100%; object-fit: cover; ' class="img-fluid" alt="">
                        <div class="header_content" style="position:absolute; bottom:4px;left:10px" class="img-fluid">
                            <span class="badge bg-dark text-white badge-pill pt-1 pr-3 pl-3 pb-1">{{$singleheader['category']['name']}}</span>
                            <h5 class="bg-dark text-white p-2 mt-2">{{$singleheader['title']}}</h5>
                            <p class="small text-white"><i class="far fa-calendar-alt"></i> {{$singleheader['created_at']}} </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-5 col-lg-5 col-sm-3">
                @foreach($posts as $post)
                <a href="{{url('post')}}/{{$post->slug}}">
                    <div class="header_post mt-2" style="position:relative">
                        <div class="gradient"></div>
                        <img src="{{asset('images')}}/{{$post->image}}" style='height:205px; width: 100%; object-fit: cover' class="img-fluid" alt="">
                        <div class="header_content" style="position:absolute; bottom:4px;left:10px;">
                            <span class="badge bg-dark text-white badge-pill pt-1 pr-3 pl-3 pb-1">{{$post['category']['name']}}</span>
                            <h5 class="bg-dark text-white p-2 mt-2"> {{$post->title}} </h5>
                            <p class="small text-white"><i class="far fa-calendar-alt"></i> {{$post->created_at}} </p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>



    <div class="container">

        <div class="d-flex justify-content-between mt-5">
            <h2 style="font-size:1.6rem; font-weight:800">All Projects</h2>
            <a href="#">view more <i class="fas fa-long-arrow-alt-right"></i></a>
        </div>

        <div class="row">
            @foreach($feature_posts as $post)
            <div class="col-md-3">
                <a href="{{url('post')}}/{{$post->slug}}">
                    <div class="project_post">

                        <div class="project_img" style="position:relative">
                            <img src="{{asset('images')}}/{{$post->image}}" style="width:100%; min-height:150px; height:100px" class="img-fluid" alt="">
                            <span style="position:absolute;top:5px;left:5px;" class="badge bg-dark badge-pill text-white pt-1 pr-3 pl-3 pb-1">{{$post['category']['name']}}</span>
                        </div>
                        <div class="project_content p-0">
                            <h5 class="pt-2"><?php echo substr($post->title . '...', 0, 50); ?> </h5>
                            <p class="small text-dark m-0"><i class="far fa-calendar-alt"></i> {{$post->created_at}}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach

        </div>




        <div class="d-flex justify-content-between mt-5">
            <h2 style="font-size:1.6rem; font-weight:800">All Tutorials</h2>
        </div>

        <div class="row mt-2">

            <div class="col-md-8">
                @foreach($tutorial_posts as $post)
                <a href="{{url('post')}}/{{$post->slug}}">
                    <div class="row tutorial">
                        <div class="col-md-6">
                            <img src="{{asset('images')}}/{{$post->image}}" style="width:100%; height:auto" class="img-fluid" alt="">
                        </div>
                        <div class="col-md-6 tutorial_content">
                            <span class="badge bg-dark text-white badge-pill pt-1 pr-3 pl-3 pb-1">{{$post['category']['name']}}</span>
                            <h2>{{$post->title}}</h2>
                            <span class="small text-muted m-0 p-0"><i class="far fa-calendar-alt"></i> {{$post->created_at}}</span>
                        </div>
                    </div>
                </a>
                <hr>
                @endforeach
                <span class="small">{{$tutorial_posts->links()}}</span>
            </div>

            <div class="col-md-4">

                <!-- right sidebar -->

                @include('website/layout/rightside')

            </div>
        </div>

    </div>

    @include('website/layout/footer')

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.dropdown_menu').css('display','none');
        });
        

        $("#search_icon").click(function() {
            $(".search_div").slideToggle();
        });

        $(".drpdown").click(function() {
            $(this).toggleClass("fas fas fa-angle-up");
            $(".dropdown_menu").slideToggle();
        })


        // dark mode
        // let darkMode = localStorage.getItem("darkMode");
        // const darkModeToggle = document.querySelector("#dark-mode-btn");

        // const enableDarkMode = () => {
        //     document.body.classList.add("darkmode");
        //     localStorage.setItem("darkMode", "enabled");
        // }

        // const disabledDarkMode = () => {
        //     document.body.classList.remove("darkmode");
        //     localStorage.setItem("darkMode", null);
        // }

        // if (darkMode === "enabled") {
        //     enableDarkMode();
        // }

        // darkModeToggle.addEventListener("click", () => {
        //     darkMode = localStorage.getItem("darkMode");
        //     if (darkMode !== "enabled") {
        //         enableDarkMode();
        //     } else {
        //         disabledDarkMode();
        //     }
        // });
    </script>
</body>

</html>