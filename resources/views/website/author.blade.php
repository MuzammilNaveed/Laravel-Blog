

    @include('website/layout/navbar')


    <div class="container">
        <div class="row">

            <div class="col-md-8 p-4">

                <p class="small text-muted">{{count($posts)}} Posts</p>

                <div class="row bg-light p-2 author_row">
                    @if($user != null && $user != "")
                    <div class="col-md-2">
                        @if($user->profile_pic != null && $user->profile_pic != "")
                        <img style="width:100px;height:90px;border-radius:100px;" 
                            src="{{asset('users')}}/{{$user->profile_pic}}" class="img-fluid mx-auto mt-1 d-block" alt="">
                        @endif
                    </div>
                    @endif
                    <div class="col-md-10">
                        <h2>{{$user->name}}</h2>
                        <p class="small text-muted">
                            {{$user->about}}
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
                                    </div>
                                    <div class="project_content">
                                        <ul class="p-0 m-0">
                                            <li>
                                                <span class="pst_category small text-dark">{{$post->post_category->name}}</span>
                                            </li>
                                        </ul>
                                        <h5 class="pt-2"><?php echo substr($post->title . '...', 0, 50); ?> </h5>
                                        <p class="small text-dark"><i class="far fa-calendar-alt"></i>  {{date_format($post->created_at,"d-m-Y")}}</p>
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
    <script type="text/javascript" src="{{asset('website/js/menu.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    
</body>
</html>