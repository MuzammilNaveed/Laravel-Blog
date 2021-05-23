@extends('admin.layout.master')
@section('page_title','Manage Categories')
@section('container')

    <div class="d-md-flex mt-2">
    <div class="custom-control custom-radio ml-0 ml-md-3">
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

<div class="row ml-3">
  <strong class="text-primary font-weight-bold">Current Record </strong> &nbsp; from: &nbsp; <span class="text-primary font-weight-bold" id="from_date"></span> &nbsp; to:&nbsp; <span id="to_date" class="text-primary font-weight-bold"></span>
</div>

<div class="row mt-2">
  <div class="container-fluid">
    <div class="bg-white">
      <div class="card card-transparent">
        <div class="card-header d-flex justify-content-between">
          <div class="card-title font-weight-bolder">All Posts</div>
          <div class="export-options-container">
            <div class="exportOptions">
              <div class="DTTT btn-group">
              <button type="button" class="btn btn-primary"><i class="material-icons">add</i> <a href="{{route('add_post.index')}}" class="text-white"> Add Post</a></button>
              
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-md-responsive">
            <table class="table table-hover no-footer no-wrap w-100 text-center" id="post_table">
            <thead>
                    <tr>
                        <th>Sr#</th>
                        <th>Image</th>
                        <th>Date</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Section</th>
                        <th>Tags</th>
                        <th>Active</th>
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
</div>




@endsection
@section('scripts')
    <script src="{{asset('admin/js/posts.js')}}"></script>
@show

