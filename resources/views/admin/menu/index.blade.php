@extends('admin.layout.master')
@section('page_title','Manage Menus')
@section('apperance','open')
@section('menu','active')
@section('content')

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
							<h3 class="content-header-title fw-bolder float-start mb-0"> Menu (<span id="sectionTotal">0</span>) </h3>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a>
									</li>
									<li class="breadcrumb-item"> Menu </li>
								</ol>
							</div>
						</div>
						<button class="btn btn-primary" onclick="menu.openModal()"> <i data-feather='plus'></i> Add Menu </button>
					</div>
				</div>
			</div>
		</div>
		
	</div>

	<div class="card mt-2">
		<div class="card-body">

			<div class="table-responsive">
				<table class="table table-hover" id="showRecord">
					<thead>
						<tr role="row">
							<th>Sr #</th>
							<th>Name</th>
							<th>Status</th>
							<th>Created At</th>
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


</div>

<!-- add update modal  -->
<div class="modal fade text-start" id="showModal" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="modal_title"> </h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="saveForm" method="POST" enctype="multipart/form-data" action="{{route('menu.store')}}">
					<input type="hidden" name="id" id="id">

					<div class="col-sm-12">
						<div class="form-group form-group-default">
							<label class="fw-bold">Name <span class="text-danger">*</span> </label>
							<input name="name" id="name" type="text" required="required" class="form-control" placeholder="Name of Menu">
						</div>
					</div>

					<div class="col-md-12 mt-1">
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="status" value="1" name="status">
							<label class="form-check-label" for="status">Active</label>
						</div>
					</div>

					<div class="modal-footer border-0 mt-2">

						<button aria-label="" type="button" class="btn btn-danger" data-bs-dismiss="modal"> Cancel</button>

						<button class="btn btn-primary waves-effect loadingBtn" style="display:none"  type="button" disabled="">
							<span class="spinner-border spinner-border-sm " role="status" aria-hidden="true"></span>
							<span class="ms-25 align-middle">Saving...</span>
						</button>

						<button id="save_btn" type="submit" class="btn btn-primary saveBtn"> Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- delete Modal -->
<div class="modal fade text-start" id="deleteModal" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="modal_title"> Confirmation </h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="id" name="delid">
				<p>Are you sure you want to delete?</p>
			</div>
			<div class="modal-footer bg-light">
				<button data-bs-dismiss="modal" type="button" class="btn btn-secondary btn-cons btn-animated from-top"> Cancel </button>

				<button type="button" id="deleteBtn" class="btn btn-danger waves-effect delBtn">  Delete </button>

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
<script>
	let deleteMenu = "{{url('menu')}}";
	let getMenus = "{{route('getMenus')}}";
</script>
<script src="{{asset('admin/js/menu.js')}}"></script>
@endsection