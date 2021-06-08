@extends('admin.layout.master')
@section('page_title','Manage Roles')
@section('container')


<!-- <div class="card mt-3 card_shadow border-0 rounded-0">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h4 class="small text-dark font-weight-bold mt-3">Roles <span class="badge bg-primary text-white" id="counts"></span> </h4>
                <button class="btn btn-primary btn-sm card_shadow" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus-circle"></i> Add Role</button>
            </div>
        </div>
        <div class="card-body">

            <table class="table table-responsive-md table-hover w-100 text-dark text-center" id="roles_table">
                <thead>
                    <tr>
                        <th>Sr#</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>

            <div class="loader_container">
              <div class="loader"></div>
          </div>
        
        </div>
    </div> -->


<div class="row mt-2">
  <div class="container p-0">
      <div class="card card_shadow">
        <div class="card-header d-flex justify-content-between">
          <div class="card-title font-weight-bolder">All Roles <span class="badge bg-primary text-white" id="counts"></span></div>
          <div class="export-options-container">
            <div class="exportOptions">
              <div class="DTTT btn-group"> <button data-toggle="modal" data-target="#addModal" class="btn btn-primary"><i class="material-icons">add</i> Add Role</button></div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive sm-m-b-15">
            <table class="table table-hover no-footer w-100" id="roles_table">
              <thead>
                <tr>
                  <th>Sr#</th>
                  <th>Date</th>
                  <th>Name</th>
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
        <h5 class="modal-title" id="exampleModalLabel">Add <span class="text-primary">Role</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addRecord">
          <div class="form-group form-group-default">
            <label class="text-muted">Role</label>
            <input id="appName" name="name" type="text" class="form-control input-sm" placeholder="Role Name">
          </div>
      </div>
      <div class="modal-footer">
        <button id="save" type="submit" class="btn btn-primary btn-sm">Save</button>
        <button id="process" style="display:none" type="button" class="btn btn-primary btn-sm" disabled><i class="fas fa-circle-notch fa-spin"></i> Processing</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>


<div class="modal fade stick-up" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">update - <span id="role_name" class="text-primary"></span> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="updateRecord">
          <input type="hidden" id="id">
          <div class="form-group form-group-default">
            <label class="text-muted">Role</label>
            <input id="name" name="name" type="text" class="form-control input-sm" placeholder="Role Name">
          </div>
      </div>
      <div class="modal-footer">
        <button id="save_up" type="submit" class="btn btn-primary btn-sm">Save</button>
        <button id="process_up" style="display:none" type="button" class="btn btn-primary btn-sm" disabled><i class="fas fa-circle-notch fa-spin"></i> Processing</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>



@endsection
@section('scripts')
<script src="{{asset('admin/js/roles.js')}}"></script>
@show