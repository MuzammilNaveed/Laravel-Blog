@extends('admin.layout.master')
@section('page_title','Manage Roles')
@section('container')

@if($permission != null && $permission != "")
  <p id="update" class="d-none"> {{str_contains($permission->action,'update') ? 1 : 0}} </p>
  <p id="delete" class="d-none"> {{str_contains($permission->action,'delete') ? 1 : 0}} </p>
@endif

<div class="row mt-2 add_margin">
  <div class="container-fluid p-0">
      <div class="card card_shadow">
        <div class="card-header d-flex justify-content-between">
          <div class="card-title font-weight-bolder">All Roles <span class="badge bg-primary text-white" id="counts"></span></div>
          <div class="export-options-container">
            <div class="exportOptions">
              <div class="DTTT btn-group"> 
              @if($permission != null && $permission != "")
                @if( str_contains($permission->action,'create') )  
                <button data-toggle="modal" data-target="#addModal" class="btn btn-primary"><i class="material-icons">add</i> Add Role</button>
                @endif
              @endif
            </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive sm-m-b-15">
            <table class="table table-hover" id="roles_table">
              <thead>
                <tr>
                  <th>Sr#</th>
                  <th>Date</th>
                  <th>Name</th>
                  <th>Users</th>
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
      <div class="loader_container" id="add_loader">
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
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
      </div>
      </form>

      <div class="loader_container" id="edit_loader">
        <div class="loader"></div>
      </div>

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

        <h5 class="modal-title" id="exampleModalLabel"> User <span class="text-primary" id="username"></span> Detail</h5>
      </div>
      <div class="modal-body mt-2" id="user_detail">

      </div>
    </div>

    <div class="loader_container" id="user_loader">
      <div class="loader"></div>
    </div>

  </div>
</div>


@endsection
@section('scripts')
<script>  
  var user_detail = "{{url('user_detail')}}";
</script>
<script src="{{asset('admin/js/roles.js')}}"></script>
@show