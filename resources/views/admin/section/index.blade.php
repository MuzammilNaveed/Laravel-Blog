@extends('admin.layout.master')
@section('page_title','Manage Section')
@section('blog','active')
@section('section','active')
@section('container')

<div class="row mt-2 add_margin">

  <div class="container-fluid p-1">
      <div class="card card_shadow">
        <div class="card-header d-flex justify-content-between">
          <div class="card-title font-weight-bolder"> Sections <span id="counts" class="badge bg-primary text-white"></span> </div>
          <div class="export-options-container">
            <div class="exportOptions">
              <div class="DTTT btn-group">
                  <button id="add_section" class="btn btn-primary">
                    <i class="material-icons">add</i> Add Section</button>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive sm-m-b-15">
            <table class="table table-hover no-footer w-100 text-center" id="section_table">
              <thead>
                <tr role="row">
                  <th>Sr#</th>
                  <th>Title</th>
                  <th>Status</th>
                  <th>Created At</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</div>


<!--section modal -->
<div class="modal fade stick-up" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title"> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addRecord" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" id="id">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group form-group-default">
                <label> Name</label>
                <input name="title" id="title" type="text" class="form-control" placeholder="Section Name">
              </div>
            </div>
            <div class="form-check checkbox-circle complete">
                <input type="checkbox" id="checkcircleColorOpt2" name="status">
                <label for="checkcircleColorOpt2">
                is Active
                </label>
            </div>
          </div>
          <div class="modal-footer pr-0">
            <button id="add-app" type="submit" class="btn btn-primary  btn-cons"> Save</button>
            <button aria-label="" type="button" class="btn btn-cons" data-dismiss="modal"> Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



@endsection
@section('scripts')
<script>
  var get_section = "{{url('get_section')}}";
</script>
<script src="{{asset('admin/js/section.js')}}"></script>
@show