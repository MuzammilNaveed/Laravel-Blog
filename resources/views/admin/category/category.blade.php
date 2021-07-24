@extends('admin.layout.master')
@section('page_title','Manage Categories')
@section('container')

<style>
  .select2-selection {
    width: 200px !important;
  }
</style>

<div class="row mt-2">
  <div class="container-fluid p-0">

      <p id="update" class="d-none"> {{str_contains($permission->action,'update') ? 1 : 0}} </p>
      <p id="delete" class="d-none"> {{str_contains($permission->action,'delete') ? 1 : 0}} </p>

        <div class="card card_shadow">
      <div class="card-header d-flex justify-content-between">
        <div class="card-title font-weight-bolder">All Categories 
            <span class="badge bg-primary text-white" id="counts"></span> 
        </div> 
        @if( str_contains($permission->action,'create') )
        <button data-toggle="modal" data-target="#addRecordModal" class="btn btn-primary">
          <i class="material-icons">add</i> Add Category</button>
        @endif
      </div>

      <div class="card-body">
        <div class="table-responsive sm-m-b-15">
          <table class="table table-hover no-footer w-100" id="showRecord">
            <thead>
              <tr role="row">
                <th>Sr #</th>
                <th>Created At</th>
                <th>Category Name</th>
                <th>Total Posts</th>
                <th>Category Description</th>
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

<!-- Modal -->
<div class="modal fade stick-up" id="addRecordModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> <span class="text-muted small">Add</span> <span class="text-primary">Category</span> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form role="form" id="addRecord" class="mt-3">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group form-group-default">
                <label>Category Name</label>
                <input id="appName" name="name" type="text" class="form-control" placeholder="Name of Category">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group form-group-default">
                <label>Description</label>
                <textarea cols="30" rows="10" name="description" type="text" class="form-control" style="resize:none;height:80px" placeholder="Tell us more about it"></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-default form-group-default-select2">
                    <label class="">Category</label>
                    <select class="full-width select2-hidden-accessible" name="parent_id" data-placeholder="Select Parent Category" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
                        <option value="0">Root</option>
                        @foreach($categories as $cat)
                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
          </div>
          <div class="modal-footer pr-0">
            <button id="add-app" type="submit" class="btn btn-primary  btn-cons"> Save</button>
            <button aria-label="" type="button" class="btn btn-cons" data-dismiss="modal"> Cancel</button>
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
        <h5 class="modal-title" id="exampleModalLabel"> <span class="text-muted small">Update</span> <span class="text-primary" id="catname"></span> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" id="updateRecord" class="mt-3">
          <input type="hidden" id="id">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group form-group-default">
                <label>Category Name</label>
                <input id="name" name="name" type="text" class="form-control" placeholder="Name of Category">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group form-group-default">
                <label>Description</label>
                <textarea cols="30" rows="10" id="description" name="description" type="text" class="form-control" style="resize:none;height:80px" placeholder="Tell us more about it"></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="form-group form-group-default form-group-default-select2">
                <label class="">Category</label>
                <select class="full-width select2-hidden-accessible" id='parent_id' name="parent_id" data-placeholder="Select Category" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
                    <option value="0">Root</option>
                    @foreach($categories as $category) 
                      <option value="{{$category->id}}"> {{$category->name}} </option>
                    @endforeach
                </select>
            </div>
          </div>
          <div class="modal-footer pr-0">
            <button id="add-app" type="submit" class="btn btn-primary  btn-cons"> Save</button>
            <button aria-label="" type="button" class="btn btn-cons" data-dismiss="modal"> Cancel</button>
          </div>
        </form>

        <div class="loader_container" id="edit_loader">
            <div class="loader"></div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- post view modal -->
<div class="modal fade stick-up" id="postViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> <span class="text-primary" id="categoryname"></span> has following posts</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mt-2" id="category_post">



      </div>
    </div>

    <div class="loader_container" id="cat_post_loader">
      <div class="loader"></div>
    </div>

  </div>
</div>


@endsection
@section('scripts')
<script src="{{asset('admin/js/category.js')}}"></script>

<script>
  var categories = "{{url('categories')}}";
  var category_posts = "{{url('category_posts')}}";
  var view_post = "{{url('view_post')}}";
</script>
@show