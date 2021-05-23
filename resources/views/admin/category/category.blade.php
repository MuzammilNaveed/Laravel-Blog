@extends('admin.layout.master')
@section('page_title','Manage Categories')
@section('container')

<style>
  .select2-selection {
    width: 200px !important;
  }
</style>
<div class="container-fluid mt-3">
  <div class="d-md-flex justify-content-between">
    <div class="radios">
      <div class="row">
        <div class="form-check primary">
          <input type="radio" name="texture" onclick="filterData('current_month')" id="current_month" value="Verbose" checked>
          <label for="current_month">
            Current Month
          </label>
        </div>

        <div class="form-check primary ml-3">
          <input type="radio" onclick="filterData('previous_month')" name="texture" id="previous_month" value="Verbose">
          <label for="previous_month">
            Previous Month
          </label>
        </div>

        <div class="form-check primary ml-3">
          <input type="radio" onclick="filterData('all_time')" name="texture" id="all_time" value="Verbose">
          <label for="all_time">
            All Time
          </label>
        </div>

        <div class="form-check primary ml-3">
          <input type="radio" onclick="filterData('date_range')" name="texture" id="date_range" value="Verbose">
          <label for="date_range">
            Date Range
          </label>
        </div>
      </div>
    </div>
    <div class="dropdowns">
      <div class="form-group form-group-default form-group-default-select2">
        <label class="">Category</label>
        <select class="full-width select2-hidden-accessible" id="category_dropdown" data-placeholder="Select Category" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
        </select>
      </div>
    </div>

  </div>

</div>
<div class="d-md-flex" id="date_range_filter" style="display:none !important">
  <div class="form-group">
    <input type="date" id="from" class="form-control">
  </div>
  <div class="form-group ml-0 ml-md-4">
    <input type="date" id="to" class="form-control">
  </div>
  <div class="form-group ml-0 ml-md-4">
    <button onclick="getDateWiseData()" class="btn btn-primary card_shadow mt-1"><i class="material-icons">search</i></button>
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
          <div class="card-title font-weight-bolder">All Categories</div>
          <div class="export-options-container">
            <div class="exportOptions">
              <div class="DTTT btn-group"> <button data-toggle="modal" data-target="#addRecordModal" class="btn btn-primary"><i class="material-icons">add</i> Add Category</button></div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive sm-m-b-15">
            <table class="table table-hover no-footer w-100" id="showRecord">
              <thead>
                <tr role="row">
                  <th>Sr #</th>
                  <th>Created At</th>
                  <th>Category Name</th>
                  <th>Category Description</th>
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

<!-- Modal -->
<div class="modal fade stick-up" id="addRecordModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> <span class="text-muted small">Add</span> <span class="text-primary">Category</span> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form role="form" id="addRecord" class="mt-3">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group form-group-default">
                <label>Category Name</label>
                <input id="appName" name="name" type="text" class="form-control" placeholder="Name of Category">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group form-group-default">
                <label>Description</label>
                <textarea cols="30" rows="10" name="description" type="text" class="form-control" style="resize:none;height:80px" placeholder="Tell us more about it"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer pr-0">
            <button id="add-app" type="submit" class="btn btn-primary  btn-cons"> Save</button>
            <button aria-label="" type="button" class="btn btn-cons" data-dismiss="modal"> Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> <span class="text-muted small">Update</span> <span class="text-primary" id="catname"></span> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" id="updateRecord" class="mt-3">
          <input type="hidden" id="id">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group form-group-default">
                <label>Category Name</label>
                <input id="name" name="name" type="text" class="form-control" placeholder="Name of Category">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group form-group-default">
                <label>Description</label>
                <textarea cols="30" rows="10" id="description" name="description" type="text" class="form-control" style="resize:none;height:80px" placeholder="Tell us more about it"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer pr-0">
            <button id="add-app" type="submit" class="btn btn-primary  btn-cons"> Save</button>
            <button aria-label="" type="button" class="btn btn-cons" data-dismiss="modal"> Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection
@section('scripts')
<script src="{{asset('admin/js/category.js')}}"></script>

<script>
  var categories = "{{url('categories')}}";
</script>
@show