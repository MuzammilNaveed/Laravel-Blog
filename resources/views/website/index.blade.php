

   @include('website/layout/navbar')

    <section class="container">
        <div class="row">
            <div class="col-md-7 col-lg-7 col-sm-12">
                <a href="{{url('post')}}/{{$singleheader['slug']}}">
                    <div class="header_post mt-2" style="position:relative">
                        <div class="gradient"></div>
                        <img src="{{asset('images')}}/{{$singleheader['image']}}" style='height:420px; width: 100%; object-fit: cover; ' class="img-fluid" alt="">
                        <div class="header_content" style="position:absolute; bottom:4px;left:10px" class="img-fluid">
                            <span class="badge bg-dark text-white pt-1 pr-3 pl-3 pb-1">{{$singleheader['category']['name']}}</span>
                            <h5 class="bg-dark text-white p-2 mt-2">{{$singleheader['title']}}</h5>
                            <p class="small text-white"><i class="far fa-calendar-alt"></i>  {{date_format($singleheader['created_at'],"d-m-Y")}} </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-5 col-lg-5 col-sm-12">
                @foreach($posts as $post)
                <a href="{{url('post')}}/{{$post->slug}}">
                    <div class="header_post mt-2" style="position:relative">
                        <div class="gradient"></div>
                        <img src="{{asset('images')}}/{{$post->image}}" style='height:205px; width: 100%; object-fit: cover' class="img-fluid" alt="">
                        <div class="header_content" style="position:absolute; bottom:4px;left:10px;">
                            <span class="badge bg-dark text-white pt-1 pr-3 pl-3 pb-1">{{$post['category']['name']}}</span>
                            <h5 class="bg-dark text-white p-2 mt-2"> {{$post->title}} </h5>
                            <p class="small text-white"><i class="far fa-calendar-alt"></i>  {{date_format($post->created_at,"d-m-Y")}} </p>
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
                        </div>
                        <div class="project_content p-0" style="position:relative">
                            <ul class="p-0 m-0">
                                <li>
                                    <span class="pst_category small text-dark">{{$post['category']['name']}}</span>
                                </li>
                            </ul>
                            <div style="position:relative">
                                <h5 class="pt-2">{{ substr($post->title.'...' , 0,40) }} </h5>
                                <p class="small text-muted m-0"><i class="far fa-calendar-alt"></i> {{date_format($post->created_at,"d-m-Y")}} </p>
                            </div>
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
                            <ul class="p-0 m-0">
                                <li>
                                    <span class="pst_category small text-dark">{{$post['category']['name']}}</span>
                                </li>
                            </ul>
                            <h2>{{$post->title}}</h2>
                            <span class="small text-muted m-0 p-0"><i class="far fa-calendar-alt"></i>  {{date_format($post->created_at,"d-m-Y")}}</span>
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
    <script type="text/javascript" src="{{asset('website/js/menu.js')}}"></script>

</body>
</html>