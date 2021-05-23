@extends('admin.layout.master')
@section('page_title','Manage Categories')
@section('container')


  <style>
    td.details-control {
        background: url('../../website/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('../../website/details_close.png') no-repeat center center;
    }
  </style>

  <!-- <div class="d-md-flex">
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
        <input type="date" id="from" class="form-control">
    </div>
    <div class="form-group ml-0 ml-md-4">
        <input type="date" id="to" class="form-control">
    </div>
    <div class="form-group ml-0 ml-md-4">
        <button onclick="getDateWiseData()" class="btn btn-primary card_shadow" style="border-radius:50px;padding:10px 10px"><i class="fas fa-search"></i></button>
    </div>
  </div>

  <div class="row ml-3">

    <strong class="text-primary font-weight-bold">Current Record </strong> &nbsp; from: &nbsp; <span class="text-primary font-weight-bold" id="from_date"></span> &nbsp; to:&nbsp; <span id="to_date" class="text-primary font-weight-bold"></span>

  </div> -->


    <div class="card card_shadow mt-4 border-0 rounded-0">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h4 style="font-size:1rem" class="text-dark font-weight-bold mt-3">Comments <span class="badge bg-primary text-white" id="counts"></span> </h4>
            </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover w-100 text-dark text-center" id="comment_table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Sr#</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Comment</th>
                        <th>Post Title</th>
                        <th>Total Replies</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
            </div>
          <div class="loader_container">
            <div class="loader"></div>
          </div>
        
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{asset('admin/js/comment.js')}}"></script>
    <script>
        let get_comments = "{{url('getComments')}}";
        let get_comment_replies = "{{url('get_replie_by_id')}}";
    </script>
@show

