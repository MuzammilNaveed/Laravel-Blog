<div class="right-category bg-white shadow-sm p-3">
    <h5 class="p-0 w-800">Categories</h5>
    <div class="category" id="__categories">
        @foreach($categories as $category)
        <a href="{{url('category')}}/{{$category->slug}}" class="badge bg-light __category_badge text-dark mt-2">{{$category->name}}</a>
        @endforeach
    </div>
</div>

<!-- popular posts -->
<div class="recent mt-3 bg-white shadow-sm p-3">
    <h5 class="p-0 w-800">Popular Posts</h5>
    <div class="__recent_post mt-3" id="__recent_post">
        @foreach($popular_posts as $post)
        <a href="{{url('post')}}/{{$post->slug}}">
            <div class="row singlePopularPost p-2">
                <div class="col-4"><img src="{{asset('images')}}/{{$post->image}}" style="width:100%; height:70px;" class="img-fluid rounded" alt=""></div>
                <div class="col-8">
                    <div class="headers_content">
                        <h2><?php echo substr($post->title . '...', 0, 40); ?></h2>
                        <p class="small text-dark"><i class="far fa-calendar-alt"></i>  {{date_format($post->created_at,"d-m-Y")}} </p>
                    </div>
                </div>
            </div>
        </a>
        <hr class="m-0">
        @endforeach
    </div>
</div>