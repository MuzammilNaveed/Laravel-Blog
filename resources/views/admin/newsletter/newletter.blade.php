@extends('admin.layout.master')
@section('page_title','Manage Contact')
@section('newsletters','active')
@section('container')

<div class="row mt-2">
  <div class="container-fluid p-0">

    <div class="d-flex justify-content-between pt-3 pb-3 pr-0 pl-0">
      <div class="card-title font-weight-bolder">All Subscription</div>
      <button type="button" class="btn btn-primary rounded text-white"><a href="{{url('add_page')}}" class="text-white">
            <i class="fas fa-plus-circle"></i> Add Page</a></button>
    </div>

    <div class="card card_shadow">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover w-100 text-center" id="pages_table">
            <thead>
              <tr>
                <th>Sr#</th>
                <th>Created at</th>
                <th>Title</th>
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




@endsection
@section('scripts')
<script>
  let get_all_pages = '{{url("get_all_pages")}}';
  let edit_page = "{{url('edit_page')}}";
</script>
<script src="{{asset('admin/js/pages.js')}}"></script>
@show