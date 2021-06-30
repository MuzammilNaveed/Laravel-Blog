@extends('admin.layout.master')
@section('page_title','Manage Pages')
@section('container')

<div class="row mt-2">
  <div class="container-fluid p-0">
    <div class="card card_shadow">
      <div class="card-header d-flex justify-content-between">
        <div class="card-title font-weight-bolder">All Pages</div>

        <button type="button" class="btn btn-primary rounded"><a href="{{url('add_page')}}">
            <i class="fas fa-plus-circle"></i> Add Page</a></button>

      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover w-100 text-left" id="pages_table">
            <thead>
              <tr>
                <th>Sr#</th>
                <th>Date</th>
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