@include('website/layout/navbar')

<style>
    .card {
        border-radius: 0px !important;
        transition: 0.3 all ease-in-out;
    }

    .card:hover {
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
    }
</style>
<div class="container">
    <div class="row">

        <div class="col-md-8 p-4">

            <p class="small text-muted">{{count($posts)}} Posts</p>

            <div class="row bg-white m-1 p-2 shadow-sm author_row">
                @if($user != null && $user != "")
                <div class="col-md-2">
                    @if($user->profile_pic != null && $user->profile_pic != "")
                    <img style="width:100px;height:90px;border-radius:100px;" src="{{asset('users')}}/{{$user->profile_pic}}" class="img-fluid mx-auto mt-1 d-block" alt="">
                    @endif
                </div>
                @endif
                <div class="col-md-10">
                    <h5>{{$user->name}}</h5>
                    <p class="small text-muted">
                        {{$user->about}}
                    </p>
                </div>
            </div>


            <div class="row">
                @foreach($posts as $post)
                <div class="col-md-4 p-1 mt-2">
                    <a href="{{url('post')}}/{{$post->slug}}">
                        <div class="card mt-2">
                            <div class="project_post">
                                <div class="project_img">
                                    <img src="{{asset('images')}}/{{$post->image}}" style="width:100%; min-height:150px; height:100px" class="img-fluid" alt="">
                                </div>
                                <div class="project_content">
                                    <ul class="p-0 m-0">
                                        <li>
                                            <span class="pst_category small text-dark">{{$post->post_category->name}}</span>
                                        </li>
                                    </ul>
                                    <h5 class="pt-2"> {{$post->title}} </h5>
                                    <p class="small text-dark"><i class="far fa-calendar-alt"></i> {{date_format($post->created_at,"d-m-Y")}}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach

            </div>

            <div class="small mt-4">{{$posts->links()}}</div>


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