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
    <title>Post Page</title>
</head>

<body>

    <input type="hidden" id="post_id" value="{{$post->id}}">

    <nav class="navbar navbar-expand-lg navbar-light bg-white" style="border-bottom: 3px solid #eceff1;">
  <div class="container">
  <a class="navbar-brand animate__animated animate__bounce" href="{{url('/')}}">Blog</a>
  <span class="animate__animated animate__bounce">|</span>
  <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown ml-3">
        <a class="nav-link dropdown-toggle animate__animated animate__bounce" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Tutorial
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle animate__animated animate__bounce" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Categories
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
    </ul>
  

  <div class="" id="navbarSupportedContent">
    <div class="form-inline my-2 my-lg-0">
        <i class="fas fa-sun text-warning" id="dark-mode-btn"></i>
        <i class="fas fa-search animate__animated animate__bounce ml-2" id="search_icon"></i>
        </div>
    </div>
  </div>
</nav>

    <div class="search_div w-100" style="height:240px; display:none; background:#fff; box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);position:absolute;z-index:10" >

        <div class="container pt-3">
            <div class="input-group mb-3">
                <input type="text" autocomplete="off" placeholder="Search here" class="form-control" id="search" >
            </div>

            <hr>

            <div class="searches">
                <span class="badge badge-pill bg-primary">123</span>

            </div>

        </div>

    </div>



    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 p-4">
                <section class="" id="__post_content">

                    <div class="__post_head_with_img __overlay" style="position:relative; z-index:1">
                        <img src="{{asset('images')}}/{{$post->image}}" style="width:100%" class="img-fluid" alt="">
                        <div class="header_content">
                            <span class="badge bg-dark text-white pt-1 pr-3 pl-3 pb-1">Category</span>
                            <h1 class="bg-dark text-white p-2 mt-2">{{$post->title}}</h1>
                        </div>
                    </div>

                    <div style="margin-top:50px;">
                        <p class="mt-3" style="font-size:0.675rem;">
                            <img src="{{asset('images/246563585.jpg')}}" class="img-fluid rounded-circle mr-1"
                                alt="" style="width:25px;height:25px">
                            BY <span>MUZAMMIL</span> -
                            <span class="small text-muted m-0 p-0"><i class="far fa-calendar-alt"></i> {{$post->created_at}}</span>    
                        </p>
                    </div>
                    
                    <div class="__post_all_content" style="margin-top:30px">
                        <?php echo $post->description; ?>
                    </div>

                </section>

                <!-- sharing icons -->
                <h3 class="lead mt-5">Sharing is Caring <i class="fas fa-heart text-danger small"></i></h3>
                        <button type="button" class="btn btn-dark" style="border-radius:50px; padding:8px 12px"><i
                                class="fas fa-print text-white"></i></button>

                        <button style="background:#3b5998;border-radius:50px; padding:8px 14px" class="btn btn-border"><i
                                class="fab fa-facebook-f text-white"></i></button>

                        <button style="background:#0077b5;border-radius:50px; padding:8px 12px" class="btn btn-light"><i
                                class="fab fa-linkedin-in text-white"></i></button>

                        <button style="background:#1da1f2;border-radius:50px; padding:8px 12px" class="btn btn-light"><i
                                class="fab fa-twitter text-white"></i></button>
                




                <!-- about author -->
                <div class="row mt-5 border p-2">
                    <div class="col-md-2">
                        <img style="width:100px;height:100px;border-radius:50px;"
                        src="{{asset('images/246563585.jpg')}}" class="img-fluid mx-auto d-block shadow-sm" alt="">
                    </div>
                    <div class="col-md-10">
                        <h2 class="lead">About the Author</h2>
                        <p class="small text-muted">
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates, omnis error. Quibusdam
                            amet ea aliquid porro accusamus labore illum ratione, sed et, vitae quidem architecto id
                            debitis ullam fugit ipsam iste, eaque aliquam doloribus! Omnis doloribus laboriosam
                        </p>
                    </div>
                </div>






                <!-- comment system -->
                <h1 class="lead mt-5"><span id="total_comments"></span> Comments</h1>
                <div class="user_comments" id="__user_comments"></div>
                <!-- comment ends -->

                <!-- add comment form -->
                <h2 class="lead font-weight-bold">Leave a Comment</h2> 
                <p class="small text-muted">Your email address will not be published</p>
                <div class="row mt-4">
                    
                    <form id="post_comment" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="msg" class="small">Comment</label>
                                    <textarea  cols="150" rows="5" name="comment" id="comment" class="form-control"></textarea>
                                    <span class="text-danger small" id="msg_error"></span>
                                </div>
                            </div>
                        
                            <div class="col-md-6">
                                <label for="name" class="small">Name</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="small">Email</label>
                                <input type="text" name="email" id="email" class="form-control">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark mt-3 btn-sm">
                            <i class="far fa-comment-dots"></i> Post Comment</button>
                    </form>
                </div>
                <!-- add comment form end -->


                <!-- add reply comment form -->
                <div class="row mt-4 replyComment" style="display:none">
                    <h2 class="lead">Leave a Reply </h2> 
                    <a onclick="$('.replyComment').hide();" href="javascript:void(0)"
                            class="text-primary" style="font-size:0.8rem">CANCEL REPLY</a>
                    <p>Your email address will not be published</p>
                    <form id="post_comment_reply">

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="msg" class="small">Comment</label>
                                    <textarea style id="replycomment" cols="30" rows="6" class="form-control"></textarea>
                                    <span class="text-danger small" id="msg_error"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="name" class="small">Name</label>
                                <input type="text" id="replyname" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="small">Email</label>
                                <input type="text" id="replyemail" class="form-control">
                            </div>

                        </div>

                        <button type="submit" class="btn btn-dark mt-3 btn-sm">
                            <i class="far fa-comment-dots"></i> Reply</button>
                    </form>
                </div>
                <!-- reply comment form ends -->



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
                    @foreach($posts as $post)
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
        
        // post comment
        $('#post_comment').submit(function(e) {
            e.preventDefault();
            var name = $('#name').val();
            var email = $('#email').val();
            var comment = $('#comment').val();
            var post_id = $('#post_id').val();

            var formData = {
                name: name,
                email: email,
                comment: comment,
                post_id: post_id
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: '{{url("post_comment")}}',
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(data) {
                    console.log(data, 'api call');
                },
                error: function(error) {
                    console.log(error)
                },
            });

        });

        getAllComments();

    });

    function getAllComments() {
        var post_id = $('#post_id').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: '{{url("get_all_comment")}}',
            type: 'POST',
            dataType: 'json',
            data: {post_id: post_id},
            success: function(data) {
                console.log(data, 'comments');
                var row = ``;
                $("#total_comments").text(data.length);

                for (var i = 0; i < data.length; i++) {

                    row += `
                    <div class="row p-2">
 
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <h5><strong style="font-size:1rem">` + data[i].name + `</strong> <span class="small" style="font-size:0.7rem;"> says</span></h5>
                                <p style="font-size:0.7rem;" class="small text-muted m-0 mt-2 p-0">
                                ` + moment(data[i].created_at).format("LL") + " @ " + moment(data[i].created_at).format(
                            "LT") + `</p>
                            </div>
                        </div>

                        <div class="col-12">
                            <p class="small m-0">
                            ` + data[i].comment + `
                            </p>
                            <a href="javascript:void(0)" onclick="commentReply(this, ` + data[i].id + `)" class="text-primary small mt-2">REPLY</a>
                        </div>

                    </div>
                <hr>
                    `;
                    $('#__user_comments').html(row);
                }
            },
            error: function(error) {
                console.log(error)
            },
        });
    }

    function commentReply(caller, id) {
        $('.replyComment').insertAfter($(caller));
        $('.replyComment').show();

        $('#post_comment_reply').submit(function(e) {
            e.preventDefault();
            var name = $('#replyname').val();
            var email = $('#replyemail').val();
            var comment = $('#replycomment').val();
            var post_id = $('#post_id').val();

            var formData = {
                name: name,
                email: email,
                comment: comment,
                post_id: post_id,
                comment_id: id
            }
            console.log(formData, "form data");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: '{{url("comment_reply")}}',
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(data) {
                    console.log(data, 'api call');
                },
                error: function(error) {
                    console.log(error)
                },
            });

        });

    }

    </script>

</body>

</html>