<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/5fcfcbf541.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('website/custom.css').'?ver='.rand()}}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <title>Categories Page</title>
</head>


<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 p-4">
                <section class="" id="__category_content">
                    <span>Browse Category</span>

                    <h1 id="category_name">{{$category->name}}</h1>
                    <span class="small text-muted" id="post_count">{{$post_count}} posts</span>
                    <p id="category_desc">{{$category->description}}</p>

                    <hr>

                    <div class="row">

                        @foreach($posts as $post) 
                            <div class="col-md-4 mt-2">
                                <a href="{{url('post')}}/{{$post->slug}}">
                                    <div class="project_post" style="  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);">
                                        <div class="project_img">
                                            <img src="{{asset('images')}}/{{$post->image}}" style="width:100%; min-height:150px; height:100px" class="img-fluid" alt="">
                                            <span style="position:absolute;bottom:5px;left:5px;" class="badge bg-dark text-white pt-1 pr-3 pl-3 pb-1">Category</span>
                                        </div>
                                        <div class="project_content">
                                            <h2>{{$post->title}}</h2>
                                            <p class="small text-dark"><i class="far fa-calendar-alt"></i> {{$post->created_at}}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                        <!-- <div class="col-md-4">
                            <div class="project_post" style="  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);">
                                <div class="project_img">
                                    <img src="{{asset('images/246563585.jpg')}}" style="width:100%; height:auto" class="img-fluid" alt="">
                                    <span style="position:absolute;bottom:5px;left:5px;" class="badge bg-dark text-white pt-1 pr-3 pl-3 pb-1">Category</span>
                                </div>
                                <div class="project_content">
                                    <h2>Bootstrapping, managing product-led growth </h2>
                                    <p class="small text-dark"><i class="far fa-calendar-alt"></i> 13th Jan, 2010</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="project_post" style="  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);">
                                <div class="project_img">
                                    <img src="{{asset('images/246563585.jpg')}}" style="width:100%; height:auto" class="img-fluid" alt="">
                                    <span style="position:absolute;bottom:5px;left:5px;" class="badge bg-dark text-white pt-1 pr-3 pl-3 pb-1">Category</span>
                                </div>
                                <div class="project_content">
                                    <h2>Bootstrapping, managing product-led growth </h2>
                                    <p class="small text-dark"><i class="far fa-calendar-alt"></i> 13th Jan, 2010</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="project_post" style="  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);">
                                <div class="project_img">
                                    <img src="{{asset('images/246563585.jpg')}}" style="width:100%; height:auto" class="img-fluid" alt="">
                                    <span style="position:absolute;bottom:5px;left:5px;" class="badge bg-dark text-white pt-1 pr-3 pl-3 pb-1">Category</span>
                                </div>
                                <div class="project_content">
                                    <h2>Bootstrapping, managing product-led growth </h2>
                                    <p class="small text-dark"><i class="far fa-calendar-alt"></i> 13th Jan, 2010</p>
                                </div>
                            </div>
                        </div> -->

                    </div>


                </section>
            </div>

            <!-- category & recent post div -->
            <div class="col-md-4 p-4">

                <!-- categories -->
                <div class="right-category">
                    <h5 class="p-0">Category</h5>
                    <div class="category" id="__categories">
                        @foreach($categories as $category) 
                            <a href="{{url('category')}}/{{$category->slug}}" class="badge bg-light __category_badge text-dark mt-2">{{$category->name}}</a>
                        @endforeach
                    </div>
                </div>

                <!-- recent post -->

                <div class="recent mt-5 ">
                    <h2 class="lead">Recent Post</h2>
                    <div class="__recent_post" id="__recent_post">
                        @foreach($recent_posts as $post)
                            <a href="{{url('post')}}/{{$post->slug}}">
                                <div class="row">
                                    <div class="col-4"><img src="{{asset('images')}}/{{$post->image}}" style="width:100%; height:auto;" class="img-fluid" alt=""></div>
                                    <div class="col-8">
                                        <div class="headers_content">
                                            <h1>{{$post->title}}</h1>
                                            <p class="small text-dark"><i class="far fa-calendar-alt"></i> {{$post->created_at}}</p>
                                        </div>
                                    </div>
                                </div> 
                            </a>
                        <hr>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
    $(document).ready(function() {
        post_data();
        get_all_post_and_categories();
    });

    function post_data() {
        var url = window.location.pathname.split('/');
        var slug = url[2];
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: '/get_all_posts',
            type: 'GET',
            dataType: 'json',
            data: {
                slug: slug
            },
            success: function(data) {
                var cat = data.categories[0];
                console.log(data, 'api call');

                $('#category_name').html(cat.category_name);
                $('#category_desc').html(cat.cat_desc);
                $('#post_count').html(data.post_count + " Posts");

                var post = ``;
                for (var i = 0; i < data.posts.length; i++) {

                    post += `
                    <div class="col-md-6 p-2">
                        <a href="/single/` + data.posts[i].slug + `">
                            <div class="__lastest_post __hover m-2">
                                <div class="__post_img mb-2" style="position:relative;">
                                    <img src="{{asset('images/` + data.posts[i].image + `')}}" class="img-fluid" alt="">
                                    <span style="position:absolute;left:8px;bottom:8px;"
                                        class="__cat_bg text-white __radius">` + (data.posts[i].cat_id == cat.id ? cat
                        .category_name : '-') + `</span>
                                </div>
                                <div class="">
                                    <h2 class="mt-2 mb-0">` + data.posts[i].title + `</h2>
                                    <span style="font-size:0.675rem" class="small m-0 p-0 text-muted">
                                    ` + moment(data.posts[i].created_at).format('MMMM DD, YYYY') + `</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    `;
                }
                $('#__category_post_content').html(post);
            },
            error: function(error) {
                console.log(error)
            },
        });
    }

    function get_all_post_and_categories() {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: '/get_all_post_and_categories',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var cat_obj = data.categories;
                var post_obj = data.posts;
                var row = ``;
                var recent_post = ``;
                for (var i = 0; i < cat_obj.length; i++) {
                    row += `
                    <a href="/category/` + cat_obj[i].cat_slug +
                        `" class="badge __category_badge __badge_hover text-dark mt-2">` + cat_obj[i]
                        .category_name + `</a>
                    `;
                }
                for (var i = 0; i < post_obj.length; i++) {
                    recent_post += `
                    <div class="__recent_post mt-4 __hover">
                        <h5><a href="/single/` + post_obj[i].slug + `">` + post_obj[i].title + `</a></h5>
                        <span class="small text-muted">` + moment(post_obj[i].created_at).format('MMMM DD, YYYY') + `</span>
                    </div>
                    <hr>
                    `;
                }
                $('#__categories').html(row);
                $('#__recent_post').html(recent_post);
                console.log(data, 'all api call');
            },
            error: function(error) {
                console.log(error)
            },
        });
    }
    </script>

</body>

</html>