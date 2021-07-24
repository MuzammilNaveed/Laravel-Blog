<nav class="navbar navbar-expand-lg" id="navbar" style="border-bottom: 1px solid #eceff1;">
    <div class="container">
        <div class="mobile_menu" onclick="showSidebar()"><i class="fas fa-bars"></i></div>
        <a class="navbar-brand  " href="{{url('/')}}">
            @if($setting != null && $setting != "" && $setting->site_logo != null && $setting->site_logo != "")
                <img src="{{asset('settings')}}/{{$setting->site_logo}}" style="width:45px" class="img-fluid"/> 
            @else
                <h5>Blogging Site</h5>     
            @endif   
        </a>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown ml-3">
                <a class="nav-link " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Tutorial <i class="fas fa-chevron-down"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    @foreach($menus as $menu)
                        <a class="dropdown-item" href="{{url('category')}}/{{$menu->slug}}">{{$menu->name}}</a>
                    @endforeach
                </div>
            </li>
            @if($pages != null && $pages != " ")
                @foreach($pages as $page)
                <li class="nav-item">
                    <a href="{{url('/')}}/{{$page->page_slug}}" class="nav-link  ">{{$page->page_name}}</a>
                </li>
                @endforeach
            @endif
            <li class="nav-item">
                <a href="{{url('contact_us')}}" class="nav-link">Contact Us</a>
            </li>
            
        </ul>


        <div class="" id="navbarSupportedContent">
            <div class="form-inline my-2 my-lg-0">
                <div class="nav-social ml-3">
                    <a href=""><i class="fab fa-instagram text-dark ml-3  "></i></a>
                    <i class="fas fa-moon text-dark ml-3" id="dark-mode-btn"></i>
                </div>
                <i class="fas fa-search   ml-3" id="search_icon"></i>
            </div>
        </div> 
</nav>

<div class="search_div w-100 bg-light" style="height:60%; display:none; box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);position:absolute;z-index:10">

    <div class="container pt-3">
        <div class="input-group mb-3">
            <input type="text" autocomplete="off" placeholder="Search here" class="form-control bg-light" id="search">
        </div>

        <hr>
    </div>
</div>

<div class="cs-site-overlay" style="display:none"></div>
<div class="mobile_sidebar">
    
    <div class="d-flex justify-content-between mob_top">
        <h4>Logo</h4>
        <span style="margin:11px" onclick="closeSidebar()"><i class="fas fa-times"></i></span>
    </div>
    <ul class="menu-primary">
        <li class="">
            <a href="#" id="navbarDropdown">
                Tutorial  <i class="fas fa-angle-down drpdown" style="float:right"></i>
            </a>
            <ul class="dropdown_menu">
                @foreach($menus as $menu)
                    <li>
                        <a class="dropdown-item" href="{{url('category')}}/{{$menu->slug}}">{{$menu->name}}</a>
                    </li>
                @endforeach
            </ul>
        </li>

        @foreach($pages as $page)
        <li class="nav-item">
            <a href="{{url('/')}}/{{$page->page_slug}}" class="nav-link  ">{{$page->page_name}}</a>
        </li>
        @endforeach

        <li>
            <a href="{{url('contact_us')}}">Contact Us</a>
        </li>
        
    </ul>
</div>



<script>
    function showSidebar() {
        $('.mobile_sidebar').attr('style','width:320px');
        $('.cs-site-overlay').removeAttr('style');
        $('.mobile_sidebar').addClass('animate__animated animate__slideInLeft animate__faster');
    }
    

    function closeSidebar() {
        $('.mobile_sidebar').attr('style','width:0%');
        $('.cs-site-overlay').attr('style','display:none');
        $('.mobile_sidebar').removeClass('animate__animated animate__slideInLeft animate__faster');
    }

</script>