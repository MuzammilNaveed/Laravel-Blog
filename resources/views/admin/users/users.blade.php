@extends('admin.layout.master')
@section('page_title','Manage Users')
@section('container')

<style>
  .form-group-default.form-group-default-select2 .select2-container .select2-selection--single {
    height: 42px !important;
  }

  .modal-backdrop {
    z-index: 12 !important;
  }
</style>

@if($permission != null && $permission != "")
  <p id="update" class="d-none"> {{str_contains($permission->action,'update') ? 1 : 0}} </p>
  <p id="delete" class="d-none"> {{str_contains($permission->action,'delete') ? 1 : 0}} </p>
@endif

<div class="row mt-2 add_margin">

  <div class="container-fluid p-0">

  <div class="d-flex justify-content-between">
    <div class="form-group form-group-default form-group-default-select2" style="width:150px;position: relative; z-index: 10;">
        <label class="">Role</label>
        <select class="full-width select2-hidden-accessible" id='role_select' data-placeholder="Select Role" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
            <option value=" ">All</option>
              @foreach($roles as $role) 
                <option value="{{$role->name}}"> {{$role->name}} </option>
              @endforeach
        </select>
    </div>
  </div>

      <div class="card card_shadow mt-2">
        <div class="card-header d-flex justify-content-between">
          <div class="card-title font-weight-bolder">All Users <span class="badge bg-primary text-white" id="counts"></span> </div>
          <div class="export-options-container">
            <div class="exportOptions">
              <div class="DTTT btn-group">
              @if($permission != null && $permission != "")
                @if( str_contains($permission->action,'create') )
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addRecordModal"><i class="material-icons">add</i> Add User</button>
                @endif
              @endif
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive sm-m-b-15">
            <table class="table table-hover no-footer w-100" id="user_table">
              <thead>
                <tr>
                  <th>Sr#</th>
                  <th>Profile</th>
                  <th>User Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Account Status</th>
                  <th>Author</th>
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


<!-- insert user detail modal -->
<div class="modal fade stick-up" id="addRecordModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width:100%">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create <span class="text-primary">User</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addRecord" enctype="multipart/form-data" autocomplete="off">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group form-group-default">
                <label class="small text-muted">Name <span class="text-danger">*</span> </label>
                <input name="name" type="text" class="form-control input-sm" placeholder="User Name">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group form-group-default">
                <label class="small text-muted">Email Address <span class="text-danger">*</span></label>
                <input name="email" type="email" class="form-control input-sm" placeholder="User Email Address">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="dropdowns">
                <div class="form-group form-group-default form-group-default-select2">
                  <label class="text-muted" style="z-index:9999">Role </label>
                  <select class="full-width select2-hidden-accessible input-sm" name="role_id" data-placeholder="Select Role" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
                    <option value="">Select</option>
                    @foreach($roles as $role)
                    <option value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="user-password-div">
                <span class="block input-icon input-icon-right">
                  <div class="form-group form-group-default mb-0">
                    <label class="text-muted">Password <span class="text-danger">*</span></label>
                    <input type="password" id="password" name="password" placeholder="User Password" class="form-control">
                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon show-password-btn mr-2" style="float: right; margin-top: -25px; cursor:pointer"></span>
                  </div>
                </span>
              </div>
              <a href="javascript:void(0)" class="small" onclick="noPassword()">Generate</a>
            </div>
            <div class="col-md-3">
              <div class="custom-control custom-checkbox mr-sm-2 mt-2">
                <input type="checkbox" class="custom-control-input" id="status">
                <label class="custom-control-label" for="status">Active Account</label>
              </div>
              <span class="text-muted small"> <i>if checked user can login into dashbaord</i> </span>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-md-3">
              <div class="form-group form-group-default">
                <label class="small text-muted">Phone</label>
                <input name="phone" type="text" class="form-control input-sm" placeholder="User Phone Number">
              </div>
            </div>
            <div class="col-md-9">
              <div class="form-group form-group-default">
                <label class="small text-muted">Address</label>
                <input name="address" type="text" class="form-control input-sm" placeholder="User Full Address">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-8">
              <div class="form-group form-group-default">
                <label class="small text-muted">FaceBook</label>
                <input name="facebook" type="text" class="form-control input-sm" placeholder="User Facebook Link">
              </div>
              <div class="form-group form-group-default">
                <label class="small text-muted">Linkedin</label>
                <input name="linkedin" type="text" class="form-control input-sm" placeholder="User Linkedin Link">
              </div>
              <div class="form-group form-group-default">
                <label class="small text-muted">Instagram</label>
                <input name="instagram" type="text" class="form-control input-sm" placeholder="User Linkedin Link">
              </div>
              <div class="form-group form-group-default">
                <label class="small text-muted">Twitter</label>
                <input name="twitter" type="text" class="form-control input-sm" placeholder="User Linkedin Link">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <input type="file" class="form-control dropify" name="profile_pic" data-allowed-file-extensions="png jpg jpeg">
              </div>
            </div>
          </div>

            <div class="col-md-6">
              <div class="custom-control custom-checkbox mt-2">
                <input type="checkbox" class="custom-control-input" id="author">
                <label class="custom-control-label" for="author">is Author</label>
              </div>
              <span class="text-muted small"> <i>if checked author post display on frontend</i> </span>
            </div>

            <br>
            <br>

          <!-- <div class="row mt-2"> -->
          <button id="save" type="submit" class="btn btn-primary btn-lg mr-2">Save</button>
          <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Cancel</button>
          <!-- </div> -->

        </form>
        
        <div class="loader_container" style="display:none" id="add_loader">
          <div class="loader"></div>
        </div>

      </div>
    </div>
  </div>
