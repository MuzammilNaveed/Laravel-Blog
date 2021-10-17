
@foreach($widgets as $widget)
    @if($widget->type == "sidebar")


        @if($widget->widget_id == "textWidget")
            <div class="recent mt-3 bg-white card_shadow p-3">
                <h5 class="font-weight-bold"> {{$widget->name}} </h5>
                <p class="small"> {{$widget->content}} </p>
            </div>
        @endif

        @if($widget->widget_id == "popularPostWidget")
            <div class="recent mt-3 bg-white card_shadow p-3">
                <h5 class="p-0 w-800"> {{$widget->widget_name}}  </h5>
                <div class="__recent_post mt-3" id="__recent_post">
                @foreach($popular_posts as $post)
                <a href="{{url('post')}}/{{$post->slug}}">
                    <div class="row singlePopularPost p-2">
                        <div class="col-4"><img src="{{asset('images')}}/{{$post->image}}" style="width:100%; height:70px;" class="img-fluid rounded" alt=""></div>
                        <div class="col-8">
                            <div class="headers_content">
                                <h2><?php echo substr($post->title . '...', 0, 40); ?></h2>
                                <p class="small text-dark"><i class="far fa-calendar-alt"></i> {{date_format($post->created_at,"d-m-Y")}} </p>
                            </div>
                        </div>
                    </div>
                </a>
                <hr class="m-0">
                @endforeach
                </div>
            </div>
        @endif

        @if($widget->widget_id == "menuWidget")
            <div class="recent mt-3 bg-white card_shadow p-3">
                <h5 class="font-weight-bold"> {{$widget->name}} </h5>
                @foreach($widget->Custom_menus as $menu)
                    <li><a href="{{ $menu->type == 'category' || $menu->type == 'page' ? $menu->slug : $menu->url}}">{{$menu->name}}</a></li>
                @endforeach
            </div>
        @endif

        @if($widget->widget_id == "tagWidget")
            <div class="recent mt-3 bg-white card_shadow p-3">
                <h5 class="font-weight-bold"> {{$widget->name}} </h5>
                @foreach($widget->tags as $tag)
                <a href="{{url('tag')}}/{{$tag->slug}}" class="badge bg-light __category_badge text-dark mt-2">{{$tag->name}}</a>
                @endforeach
            </div>
        @endif

        @if($widget->widget_id == "categoryWidget")
            <div class="right-category bg-white card_shadow p-3 mt-2">
                <div class="category" id="__categories">
                    <h5 class="p-0 w-800"> {{$widget->name}} </h5>
                    @foreach($widget->categories as $category)
                        <a href="{{url('category')}}/{{$category->slug}}" class="badge bg-light __category_badge text-dark mt-2">{{$category->name}}</a>
                    @endforeach
                </div>
            </div>
        @endif

        @if($widget->widget_id == "newsletterWidget")
            <div class="bg-white card_shadow p-3 mt-2">
                <h5 class="font-weight-bold"> {{$widget->name}} </h5>
                <p class="small">Subscribe to our newsletter and get our newest updates right on your inbox.</p>
                <form class="new_letter_form" action="{{url('save-newsletters')}}" method="POST" data-wid="{{$widget->id}}">
                    <input type="email" class="form-control" id="newsletter_email_{{$widget->id}}" placeholder="Your Email Address">
                    <div class="text-danger small" id="show_message_{{$widget->id}}"></div>
                    <button id="save_btn_{{$widget->id}}" class="btn btn-primary mt-2 btn-block newletter-btn" type="submit" >Subscribe</button>
                    <button id="loader_{{$widget->id}}" class="btn btn-primary mt-2 btn-block newletter-btn" type="button" role="button" style="display:none" disabled > <i class="fas fa-circle-notch fa-spin"></i> </button>
                </form>
            </div>
        @endif

    @endif
@endforeach