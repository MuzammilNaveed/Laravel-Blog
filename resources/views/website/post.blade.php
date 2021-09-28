
    @include('website/layout/navbar')

    <input type="hidden" id="post_id" value="{{$post->id}}">

    <div class="container">
        <div class="row">
            <div class="col-md-8 p-4">
                <section class="bg-white p-3 card_shadow" id="__post_content">

                    <div class="__post_head_with_img __overlay" style="position:relative; z-index:1">
                        <img src="{{asset('images')}}/{{$post->image}}" style="width:100%;height:350px" class="img-fluid" alt="">
                        <div class="header_content">
                            <span class="badge bg-dark text-white pt-1 pr-3 pl-3 pb-1">{{$post_category->name}}</span>
                            <h1 class="bg-dark text-white p-2 mt-2">{{$post->title}}</h1>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <p class="mt-3" style="font-size:0.675rem;">
                            @if($post_author != null && $post_author != "" && $post_author->profile_pic != null && $post_author->profile_pic != "")
                                <img src="{{asset('users')}}/{{$post_author->profile_pic}}" class="img-fluid rounded-circle mr-1" alt="" style="width:25px;height:25px">
                            @endif

                            BY

                            @if($post_author != null && $post_author != "" && $post_author->name != null && $post_author->name != "")
                                <a href="{{url('author')}}/{{$post_author->id}}">{{$post_author->name}}</a>
                            @endif
                            -
                            <span class="text-muted m-0 p-0"><i class="far fa-calendar-alt"></i> {{$post->created_at}}</span>
                        </p>
                        <p class="mt-3" style="font-size:0.675rem;">
                            <!-- <span class=" text-muted m-0 p-0"><i class="fas fa-comment"></i> {{$comments}}</span> -->
                        </p>
                    </div>

                    <div class="__post_all_content" style="margin-top:15px; font-family: 'Poppins', sans-serif !important;">
                        <?php echo $post->description; ?>
                    </div>

                </section>

                <!-- sharing icons -->
                <h3 class="lead mt-5">Sharing is Caring <i class="fas fa-heart text-danger small"></i></h3>
                <button style="background:#3b5998;" class="btn btn-border text-white btn-sm"><i class="fab fa-facebook-f text-white"></i> facebook</button>

                <button style="background:#0077b5;" class="btn btn-light text-white btn-sm"><i class="fab fa-linkedin-in text-white"></i> linkedin</button>

                <button style="background:#1da1f2;" class="btn btn-light text-white btn-sm"><i class="fab fa-twitter text-white"></i> twitter</button>


                <!-- about author -->
                <div class="row mt-5 p-3 bg-white card_shadow author_row">
                    @if($post_author != null && $post_author != "")
                    <div class="col-md-2">
                        @if($post_author->profile_pic != null && $post_author->profile_pic != "")
                        <img style="width:100px;height:90px;border-radius:100px;" 
                            src="{{asset('users')}}/{{$post_author->profile_pic}}" class="img-fluid mx-auto mt-1 d-block" alt="">
                        @endif
                    </div>
                    <div class="col-md-10">
                        <h5>{{$post_author->name}}</h5>
                        <p class="small text-muted">
                            {{$post_author->about}}
                        </p>
                    </div>
                    @else
                    <div class="col-md-10">
                        <h2>About the Author</h2>
                        <p class="small text-muted">
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates, omnis error. Quibusdam
                            amet ea aliquid porro accusamus labore illum ratione, sed et, vitae quidem architecto id
                            debitis ullam fugit ipsam iste, eaque aliquam doloribus! Omnis doloribus laboriosam
                        </p>
                    </div>
                    @endif                    
                </div>
                
                <!-- comment system -->
                <h1 class="small mt-5"> <strong id="total_comments"> {{$total_comments}} </strong> Comments</h1>
                <div class="user_comments">
                <!-- <div class="user_comments" id="__user_comments"> -->
                

                    @foreach($comments as $comment)
                    <div class="row p-2 mt-2 bg-white card_shadow">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <h5><strong style="font-size:1rem">{{$comment->name}}</strong> <span class="small" style="font-size:0.7rem;"> says</span></h5>
                                <p style="font-size:0.7rem;" class="small text-muted m-0 mt-2 p-0"> {{$comment->created_at}} </p>
                            </div>
                        </div>

                        <div class="col-12">
                            <p class="small m-0">
                                {{$comment->comment}}
                            </p>
                            <a href="javascript:void(0)" onclick="commentReply(this,{{$comment->id}})" class="text-primary small mt-2">REPLY</a>
                        </div>
                    </div>

                        @if($comment->comment_replies != null && $comment->comment_replies != "" && $comment->comment_replies != [])
 
                            @foreach($comment->comment_replies as $reply)
                            <div class="row p-2 ml-3 mt-2 bg-white card_shadow">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between">
                                        <h5><strong style="font-size:1rem">{{$reply->name}}</strong> <span class="small" style="font-size:0.7rem;"> says</span></h5>
                                        <p style="font-size:0.7rem;" class="small text-muted m-0 mt-2 p-0"> {{$reply->created_at}} </p>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <p class="small m-0">
                                        {{$reply->comment}}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                            
                        @endif
                    @endforeach

                </div>
                <!-- comment ends -->



                <!-- add comment form -->
                <h2 class="lead font-weight-bold mt-4">Leave a Comment</h2>
                <p class="small text-muted">Your email address will not be published</p>

                <div class="success_msg bg_cyan p-2 text-white border-white small" style="display:none">
                    Success! Comment Posted After Admin approval... thanks.
                </div>
                <div class="row mt-4">

                    <form id="post_comment" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="msg" class="small">Comment</label>
                                    <textarea cols="150" rows="4" name="comment" id="comment" class="form-control"></textarea>
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
                <div class="row mt-4 replyComment m-0 p-3 bg-white" style="display:none">
                   
                    <form id="post_comment_reply">
                    <h4 class="lead"> Leave a Reply  </h2>
                    <a onclick="$('.replyComment').hide();" href="javascript:void(0)" class="text-danger font-weight-bold" style="font-size:0.8rem">CANCEL REPLY</a>
                    <p class="small text-muted">Your email address will not be published</p>

                    <div class="reply_success_msg bg_cyan p-2 text-white border-white small" style="display:none">
                        Success! Comment Reply Posted After Admin approval... thanks.
                    </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="msg" class="small">Comment <span class="text-danger">*</span> </label>
                                    <textarea style id="replycomment" cols="30" rows="4" placeholder="Your Message" class="form-control"></textarea>
                                    <span class="text-danger small" id="msg_error"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="name" class="small">Name <span class="text-danger">*</span></label>
                                <input type="text" id="replyname" class="form-control" placeholder="Your Name">
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="small">Email <span class="text-danger">*</span></label>
                                <input type="text" id="replyemail" class="form-control" placeholder="Your Email">
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

                @include('website/layout/rightside')

            </div>

        </div>

    </div>

    @include('website/layout/footer')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>    
    <script type="text/javascript" src="{{asset('website/js/menu.js')}}"></script>
    <script type="text/javascript" src="{{asset('website/js/post.js')}}"></script>
    
    <script>
        $("#p_search_icon").click(function() {
            $(".p_search_div").slideToggle();
        });
        var post_comments = '{{url("post_comment")}}';
        var comment_replies = '{{url("comment_reply")}}';
    </script>
</body>
</html>