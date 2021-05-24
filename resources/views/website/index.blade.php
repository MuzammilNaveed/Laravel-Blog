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
    <!-- <link rel="stylesheet" href="{{asset('website/custom.css').'?ver='.rand()}}"> -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
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
</style>
<body>


<nav class="navbar navbar-expand-lg navbar-light bg-white" style="border-bottom: 3px solid #eceff1;">
  <div class="container">
  <a class="navbar-brand animate__animated animate__bounce" href="{{url('/')}}">Blog</a>
  <span class="animate__animated animate__bounce">|</span>
  <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown ml-3">
        <a class="nav-link dropdown-toggle animate__animated animate__bounce" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Tutorial
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle animate__animated animate__bounce" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Categories
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
    </ul>
  

  <div class="" id="navbarSupportedContent">
    <div class="form-inline my-2 my-lg-0">
        <i class="fas fa-sun text-warning" id="dark-mode-btn"></i>
        <i class="fas fa-search animate__animated animate__bounce ml-2" id="search_icon"></i>
        </div>
    </div>
  </div>
</nav>

    <div class="search_div w-100" style="height:240px; display:none; background:#fff; box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);position:absolute;z-index:10" >

        <div class="container pt-3">
            <div class="input-group mb-3">
                <input type="text" autocomplete="off" placeholder="Search here" class="form-control" id="search" >
            </div>

            <hr>

            <div class="searches">
                <span class="badge badge-pill bg-primary">123</span>

            </div>

        </div>
    </div>



    <div class="container mt-3">



        <div class="row">
            <div class="col-md-7 col-lg-7 col-sm-12">
            @foreach($singleheader as $post) 
                    @if($post->section == 1)
                <div class="header_post mt-2" style="position:relative">
                    <img src="{{asset('images')}}/{{$post->image}}" style='height:420px; width: 100%; object-fit: cover' class="img-fluid" alt="">
                    <div class="header_content" style="position:absolute; bottom:4px;left:10px" class="img-fluid">
                        <span class="badge bg-dark text-white pt-1 pr-3 pl-3 pb-1">Category</span>
                        <h5 class="bg-dark text-white p-2 mt-2">{{$post->title}}</h5>
                        <p class="small text-white"><i class="far fa-calendar-alt"></i> {{$post->created_at}} </p>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            <div class="col-md-5 col-lg-5 col-sm-3">
                @foreach($posts as $post) 
                    @if($post->section == 1)
                    <div class="header_post mt-2" style="position:relative">
                        <img src="{{asset('images')}}/{{$post->image}}" style='height:205px; width: 100%; object-fit: cover' class="img-fluid" alt="">
                        <div class="header_content" style="position:absolute; bottom:4px;left:10px;">
                            <span class="badge bg-dark text-white pt-1 pr-3 pl-3 pb-1">Category</span>
                            <h5 class="bg-dark text-white p-2 mt-2"> {{$post->title}} </h5>
                            <p class="small text-white"><i class="far fa-calendar-alt"></i> {{$post->created_at}} </p>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>

    </div>









    <div class="container" style="margin-top: 200px;">

        <!-- all project -->
        <div class="d-flex justify-content-between mt-3">
            <h2 style="font-size:1.6rem; font-weight:800">All Projects</h2>
            <a href="#" class="small">View more</a>
        </div>

        <div class="row">
            @foreach($posts as $post) 
                @if($post->section == 2)
                    <div class="col-md-3">
                        <a href="{{url('post')}}/{{$post->slug}}">
                            <div class="project_post" style="  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);">
                                <div class="project_img">
                                    <img src="{{asset('images')}}/{{$post->image}}" style="width:100%; min-height:150px; height:100px" class="img-fluid" alt="">
                                    <span style="position:absolute;bottom:5px;left:5px;" class="badge bg-dark text-white pt-1 pr-3 pl-3 pb-1">Category</span>
                                </div>
                                <div class="project_content">
                                    <h2>{{$post->title}}</h2>
                                    <p class="small text-dark"><i class="far fa-calendar-alt"></i> {{$post->created_at}}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
          
        </div>




        <div class="d-flex justify-content-between mt-5">
            <h2 style="font-size:1.6rem; font-weight:800">All Tutorials</h2>
            <a href="#" class="small"></a>
        </div>

        @foreach($posts as $post) 
            @if($post->section == 3)
            <a href="{{url('post')}}/{{$post->slug}}">
                <div class="row">
                    <div class="col-md-4"><img src="{{asset('images')}}/{{$post->image}}" style="width:100%; height:auto" class="img-fluid" alt=""></div>
                    <div class="col-md-4">
                        <h2 style="font-size:1.825rem; font-weight:800">{{$post->title}}</h2> <br>
                        <p class="small text-muted m-0 p-0"><i class="far fa-calendar-alt"></i> {{$post->created_at}}</p>    
                    </div>
                    <div class="col-md-4"><p class="small"><?php echo substr($post->description,930); ?></p></div>
                </div>
            </a>
            <hr>
            @endif
        @endforeach

    </div>






    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
        $("#search_icon").click(function() {
            $(".search_div").slideToggle();
        });

        // dark mode
        let darkMode = localStorage.getItem("darkMode");
        const darkModeToggle = document.querySelector("#dark-mode-btn");

        const enableDarkMode = () => {
            document.body.classList.add("darkmode");
            localStorage.setItem("darkMode", "enabled");
        }

        const disabledDarkMode = () => {
            document.body.classList.remove("darkmode");
            localStorage.setItem("darkMode",null);
        }

        if(darkMode === "enabled") {
            enableDarkMode();
        }

        darkModeToggle.addEventListener("click",() => {
            darkMode = localStorage.getItem("darkMode");
            if(darkMode !== "enabled") {
                enableDarkMode();
            }else{
                disabledDarkMode();
            }
        });

    </script>
</body>
</html> 