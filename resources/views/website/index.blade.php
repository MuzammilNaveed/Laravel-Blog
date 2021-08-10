@include('website/layout/navbar')

<style type="text/css">
    .glide__arrow {
        position: absolute;
        display: block;
        top: 50%;
        z-index: 2;
        background-color: rgba(226, 229, 230, .5);
        opacity: 1;
        height: 2.5rem;
        width: 2.5rem;
        border-style: none;
        border-radius: 50% !important;
        cursor: pointer;
        transform: translateY(-40%);
        line-height: 1;
    }

    .glide__arrow:hover {
        background-color: #e2e5e6;
    }

    .glide__bullet {
        width: 30px !important;
        height: 3px !important;
        border-radius: 2px !important;
    }

    .glide__slides {
        overflow: initial !important;
    }

    .card {
        border-radius: 0px !important;
        transition: 0.3 all ease-in-out;
    }

    .card:hover {
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
    }
</style>

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
                        <p class="small text-white"><i class="far fa-calendar-alt"></i> {{date_format($singleheader['created_at'],"d-m-Y")}} </p>
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
                        <p class="small text-white"><i class="far fa-calendar-alt"></i> {{date_format($post->created_at,"d-m-Y")}} </p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>



<div class="container mt-5">

    <!-- project section -->
    <div class="row">
        <div class="col-md-3">
            <div class="project_content">
                <h2>Checkout over Awesome Projects</h2>
                <a href="#"> view more</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="glide_1">
                <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides">
                        @foreach($feature_posts as $post)
                        <li class="glide__slide">
                            <a href="{{url('post')}}/{{$post->slug}}">
                                <div class="card">
                                    <div class="project_post">
                                        <div class="project_img" style="position:relative">
                                            <img src="{{asset('images')}}/{{$post->image}}" style="width:100%; min-height:150px; height:100px" class="img-fluid" alt="">
                                        </div>
                                        <div class="project_content p-2" style="position:relative">
                                            <ul class="p-0 m-0">
                                                <li>
                                                    <span class="pst_category small text-dark">{{$post['category']['name']}}</span>
                                                </li>
                                            </ul>
                                            <div style="position:relative">
                                                <h5 class="pt-2">{{ substr($post->title , 0,35) }} </h5>
                                                <p class="small text-muted m-0"><i class="far fa-calendar-alt"></i> {{date_format($post->created_at,"d-m-Y")}} </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="glide__arrows" data-glide-el="controls">
                    <button class="glide__arrow glide__arrow--left" data-glide-dir="<"> <i class="fas fa-chevron-left"></i> </button>
                    <button class="glide__arrow glide__arrow--right" data-glide-dir=">"> <i class="fas fa-chevron-right"></i> </button>
                </div>
            </div>
        </div>
    </div>


    <div class="d-flex justify-content-between mt-5">
        <h2 style="font-size:1.6rem; font-weight:800">All Tutorials</h2>
    </div>

    <div class="row mt-2">

        <div class="col-md-8">
            <div class="row">

                @foreach($tutorial_posts as $post)
                <div class="col-md-6">
                    <a href="{{url('post')}}/{{$post->slug}}">
                        <div class="card mt-2 mb-2">
                            <div class="project_post">
                                <div class="project_img" style="position:relative">
                                    <img src="{{asset('images')}}/{{$post->image}}" style="width:100%; min-height:200px; height:100px" class="img-fluid" alt="">
                                </div>
                                <div class="project_content p-2" style="position:relative">
                                    <ul class="p-0 m-0">
                                        <li>
                                            <span class="pst_category small text-dark">{{$post['category']['name']}}</span>
                                        </li>
                                    </ul>
                                    <div style="position:relative">
                                        <h5 class="pt-2">{{ substr($post->title,0,50) }} </h5>
                                        <p class="small text-muted m-0"><i class="far fa-calendar-alt"></i> {{date_format($post->created_at,"d-m-Y")}} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="small mt-3">{{$tutorial_posts->links()}}</div>


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
<script type="text/javascript" src="{{asset('website/js/glide.min.js')}}"></script>
<script>
    new Glide('.glide_1', {
        type: "slider",
        startAt: 0,
        perView: 3.5,
        breakpoints: {
            1024: {
                perView: 4
            },
            600: {
                perView: 2
            },
            400: {
                perView: 1.3
            }
        }
    }).mount();
</script>

</body>

</html>