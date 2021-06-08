@extends('admin.layout.master')
@section('page_title','Manage Categories')
@section('container')

<style>
  .select2-selection {
    width: 200px !important;
  }
</style>

<div class="row mt-2">
  <div class="container p-0">
      <div class="card card_shadow">
        <div class="card-header d-flex justify-content-between">
          <div class="card-title font-weight-bolder">All Categories <span class="badge bg-primary text-white" id="counts"></span> </div>
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