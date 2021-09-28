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
    <link rel="stylesheet" href="{{asset('website/glide.core.min.css')}}">
    <link rel="stylesheet" href="{{asset('website/glide.theme.min.css')}}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <meta name="cXenseParse:url" content="{{$setting->site_url}}" />
    <meta name="cXenseParse:description" content="{{$setting->site_description}}" />
    <meta property="og:description" content="{{$setting->site_description}}"/>

    <meta property="og:image" content="{{asset('settings')}}/{{$setting->site_logo}}" />

	<meta property="og:type" content="website" />
    <meta name="description" content="{{$setting->site_description}}" />
	<meta name="title" content="{{$setting->site_name}}" />

    <meta name="keywords" content="{{$setting->site_keywords}}">
    <link rel="icon" href="{{asset('settings')}}/{{$setting->site_favicon}}" sizes="32x32" />
    <title>{{$setting->site_name}}</title>

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

<nav class="navbar navbar-expand-lg" id="navbar" style="border-bottom: 1px solid #eceff1;">
    <div class="container">
        <div class="mobile_menu" onclick="showSidebar()"><i class="fas fa-bars"></i></div>
        <a class="navbar-brand  " href="{{url('/')}}">
            @if($setting != null && $setting != "" && $setting->site_logo != null && $setting->site_logo != "")
                <img src="{{asset('settings')}}/{{$setting->site_logo}}" style="width:45px" class="img-fluid"/> 
            @else
                <h5>My Blog</h5>
            @endif   
        </a>
        <ul class="navbar-nav mr-auto" id="navbar_links">
            @foreach($menuItems as $item)
                <li class="nav-item {{count($item->childs) > 0 ? 'dropdown' : ''}}">
                    <a class="nav-link" href="#">{{$item->name}} <?= count($item->childs) > 0 ? '<i class="fas fa-chevron-down"></i>' : '' ?>  </a>
                    @if(count($item->childs) > 0)
                        @include('website.layout.child',['childs' => $item->childs])
                    @endif
                </li>
            @endforeach
            <li class="nav-item">
                <a class="nav-link" href="{{url('contact_us')}}"> Contact us </a>
            </li>
        </ul>


        <div class="" id="navbarSupportedContent">
            <div class="form-inline my-2 my-lg-0">
                <div class="nav-social ml-3">
                    <!-- <a href=""><i class="fab fa-instagram text-dark ml-3  "></i></a>
                    <i class="fas fa-moon text-dark ml-3" id="dark-mode-btn"></i> -->
                </div>
                <i class="fas fa-search  ml-3 search_icon" style="cursor:pointer"></i>
            </div>
        </div> 

</nav>

<div class="search_div w-100 bg-light" style="height:50%; display:none; box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);position:absolute;z-index:10">

    <div class="container pt-1">
        <form>
            <div class="input-group mb-3">
                <input type="text" autocomplete="off" placeholder="Search here" class="form-control bg-light" id="custom_search">
            </div>
            <div class="all_tags mt-3">
                @foreach($tags as $tag)
                    <a href="/tag/{{$tag->slug}}" class="badge bg-light __category_badge text-dark mt-2">{{$tag->name}}</a>
                @endforeach
            </div>
        </form>
        <div class="show_custom_results" style="display:none">
        </div>
    </div>
</div>

<div class="cs-site-overlay" style="display:none"></div>

<div class="mobile_sidebar">
    
    <div class="d-flex justify-content-between mob_top">
        @if($setting != null && $setting != "" && $setting->site_logo != null && $setting->site_logo != "")
            <img src="{{asset('settings')}}/{{$setting->site_logo}}" style="width:45px" class="img-fluid"/> 
        @else
            <h5>My Blog</h5>     
        @endif   
        <span style="margin:11px;cursor:pointer" onclick="closeSidebar()"><i class="fas fa-times"></i></span>
    </div>
    
    <ul class="menu-primary">
        @foreach($menuItems as $item)
            <li class="nav-item {{count($item->childs) > 0 ? 'dropdown' : ''}}">
                <a class="nav-link" href="#">{{$item->name}} <?= count($item->childs) > 0 ? '<i class="fas fa-chevron-down"></i>' : '' ?>  </a>
                @if(count($item->childs) > 0)
                    @include('website.layout.child',['childs' => $item->childs])
                @endif
            </li>
        @endforeach           
    </ul>
    
</div>
