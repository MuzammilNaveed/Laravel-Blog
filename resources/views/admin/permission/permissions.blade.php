@extends('admin.layout.master')
@section('page_title','Manage Permissions')
@section('container')

<div class="row mt-2">
  <div class="container-fluid p-0">
      <div class="card card_shadow">
        
        <div class="card-header d-flex justify-content-between">
          <div class="card-title font-weight-bolder">All Permissions <span class="badge bg-primary text-white" id="counts"></span></div>
        </div>

        <div class="card-body">

          <hr class="m-0">

          <div class="row mt-3">

            <div class="col-md-4">
              <div class="form-group form-group-default form-group-default-select2">
                  <label class="">Page</label>
                  <select onchange="Permissionpages()" class="full-width select2-hidden-accessible" id="page" data-placeholder="Select Page" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
                      <option value="">Select</option>
                      <option value="category">Category</option>
                      <option value="tags">Tags</option>
                      <option value="post">Post</option>
                      <option value="role">Role</option>
                  </select>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group form-group-default form-group-default-select2">
                  <label class="">Role</label>
                  <select onchange="showRolePermissions(this.value)" id="role" class="full-width select2-hidden-accessible"  data-placeholder="Select Category" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
                      <option value="">Select</option>
                      @foreach($roles as $role)
                      <option value="{{$role->id}}">{{$role->name}}</option>
                      @endforeach
                  </select>
              </div>
            </div>

            <div class="col-md-4" id="action_block" style="display:none">
              <div class="form-group form-group-default form-group-default-select2" >
                  <label class="">Permission</label>
                  <select id="permissions" class="full-width select2-hidden-accessible" multiple="multiple" data-placeholder="Select Permission" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
                      <option value="">Select</option>
                      <option value="create">Create</option>
                      <option value="update">Update</option>
                      <option value="delete">Delete</option>
                  </select>
              </div>
            </div>
          </div>

          <button onclick="savePermissions()" class="btn btn-success btn-lg rounded text-white"> <i class="fas fa-check-circle"></i> &nbsp; Save</button>



          <div class="loader_container" id="loader" style="display:none">
              <div class="loader"></div>
          </div>

        </div>
      </div>
  </div>
</div>


@endsection
@section('scripts')
<script>
  var save_permissions= "{{url('save_permissions')}}";
  var show_role_permissions = "{{url('show_role_permissions')}}";

</script>
<script src="{{asset('admin/js/permission.js')}}"></script>
@show