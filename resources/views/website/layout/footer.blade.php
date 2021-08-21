<footer class="mt-5 shadow-sm" style="background-color: #eeeeee;">
    <div class="container">
        <div class="row p-3 text-dark footer_row">
            <div class="col-md-4">
                <h2 class="w-800">{{$setting->site_name}}</h2>
                <small>© Copyright 2020 LaravelProject.</small>
            </div>
            <div class="col-md-4 text-center footer_links">
                <ul>
                    <li >
                        <a href="{{url('about_us')}}">About us</a>
                    </li>
                    <li>
                        <a href="{{url('contact_us')}}">Contact us</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <div class="d-flex mt-3" style="float:right">
                    <a href="{{$setting->facebook}}" class="btn"><i class="fab fa-facebook text-white"></i> </a>
                    <a href="{{$setting->twitter}}" class="btn"><i class="fab fa-twitter text-white"></i></a>
                    <a href="{{$setting->linkedin}}" class="btn"><i class="fab fa-instagram text-white"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>

