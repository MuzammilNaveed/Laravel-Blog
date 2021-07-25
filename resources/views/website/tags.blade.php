

    @include('website/layout/navbar')
    
    <div class="container">
        <div class="row">
            <div class="col-md-8 p-4">
                <section class="" id="__category_content">
                    <span class="small">Browse Tag</span>

                    <h2 class="font-weight-bolder">{{$tag->name != null ? $tag->name : ''}}</h2>
                    <span class="small text-muted" id="post_count">{{sizeof($posts)}} posts</span>

                    <hr>

                    <div class="row">
                        @foreach($posts as $post) 
                            <div class="col-md-6 mt-2">
                                <a href="{{url('post')}}/{{$post[0]['slug']}}">
                                    <div class="project_post mt-3">
                                        <div class="project_img">
                                            <img src="{{asset('images')}}/{{$post[0]['image']}}" style="width:100%; min-height:150px; height:100px" class="img-fluid" alt="">
                                        </div>
                                        <div class="project_content">
                                            <ul class="p-0 m-0">
                                                <li>
                                                    <span class="pst_category small text-dark">{{$post[0]['category_name']['name']}}</span>
                                                </li>
                                            </ul>
                                            <h5 class="pt-2">{{ substr($post[0]['title'] .'...' , 0,40) }}</h5>
                                            <p class="small text-muted"><i class="far fa-calendar-alt"></i> {{date_format($post[0]['created_at'],"d-m-Y")}} </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <hr>

                </section>
            </div>

            <div class="col-md-4 p-4">

                @include('website/layout/rightside')

            </div>

        </div>
    </div>

    @include('website/layout/footer')

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="{{asset('website/js/menu.js')}}"></script>

</body>
</html>