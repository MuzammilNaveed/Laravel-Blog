@extends('admin.layout.master')
@section('page_title','Manage Posts')
@section('brand_menu','active')
@section('blog','open active')
@section('post','active')
@section('container')

<style>
  .seo>li {
    line-height: 0px;
  }
</style>
@if($permission != null && $permission != "")
  <p id="update" class="d-none"> {{str_contains($permission->action,'update') ? 1 : 0}} </p>
  <p id="delete" class="d-none"> {{str_contains($permission->action,'delete') ? 1 : 0}} </p>
@endif


<div class="row mt-2 add_margin">
  <div class="container-fluid p-0">
    <div class="card card_shadow">
      <div class="card-header d-flex justify-content-between">
        <div class="card-title font-weight-bolder">All Posts</div>
        <div class="export-options-container">
          <div class="exportOptions">
            <div class="DTTT btn-group">
            @if($permission != null && $permission != "")
              @if( str_contains($permission->action,'create') )  
                <button type="button" class="btn btn-primary btn-sm rounded"><a href="{{route('add_post.index')}}">
                    <i class="fas fa-plus-circle"></i> Add Post</a></button>
              @endif
            @endif
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover w-100 text-left" id="post_table">
            <thead>
              <tr>
                <th>Sr#</th>
                <th>Image</th>
                <th>Title</th>
                <th>Total Views</th>
                <th>Category</th>
                <th>Section</th>
                <th>Created By</th>
                <th>Comments</th>
                <th>Tags</th>
                <th>SEO</th>
                <th>Publish</th>
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


<!-- user view modal -->
<div class="modal fade stick-up" id="userViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

        <h5 class="modal-title" id="exampleModalLabel"> <span class="text-primary" id="username"></span> Detail</h5>
      </div>
      <div class="modal-body mt-2" id="user_detail">

      </div>
    </div>

    <div class="loader_container" id="user_loader">
      <div class="loader"></div>
    </div>

  </div>
</div>

<!-- comment view modal -->
<div class="modal fade stick-up" id="commentViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

        <h5 class="modal-title" id="exampleModalLabel"><span class="text-primary" id="postname"></span> - Comments</h5>
      </div>
      <div class="modal-body mt-2" id="comment_detail">

      </div>
    </div>

    <div class="loader_container" id="cmt_loader">
      <div class="loader"></div>
      page_title adsfadsf
    </div>

  </div>
</div>

@endsection
@section('scripts')
<script>
  var view_post = "{{url('view_post')}}";
  var user_detail = "{{url('user_detail')}}";
  var comment_details = "{{url('comment_details')}}"
  var posts = "{{url('posts')}}";
</script>
<script src="{{asset('admin/js/posts.js')}}"></script>
@show