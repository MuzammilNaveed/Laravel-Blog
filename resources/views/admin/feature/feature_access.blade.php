@extends('admin.layout.master')
@section('page_title','Manage Feature List')
@section('container')
<style>

.form-group-default.form-group-default-select2 .select2-container .select2-selection--single {
    padding-top:12px;
    height:48px;
}
</style>
<div class="row mt-2">
  <div class="container-fluid">
    <div class="bg-white">
      <div class="card card-transparent">
        <div class="card-header d-flex justify-content-between">
          <div class="card-title font-weight-bolder">Feature List</div>
          <div class="export-options-container">
            <div class="exportOptions">
              <div class="DTTT btn-group">
                <button class="btn btn-primary" id="btn-add-new-user" data-toggle="modal" data-target="#addFeatureModal"><i class="material-icons">add</i> Add Feature</button>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive sm-m-b-15">
            <table class="table table-hover no-footer w-100 text-center" id="showRecord">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Feature Title</th>
                  <th>Route</th>
                  <th>Active</th>
                  <th>Have Access</th>
                  <th>Sequence</th>
                  <th>Actions</th>
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
</div>


<!-- feature add feature list -->
<div class="modal fade stick-up" id="addFeatureModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> <span class="text-muted small">Add</span> <span class="text-primary font-weight-bold">Feature</span> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mt-2">
        <div class="add-contact-box">
          <div class="add-contact-content">
            <form id="addFeatureForm" method="POST" action="{{url('add_features')}}" enctype="multipart/form-data">

              <div class="form-group">
                <div class="row">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="menu" checked>
                    <label class="form-check-label" for="menu"> Menu </label>
                  </div>
                  <div class="form-check ml-3">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="toggle_menu">
                    <label class="form-check-label" for="toggle_menu"> Toggle Menu </label>
                  </div>
                </div>
              </div>
              <div class="form-group form-group-default" id="menu-title">
                  <label class="text-muted">Title</label>
                  <input type="text" name="title" id="title" class="form-control input-sm" placeholder="Menu Title">
              </div>

              <div class="form-group form-group-default" id="route-title">
                  <label class="text-muted">Route</label>
                  <input type="text" id="route" class="form-control input-sm" placeholder="Menu Route">
              </div>

              <div class="form-group form-group-default">
                  <label class="text-muted">Sequence</label>
                  <input type="number" name="sequence" id="sequence"  class="form-control input-sm" placeholder="Menu Sequence">
              </div>

              <div class="form-group form-group-default">
                  <label class="text-muted">Icon</label>
                  <input type="text" name="icon" id="icon" class="form-control input-sm" placeholder="Menu Icon">
              </div>

              <div class="form-group form-group-default form-group-default-select2">
                  <label class="text-muted" style="z-index:9999">Parent menu</label>
                  <select class="full-width select2-hidden-accessible" name="parent_id" id="parent_id" data-placeholder="Select Parent Menu" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
                  </select>
              </div>

              <div class="form-group form-group-default form-group-default-select2 mt-2">
                  <label class="text-muted" style="z-index:9999">Role</label>
                  <select class="full-width select2-hidden-accessible" name="roles[]" id="add_roles" multiple="multiple" data-placeholder="Select Role" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
                    @foreach($roles as $role)
                      <option value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach
                  </select>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="is_active">
                <label class="form-check-label" for="is_active"> is Active </label>
              </div>

              <div class="form-group mt-3">
                <button type="submit" class="btn btn-success btn-lg text-white">Save</button>
                <button class="btn btn-danger btn-lg text-white" data-dismiss="modal"> Close</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- edit feature list -->
<div class="modal fade stick-up" id="editFeatureModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> <span class="text-muted small">Update </span> <span class="text-primary font-weight-bold">Feature</span> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mt-2">
        <div class="loader_container" style="display:none">
          <div class="loader"></div>
        </div>
        <div class="add-contact-box">
          <div class="add-contact-content">
            <form id="editFeatureForm" method="POST" action="{{url('update_feature')}}" enctype="multipart/form-data">
              <input type="hidden" name="feature_id" id="feature_id">
              <div class="form-group">
                <div class="row">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault4" checked>
                    <label class="form-check-label" for="flexRadioDefault4"> Menu </label>
                  </div>
                  <div class="form-check ml-3">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault5">
                    <label class="form-check-label" for="flexRadioDefault5"> Toggle Menu </label>
                  </div>
                </div>
              </div>

              <div class="form-group form-group-default" id="menu-title">
                  <label>Title</label>
                  <input type="text" name="title" id="edit_title" class="form-control input-sm" placeholder="Menu Title">
              </div>

              <div class="form-group form-group-default" id="ed_route-title">
                  <label>Route</label>
                  <input type="text" id="edit_route" class="form-control input-sm" placeholder="Menu Route">
              </div>

              <div class="form-group form-group-default">
                  <label>Sequence</label>
                  <input type="number" name="sequence" id="edit_sequence" class="form-control input-sm" placeholder="Menu Sequence">
              </div>

              <div class="form-group form-group-default">
                  <label>Icon</label>
                  <input type="text" name="icon" id="edit_icon" class="form-control input-sm" placeholder="Menu Icon">
              </div>

              <div class="form-group form-group-default form-group-default-select2">
                  <label class="text-muted" style="z-index:9999">Parent menu</label>
                  <select class="full-width select2-hidden-accessible" name="parent_id" id="edit_parent_id" data-placeholder="Select Parent Menu" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
                  </select>
              </div>

              <div class="form-group form-group-default form-group-default-select2 mt-2">
                  <label class="text-muted" style="z-index:9999">Role</label>
                  <select class="full-width select2-hidden-accessible" name="roles[]" id="edit_roles" multiple="multiple" data-placeholder="Select Role" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
                    @foreach($roles as $role)
                      <option value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach
                  </select>
              </div>

              <div class="form-check chk_box">
                <input class="form-check-input" type="checkbox" id="edit_is_active">
                <label class="form-check-label" for="edit_is_active"> is Active </label>
              </div>

              <div class="form-group mt-3">
                <button type="submit" class="btn btn-success btn-lg">Save</button>
                <button class="btn btn-danger btn-lg" data-dismiss="modal"> Discard</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
@section('scripts')
<script src="{{asset('admin/js/feature_list.js')}}"></script>
<script>
  var feature_list = "{{url('get_all_features')}}";
  var get_features_by_id = "{{url('get_features_by_id')}}"
</script>
@show