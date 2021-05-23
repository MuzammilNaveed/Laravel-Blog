@extends('admin.layout.master')
@section('page_title','Dashboard')
@section('container')


<div class="">
    <div class="row mt-3">

        <div class="col-md-3">
            <div class="card  bg-primary no-margin">
                <div class="card-header ">
                    <div class="card-title">
                        <span class="font-montserrat fs-11 all-caps">Total Posts</span>
                    </div>
                </div>
                <div class="p-l-20 pb-2">
                    <h3 class="no-margin p-b-5">{{$post_count}}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
        <a href="{{route('category.index')}}">
            <div class="card  bg-warning no-margin">
                <div class="card-header ">
                    <div class="card-title">
                        <span class="font-montserrat fs-11 all-caps">Total Categories</span>
                    </div>
                </div>
                <div class="p-l-20 pb-2">
                    <h3 class="no-margin p-b-5">{{$category_count}}</h3>
                </div>
            </div>
        </a>
        </div>

        <div class="col-md-3">
        <a href="{{route('tag.index')}}">
            <div class="card  bg-success no-margin">
                <div class="card-header ">
                    <div class="card-title">
                        <span class="font-montserrat fs-11 all-caps">Total Tags</span>
                    </div>
                </div>
                <div class="p-l-20 pb-2">
                    <h3 class="no-margin p-b-5">{{$tag_count}}</h3>
                </div>
            </div>
        </a>
        </div>

        <div class="col-md-3">
            <a href="{{route('user.index')}}">
            <div class="card no-margin text-white" style="background:#323237">
                <div class="card-header ">
                    <div class="card-title">
                        <span class="font-montserrat fs-11 all-caps">Total Users</span>
                    </div>
                </div>
                <div class="p-l-20 pb-2">
                    <h3 class="no-margin p-b-5">{{$user_count}}</h3>
                </div>
            </div>
            </a>
        </div>

    </div>

    <div class="row mt-3">

    <div class="col-md-3">
            <a href="{{route('user.index')}}">
            <div class="card bg-menu-light no-margin">
                <div class="card-header ">
                    <div class="card-title">
                        <span class="font-montserrat fs-11 all-caps">Total Comments</span>
                    </div>
                </div>
                <div class="p-l-20 pb-2">
                    <h3 class="no-margin p-b-5">{{$comment_count}}</h3>
                </div>
            </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{route('user.index')}}">
            <div class="card  bg-info no-margin">
                <div class="card-header ">
                    <div class="card-title">
                        <span class="font-montserrat fs-11 all-caps">Total Replies</span>
                    </div>
                </div>
                <div class="p-l-20 pb-2">
                    <h3 class="no-margin p-b-5">{{$reply_count}}</h3>
                </div>
            </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{route('user.index')}}">
            <div class="card  bg-complete no-margin">
                <div class="card-header ">
                    <div class="card-title">
                        <span class="font-montserrat fs-11 all-caps">Total Active Posts</span>
                    </div>
                </div>
                <div class="p-l-20 pb-2">
                    <h3 class="no-margin p-b-5">{{$active_post}}</h3>
                </div>
            </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{route('user.index')}}">
            <div class="card  bg-light no-margin">
                <div class="card-header ">
                    <div class="card-title">
                        <span class="font-montserrat fs-11 all-caps">Total In-Active Posts</span>
                    </div>
                </div>
                <div class="p-l-20 pb-2">
                    <h3 class="no-margin p-b-5">{{$inactive_post}}</h3>
                </div>
            </div>
            </a>
        </div>

    </div>
</div>



@endsection