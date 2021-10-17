@extends('admin.layout.master')
@section('page_title','Manage Permissions')
@section('administration','open active')
@section('role','active')
@section('container')

<div class="row mt-2 add_margin">
  <div class="container-fluid p-0">
    <div class="card card_shadow">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover w-100 text-center" id="newslettters_table">
            <thead>
              <tr>
                <th>Sr#</th>
                <th>Page Name</th>
                <th> View </th>
                <th> Create </th>
                <th> Edit </th>
                <th> Delete </th>
              </tr>
            </thead>
            <tbody>
              @foreach($features as $feature)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$feature->title}}</td>
                <td>
                  <div class="custom-control custom-checkbox mr-sm-2">
                    <input type="checkbox" class="custom-control-input" id="view_{{$feature->id}}">
                    <label class="custom-control-label" for="view_{{$feature->id}}"></label>
                  </div>
                </td>
                <td>
                  <div class="custom-control custom-checkbox mr-sm-2">
                    <input type="checkbox" class="custom-control-input" id="create_{{$feature->id}}">
                    <label class="custom-control-label" for="create_{{$feature->id}}"></label>
                  </div>
                </td>
                <td>
                  <div class="custom-control custom-checkbox mr-sm-2">
                    <input type="checkbox" class="custom-control-input" id="edit_{{$feature->id}}">
                    <label class="custom-control-label" for="edit_{{$feature->id}}"></label>
                  </div>
                </td>
                <td>
                  <div class="custom-control custom-checkbox mr-sm-2">
                    <input type="checkbox" class="custom-control-input" id="delete_{{$feature->id}}">
                    <label class="custom-control-label" for="delete_{{$feature->id}}"></label>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <form method="POST" action="{{url('save_permissions')}}">
      @csrf
    </form>
  </div>
</div>


@endsection