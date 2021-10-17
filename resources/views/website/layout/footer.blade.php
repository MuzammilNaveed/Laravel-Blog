
<footer class="mt-5 shadow-sm" style="background-color: #eeeeee;">
    <div class="container">
        <div class="row p-3 pt-5 text-dark footer_row">

            @foreach($widgets as $widget) 
                @if($widget->type == "footer")

                    <div class="col-md-3">
                        
                        @if($widget->widget_id == "textWidget")
                            <h5 class="font-weight-bold"> {{$widget->name}} </h5>
                            <hr>
                            <p class="small"> {{$widget->content}} </p>
                        @endif

                        @if($widget->widget_id == "popularPostWidget")
                            <h5 class="font-weight-bold"> {{$widget->widget_name}} </h5>
                            <hr>
                            @foreach($widget->popularPosts as $post)
                                <a href="{{url('post')}}/{{$post->slug}}">
                                    <div class="row singlePopularPost p-2">
                                        <div class="col-4 pr-1 pl-0"><img src="{{asset('images')}}/{{$post->image}}" style="width:100%; height:70px;" class="img-fluid rounded" alt=""></div>
                                        <div class="col-8 pl-1">
                                            <div class="headers_content">
                                                <h2><?php echo substr($post->title . '...', 0, 40); ?></h2>
                                                <p class="small text-dark"><i class="far fa-calendar-alt"></i>  {{date_format($post->created_at,"d-m-Y")}} </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @endif

                        @if($widget->widget_id == "menuWidget")
                            <h5 class="font-weight-bold"> {{$widget->name}} </h5>
                            <hr>
                            @foreach($widget->Custom_menus as $menu)
                                <li>
                                    <a href="{{ $menu->type == 'category' || $menu->type == 'page' ? $menu->slug : $menu->url}}">{{$menu->name}}</a>
                                </li>
                            @endforeach
                        @endif

                        @if($widget->widget_id == "tagWidget")
                            <h5 class="font-weight-bold"> {{$widget->name}} </h5>
                            <hr>
                            @foreach($widget->tags as $tag)
                                <a href="{{url('tag')}}/{{$tag->slug}}" class="badge bg-light __category_badge text-dark mt-2">{{$tag->name}}</a>
                            @endforeach
                        @endif

                        @if($widget->widget_id == "categoryWidget")
                            <h5 class="font-weight-bold"> {{$widget->name}} </h5>
                            <hr>
                            @foreach($widget->categories as $category)
                                <a href="{{url('category')}}/{{$category->slug}}" class="badge bg-light __category_badge text-dark mt-2">{{$category->name}}</a>
                            @endforeach
                        @endif

                        @if($widget->widget_id == "newsletterWidget")
                            <h5 class="font-weight-bold"> {{$widget->name}} </h5>
                            <hr>
                            <p class="small">Subscribe to our newsletter and get our newest updates right on your inbox.</p>
                            <form class="new_letter_form" action="{{url('save-newsletters')}}" method="POST" data-wid="{{$widget->id}}">
                                <input type="email" class="form-control" id="newsletter_email_{{$widget->id}}" placeholder="Your Email Address">
                                <div class="text-danger small" id="show_message_{{$widget->id}}"></div>
                                <button id="save_btn_{{$widget->id}}" class="btn btn-primary mt-2 btn-block newletter-btn" type="submit" >Subscribe</button>
                                <button id="loader_{{$widget->id}}" class="btn btn-primary mt-2 btn-block newletter-btn" type="button" role="button" style="display:none" disabled > <i class="fas fa-circle-notch fa-spin"></i> </button>
                            </form>
                        @endif

                    </div>

                @endif
            @endforeach
        </div>
    </div>
</footer>

