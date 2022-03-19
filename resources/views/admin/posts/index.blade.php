@extends('admin.layout.master')
@section('page_title','Manage Posts')
@section('brand_menu','active')
@section('blog','open active')
@section('posts','active')
@section('content')

<style>
    td.details-control {
        background: url('../../table/details_open.png') no-repeat center center !important;
        cursor: pointer;
        z-index: 9999;
    }
    tr.shown td.details-control {
        background: url('../../table/details_close.png') no-repeat center center !important;
        cursor: pointer;
        z-index: 9999;
    }
</style>

<div class="row">
  <div class="content-overlay"></div>
  <div class="header-navbar-shadow"></div>
  <div class="content-wrapper p-0">
    <div class="content-header row">

      <div class="content-header-left">
        <div class="row breadcrumbs-top">
          <div class="d-flex justify-content-between">
            <div>
              <div class="breadcrumb-wrapper">
                <h3 class="content-header-title fw-bolder float-start mb-0">Posts (<span id="catCount">0</span>) </h3>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a>
                  </li>
                  <li class="breadcrumb-item"> Posts </li>
                </ol>
              </div>
            </div>
            <a href="{{route('posts.create')}}" class="btn btn-primary"> <i data-feather='plus'></i> Add Post</a>
          </div>
        </div>
      </div>
    </div>

  </div>


  <div class="card mt-2">

    <div class="card-body p-1">

      <div class="table-responsive">

        <table class="table" id="showRecord">
          <thead>
            <tr>
              <th>Sr#</th>
              <th>Image</th>
              <th>Title</th>
              <th>Category</th>
              <th>Tags</th>
              <th> Status </th>
              <th>Created at</th>
              <th>Created By</th>
              <th> Change Status </th>
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


<!-- delete Modal -->
<div class="modal fade text-start" id="deleteModal" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" > Confirmation </h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="id">
				<p>Are you sure you want to delete?</p>
			</div>
			<div class="modal-footer bg-light">
				<button data-bs-dismiss="modal" type="button" class="btn btn-secondary btn-cons btn-animated from-top"> Cancel </button>

				<button type="button" class="btn btn-danger waves-effect delBtn">  Delete </button>

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
  let get_posts = "{{route('posts.get')}}";
</script>
<script src="{{asset('admin/js/posts.js')}}"></script>
@endsection