@extends('admin.layout.master')
@section('page_title','Manage Pages')
@section('pages','active')
@section('container')

<div class="row mt-2">
  <div class="container-fluid p-0">

    <div class="d-flex justify-content-between pt-3 pb-3 pr-0 pl-0">
      <div class="card-title font-weight-bolder">All Pages</div>
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
              @foreach($pages as $page)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$page->created_at}}</td>
                  <td>{{$page->page_name}}</td>
                  <td>{{$page->page_slug}}</td>
                  <td>
                    <div class="d-flex justify-content-center">
                      
                      <a href="{{url('edit_page')}}/{{$page->page_slug}}" type="button" class="btn btn-primary text-white btn_cirlce ml-2" data-toggle="tooltip" data-placement="top" title="Edit Page"><i class="fas fa-pen"></i></a>

                      <button data-toggle="tooltip" data-placement="top" title="Delete Page" type="button" class="btn btn-danger text-white ml-2 text-white btn_cirlce">
                      <i class="fas fa-trash"></i></button>
                      </div>
                  </td>
                </tr>
              @endforeach
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