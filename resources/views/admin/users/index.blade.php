@extends('admin.layout.master')
@section('page_title','Manage Users')
@section('users','open')
@section('user','active')
@section('content')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"/>
@endsection

<div class="">
  <div class="content-overlay"></div>
  <div class="header-navbar-shadow"></div>
  <div class="content-wrapper p-0">
    <div class="content-header row">

      <div class="content-header-left">
        <div class="row breadcrumbs-top">
          <div class="d-flex justify-content-between">
            <div>
              <div class="breadcrumb-wrapper">
                <h3 class="content-header-title fw-bolder float-start mb-0">Users (<span id="sectionCount">0</span>) </h3>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a>
                  </li>
                  <li class="breadcrumb-item"> users </li>
                </ol>
              </div>
            </div>
            <button class="btn btn-primary" onclick="users.openModal()"> <i data-feather='plus'></i> Add User</button>
          </div>
        </div>
      </div>
    </div>

  </div>

    <div class="card  p-2 mt-2">

        <div class="table-responsive">
          <table class="table table-hover no-footer w-100" id="showRecord">
            <thead>
              <tr>
                <th>Sr#</th>
                <th>Name</th>
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

        <div class="loading__">
				<div class="spinner-border text-primary" role="status">
					<span class="visually-hidden">Loading...</span>
				</div>
			</div>

    </div>
</div>


<!-- add record modal -->
<div class="modal fade text-start" id="addRecordModal" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="modal_title"> </h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="addRecord" method="POST" enctype="multipart/form-data" action="{{route('user.store')}}">
					<input type="hidden" name="id" id="id">

          <div class="row">
            <div class="col-md-6">
              <label> Name <span class="text-danger">*</span> </label>
							<input name="name" id="name" type="text" required="required" class="form-control" placeholder="Name" required>
            </div>
            <div class="col-md-6">
              <label class="small text-muted">Email Address <span class="text-danger">*</span></label>
              <input name="email" type="email" id="email" class="form-control input-sm" placeholder="User Email Address" required>
            </div>
          </div>

          <div class="row mt-1">
            <div class="col-md-6">
              <label> Role <span class="text-danger">*</span> </label>
							<select name="role" id="role" class="select2" required>
                <option value="1">1</option>
              </select>
            </div>
            <div class="col-md-6">
            <label class="small text-muted"> Password <span class="text-danger">*</span></label>
              <input name="password" id="password" type="password" class="form-control input-sm" required placeholder="Ab@123******">
            </div>
          </div>


					<div class="col-md-12 mt-1">
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="status" value="1" name="status">
							<label class="form-check-label" for="status">Active</label>
						</div>
					</div>

					<div class="modal-footer mt-2">
						<button aria-label="" type="button" class="btn btn-danger" data-bs-dismiss="modal"> Cancel</button>
						<button class="btn btn-primary waves-effect loadingBtn" style="display:none" type="button" disabled="">
							<span class="spinner-border spinner-border-sm " role="status" aria-hidden="true"></span>
							<span class="ms-25 align-middle">Saving...</span>
						</button>
						<button id="save_btn" type="submit" class="btn btn-primary saveBtn"> Save</button>
						<button id="loader" type="button" style="display:none" role="button" class="btn btn-primary  btn-cons" disabled> <i class="fas fa-circle-notch fa-spin"></i> </button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<!-- delete category Modal -->
<div class="modal fade text-start" id="deleteModal" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="modal_title"> Confirmation </h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="did">
				<p>Are you sure you want to delete?</p>
			</div>
			<div class="modal-footer bg-light">
				<button data-bs-dismiss="modal" type="button" class="btn btn-secondary btn-cons btn-animated from-top"> Cancel </button>

				<button type="button" id="deleteRecord" class="btn btn-danger waves-effect delBtn">  Delete </button>

				<button class="btn btn-danger waves-effect delLoader" style="display:none" type="button" disabled="">
					<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
					<span class="ms-25 align-middle">Processing...</span>
				</button>
			</div>
		</div>
	</div>
</div>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<script type="text/javascript" src="{{asset('admin/js/users.js')}}"></script>
<script>
  let deluser = "{{url('user')}}";
  let get_users = "{{route('getUsers')}}";
</script>
@endsection