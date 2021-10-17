@extends('admin.layout.master')
@section('page_title','Manage Contact')
@section('newsletters','active')
@section('container')

<div class="row mt-2">
  <div class="container-fluid p-0">

    <div class="d-flex justify-content-between pt-3 pb-3 pr-0 pl-0">
      <div class="card-title font-weight-bolder">All Subscription</div>
    </div>

    <div class="card card_shadow">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover w-100 text-center" id="newslettters_table">
            <thead>
              <tr>
                <th>Sr#</th>
                <th>Email</th>
                <th>Created at</th>
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




@endsection
@section('scripts')
  <script src="{{asset('admin/js/newletter.js')}}"></script>
@show