</div>


<!-- update user detail modal -->
<div class="modal fade slide-right" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width:100%">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update - <span id='username' class="text-primary"></span> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editRecord" enctype="multipart/form-data" autocomplete="off">
          <div class="row">
            <input type="hidden" id="id" name="id">
            <div class="col-md-6">
              <div class="form-group form-group-default">
                <label class="small text-muted">Name <span class="text-danger">*</span> </label>
                <input name="name" id="name" type="text" class="form-control input-sm" placeholder="User Name">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group form-group-default">
                <label class="small text-muted">Email Address <span class="text-danger">*</span></label>
                <input name="email" id="email" type="email" class="form-control input-sm" placeholder="User Email Address">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="dropdowns">
                <div class="form-group form-group-default form-group-default-select2">
                  <label class="text-muted" style="z-index:9999">Role </label>
                  <select class="full-width select2-hidden-accessible input-sm" name="role_id" id="role_id" data-placeholder="Select Role" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
                    <option value="">Select</option>
                    @foreach($roles as $role)
                    <option value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="custom-control custom-checkbox mr-sm-2 mt-2">
                <input type="checkbox" class="custom-control-input" name="editstatus" id="editstatus">
                <label class="custom-control-label" for="editstatus">Active Account</label>
              </div>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-md-3">
              <div class="form-group form-group-default">
                <label class="small text-muted">Phone</label>
                <input name="phone" id="phone" type="text" class="form-control input-sm" placeholder="User Phone Number">
              </div>
            </div>
            <div class="col-md-9">
              <div class="form-group form-group-default">
                <label class="small text-muted">Address</label>
                <input name="address" id="address" type="text" class="form-control input-sm" placeholder="User Full Address">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-8">
              <div class="form-group form-group-default">
                <label class="small text-muted">FaceBook</label>
                <input name="facebook" id="facebook" type="text" class="form-control input-sm" placeholder="User Facebook Link">
              </div>
              <div class="form-group form-group-default">
                <label class="small text-muted">Linkedin</label>
                <input name="linkedin" id="linkedin" type="text" class="form-control input-sm" placeholder="User Linkedin Link">
              </div>
              <div class="form-group form-group-default">
                <label class="small text-muted">Instagram</label>
                <input name="instagram" id="instagram" type="text" class="form-control input-sm" placeholder="User Linkedin Link">
              </div>
              <div class="form-group form-group-default">
                <label class="small text-muted">Twitter</label>
                <input name="twitter" id="twitter" type="text" class="form-control input-sm" placeholder="User Linkedin Link">
              </div>
            </div>

            <div class="col-md-4" id="profile_pic">
            </div>

            <button id="upsave" type="submit" class="btn btn-primary btn-lg mr-2">Save</button>
            <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Cancel</button>

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

<script type="text/javascript" src="{{asset('admin/js/users.js').'?ver='.rand()}}"></script>
<script type="text/javascript">
  let create_users = "{{url('create_users')}}";
  let get_all_users = "{{url('get_all_users')}}";
  let image_path = "{{asset('users')}}";
  let update_user = "{{url('update_users')}}";
  let delete_users = "{{url('delete_users')}}";
</script>
<script language="JavaScript" type="text/javascript">
  $('.dropify').dropify({
    messages: {
      'default': 'User Profile Picture',
      'replace': 'Drag and drop or click to replace',
      'remove': 'Remove',
      'error': 'Ooops, something wrong happended.'
    }
  });

  $(".user-password-div").on('click', '.show-password-btn', function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $(".user-password-div input[name='password']");
    if (input.attr("type") === "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });

  function noPassword() {
    let random_password = Math.random().toString(36).slice(-10);
    $("#password").val(random_password);
  }
</script>
@show