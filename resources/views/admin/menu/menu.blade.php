@extends('admin.layout.master')
@section('page_title','Manage Menu')
@section('appearance','active')
@section('menu','active')
@section('container')

<style>
  .select2-selection {
    width: 200px !important;
  }
</style>

<div class="row mt-2 add_margin">

  <div class="container-fluid p-0">
      <div class="card card_shadow">
        <div class="card-header d-flex justify-content-between">
          <div class="card-title font-weight-bolder">Menus <span id="counts" class="badge bg-primary text-white"></span> </div>
          <div class="export-options-container">
            <div class="exportOptions">
              <div class="DTTT btn-group">
                  <a href="{{url('add-menu')}}" type="button" role="button" class="btn btn-primary">
                    <i class="material-icons">add</i> Add Menu</a>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive sm-m-b-15">
            <table class="table table-hover no-footer w-100 text-center" id="tag_table">
              <thead>
                <tr role="row">
                  <th>Sr#</th>
                  <th>Name</th>
                  <th>Status</th>
                  <th>Created at</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($menus as $menu)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$menu->name}}</td>
                  <td>
                      <span class="badge text-white {{$menu->status == 1 ? 'bg-success' : 'bg-danger'}}">
                        {{$menu->status == 1 ? 'Active' : 'De-active'}}
                      </span>
                  </td>
                  <td>{{$menu->created_at}}</td>
                  <td><a href="{{url('edit-menu')}}/{{$menu->id}}" class="btn btn-primary"> <i class="fas fa-edit"></i> </a></td>
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
@show