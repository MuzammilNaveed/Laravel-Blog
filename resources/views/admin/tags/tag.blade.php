@extends('admin.layout.master')
@section('page_title','Manage Tags')
@section('container')

<style>
  .select2-selection {
    width: 200px !important;
  }
</style>

<div class="row mt-2">

  <div class="container-fluid p-0">
      <div class="card card_shadow">
        <div class="card-header d-flex justify-content-between">
          <div class="card-title font-weight-bolder">All Tags <span id="counts" class="badge bg-primary text-white"></span> </div>
          <div class="export-options-container">
            <div class="exportOptions">
              <div class="DTTT btn-group"> <button data-toggle="modal" data-target="#addModal" class="btn btn-primary"><i class="material-icons">add</i> Add Tag</button></div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive sm-m-b-15">
            <table class="table table-hover no-footer w-100 text-center" id="tag_table">
              <thead>
                <tr role="row">
                  <th>Sr#</th>
                  <th>Date</th>
                  <th>Name</th>
                  <th>Slug</th>
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


<div class="modal fade stick-up" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> <span class="text-muted small">Add</span> <span class="text-primary">Tag</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addRecord">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group form-group-default">
                <label> Name</label>
                <input name="name" type="text" class="form-control" placeholder="Name of Tag">
              </div>
            </div>
          </div>
          <div class="modal-footer pr-0">
            <button id="add-app" type="submit" class="btn btn-primary  btn-cons"> Save</button>
            <button aria-label="" type="button" class="btn btn-cons" data-dismiss="modal"> Cancel</button>
          </div>
        </form>
        <div class="loader_container" id="add_loader" style="display:none">
          <div class="loader"></div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade stick-up" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="text-muted small">Update</span> <span id="tagname"></span> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="updateRecord">
          <input type="hidden" id="id">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group form-group-default">
                <label>Name</label>
                <input id="name" name="name" type="text" class="form-control" placeholder="Name of Tag">
              </div>
            </div>
          </div>
          <div class="modal-footer pr-0">
            <button id="add-app" type="submit" class="btn btn-primary  btn-cons"> Save</button>
            <button aria-label="" type="button" class="btn btn-cons" data-dismiss="modal"> Cancel</button>
          </div>
        </form>
        <div class="loader_container" id="edit_loader" style="display:none">
          <div class="loader"></div>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection
@section('scripts')
<script src="{{asset('admin/js/tags.js')}}"></script>
@show