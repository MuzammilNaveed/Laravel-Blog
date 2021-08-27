@extends('admin.layout.master')
@section('page_title','Dashboard')
@section('dashboard','active')
@section('container')

<style>
    .table tbody tr td {
        padding:8px;
    }
</style>
<?php  $menu = sizeof(Session('menus')); ?>

@if($menu > 0)

    @if( $name == "admin" || $name == "administrator" || $name == "super admin" || $name == "super administrator") 
        <div class="">

            <div class="row mt-3 add_margin">

                <div class="col-md-3">
                    <a href="{{route('post.index')}}">
                        <div class="card  bg-primary dashboard_cards">
                            <div class="card-header ">
                                <div class="card-title">
                                    <span class="font-montserrat fs-11 all-caps">Total Posts</span>
                                </div>
                            </div>
                            <div class="p-l-20 pb-2">
                                <h3 class="no-margin p-b-5">{{$post_count}}</h3>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3">
                <a href="{{route('category.index')}}">
                    <div class="card  bg-warning dashboard_cards">
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
                    <div class="card  bg-success dashboard_cards">
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
                    <div class="card dashboard_cards text-white" style="background:#323237">
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

            <div class="row">

                <div class="col-md-3">
                    <a href="{{route('comments.index')}}">
                    <div class="card bg-menu-light dashboard_cards">
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
                    <div class="card  bg-info dashboard_cards">
                        <div class="card-header ">
                            <div class="card-title">
                                <span class="font-montserrat fs-11 all-caps">Total Replies</span>
                            </div>
                        </div>
                        <div class="p-l-20 pb-2">
                            <h3 class="no-margin p-b-5">{{$reply_count}}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card  bg-complete dashboard_cards">
                        <div class="card-header ">
                            <div class="card-title">
                                <span class="font-montserrat fs-11 all-caps">Total Active Posts</span>
                            </div>
                        </div>
                        <div class="p-l-20 pb-2">
                            <h3 class="no-margin p-b-5">{{$active_post}}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card  bg-light dashboard_cards">
                        <div class="card-header ">
                            <div class="card-title">
                                <span class="font-montserrat fs-11 all-caps">Total In-Active Posts</span>
                            </div>
                        </div>
                        <div class="p-l-20 pb-2">
                            <h3 class="no-margin p-b-5">{{$inactive_post}}</h3>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endif
@else
    <h1 class="lead font-weight-bolder text-center text-danger">You dont have any feature access kindly contact your admin</h1>
@endif



<!-- grapgs -->
<!-- <div class="row mt-3">

    <div class="col-md-5">
        <div class="card p-3">

            <canvas id="myChart"></canvas>

        </div>

    </div>

    <div class="col-md-7">

        <div class="card p-4">

            <canvas id="visitorChart"></canvas>

        </div>

    </div>

</div>


<div class="row mt-3">

    <div class="col-md-5">
        <div class="card p-3">

            <canvas id="myplatformChart"></canvas>

        </div>

    </div>

    <div class="col-md-7">

        <div class="card p-4">

            <canvas id="countryChart"></canvas>

        </div>

    </div>

</div> -->

<!-- user view modal -->
<div class="modal fade stick-up" id="userViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

        <h5 class="modal-title" id="exampleModalLabel"> <span class="text-primary" id="username"></span> Detail</h5>
      </div>
      <div class="modal-body mt-2" id="user_detail">

      </div>
    </div>

    <div class="loader_container" id="userprofile_loader">
      <div class="loader"></div>
    </div>

  </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
    var categories = "{{url('categories')}}";
    var user_detail = "{{url('user_detail')}}";
    var view_post = "{{url('view_post')}}";
    var get_all_users = "{{url('get_all_users')}}";
</script>

<!-- @if( $name == "admin" || $name == "administrator" || $name == "super admin" || $name == "super administrator")  -->
    <!-- <script src="{{asset('admin/js/dashboard.js')}}"></script> -->
<!-- @endif -->


@show