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
            <section class="" id="__category_content">
                <span class="small">Browse Category</span>

                <h2 class="font-weight-bolder">{{$category->name != null ? $category->name : ''}}</h2>
                <span class="small text-muted" id="post_count">{{$post_count}} posts</span>
                <p id="category_desc" class="text-muted small">{{$category->description != null && $category->description != "" ? $category->description : ''}}</p>

                <hr>

                <div class="row">

                    @foreach($posts as $post)
                    <div class="col-md-4 p-1 mt-2">
                        <a href="{{url('post')}}/{{$post->slug}}">
                            <div class="card card_shadow border-0">
                                <div class="project_post">
                                    <div class="project_img">
                                        <img src="{{asset('images')}}/{{$post->image}}" style="width:100%; min-height:150px; height:100px" class="img-fluid" alt="">
                                    </div>
                                    <div class="project_content">
                                        <ul class="p-0 m-0">
                                            <li>
                                                <span class="pst_category small text-dark">{{$category->name != null ? $category->name : ''}}</span>
                                            </li>
                                        </ul>
                                        <h5 class="pt-2">{{ $post->title }}</h5>
                                        <p class="small text-muted"><i class="far fa-calendar-alt"></i> {{date_format($post->created_at,"d-m-Y")}} </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </section>
            
            <div class="small mt-4">{{$posts->links()}}</div>
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
<script type="text/javascript" src="{{asset('website/js/category.js')}}"></script>
<script type="text/javascript" src="{{asset('website/js/menu.js')}}"></script>

</body>

</html>