@extends('admin.layout.master')
@section('page_title','Manage Posts')
@section('container')

<style>
  .seo>li {
    line-height: 0px;
  }
</style>

<div class="d-md-flex justify-content-between mt-2 ml-0">
  <div class="row">
    <div class="custom-control custom-radio ml-0 ">
      <input type="radio" onclick="filterData('current_month')" class="custom-control-input" id="current_month" name="radio-stacked" checked>
      <label class="custom-control-label" for="current_month">Current Month</label>
    </div>
    <div class="custom-control custom-radio ml-0 ml-md-3">
      <input type="radio" onclick="filterData('previous_month')" class="custom-control-input" id="previous_month" name="radio-stacked">
      <label class="custom-control-label" for="previous_month">Previous Month</label>
    </div>
    <div class="custom-control custom-radio ml-0 ml-md-3">
      <input type="radio" onclick="filterData('all_time')" class="custom-control-input" id="all_time" name="radio-stacked">
      <label class="custom-control-label" for="all_time">All Time</label>
    </div>
    <div class="custom-control custom-radio ml-0 ml-md-3">
      <input type="radio" onclick="filterData('date_range')" class="custom-control-input" id="date_range" name="radio-stacked">
      <label class="custom-control-label" for="date_range">Date Range</label>
    </div>
  </div>

  <div class="d-flex">

    <div class="form-group form-group-default form-group-default-select2 ml-3" style="width:150px">
        <label class="">Category</label>
        <select class="full-width select2-hidden-accessible" id='category_id' name="category" data-placeholder="Select Category" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
            <option value=" ">All</option>
            @foreach($categories as $category) 
              <option value="{{$category->name}}"> {{$category->name}} </option>
            @endforeach
        </select>
    </div>
    <div class="form-group form-group-default form-group-default-select2 ml-3" style="width:150px">
        <label class="">Author</label>
        <select class="full-width select2-hidden-accessible" name="category" data-placeholder="Select Category" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
            <option>All</option>
            @foreach($authors as $author) 
              <option value="{{$author->name}}"> {{$author->name}} </option>
            @endforeach
        </select>
    </div>

    <div class="form-group form-group-default form-group-default-select2 ml-3" style="width:150px">
        <label class="">Section</label>
        <select class="full-width select2-hidden-accessible" id="sections" data-placeholder="Select Section" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
            <option value=" ">All</option>
            <option value="Header">Header</option>
            <option value="Project">Project</option>
            <option value="Tutorials">Tutorials</option>
        </select>
    </div>

  </div>
</div>

<div class="d-md-flex mt-3" id="date_range_filter" style="display: none !important;">
  <div class="form-group">
    <input type="date" id="start" class="form-control">
  </div>
  <div class="form-group ml-0 ml-md-4">
    <input type="date" id="end" class="form-control">
  </div>
  <div class="form-group ml-0 ml-md-4">
    <button onclick="dateWiseData()" class="btn btn-primary card_shadow" style="border-radius:50px;padding:10px 10px"><i class="fas fa-search"></i></button>
  </div>
</div>


<div class="row">
  <strong class="text-primary font-weight-bold">Current Record </strong> &nbsp; from: &nbsp; <span class="text-primary font-weight-bold" id="from_date"></span> &nbsp; to:&nbsp; <span id="to_date" class="text-primary font-weight-bold"></span>
</div>

<div class="row mt-2">
  <div class="container-fluid p-0">
    <div class="card card_shadow">
      <div class="card-header d-flex justify-content-between">
        <div class="card-title font-weight-bolder">All Posts</div>
        <div class="export-options-container">
          <div class="exportOptions">
            <div class="DTTT btn-group">
              <button type="button" class="btn btn-primary btn-sm rounded"><a href="{{route('add_post.index')}}">
                  <i class="fas fa-plus-circle"></i> Add Post</a></button>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover w-100 text-left" id="post_table">
            <thead>
              <tr>
                <th>Sr#</th>
                <th>Image</th>
                <th>Title</th>
                <th>Total Views</th>
                <th>Category</th>
                <th>Section</th>
                <th>Created By</th>
                <th>Comments</th>
                <th>Tags</th>
                <th>SEO</th>
                <th>Publish</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <div class="loader_container" style="display:none">
        <div class="loader"></div>
      </div>
    </div>
  </div>
</div>


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

    <div class="loader_container" id="user_loader">
      <div class="loader"></div>
    </div>

  </div>
</div>

<!-- comment view modal -->
<div class="modal fade stick-up" id="commentViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

        <h5 class="modal-title" id="exampleModalLabel"><span class="text-primary" id="postname"></span> - Comments</h5>
      </div>
      <div class="modal-body mt-2" id="comment_detail">

      </div>
    </div>

    <div class="loader_container" id="cmt_loader">
      <div class="loader"></div>
    </div>

  </div>
</div>

@endsection
@section('scripts')
<script>
  var view_post = "{{url('view_post')}}";
  var user_detail = "{{url('user_detail')}}";
  var comment_details = "{{url('comment_details')}}"
</script>
<script src="{{asset('admin/js/posts.js')}}"></script>
@show