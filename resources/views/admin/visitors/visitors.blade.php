@extends('admin.layout.master')
@section('page_title','Site Visitor Detail')
@section('container')

<style>
  .form-group-default.form-group-default-select2 .select2-container .select2-selection--single {
    height: 42px !important;
  }

  .modal-backdrop {
    z-index: 12 !important;
  }
</style>



<div class="row mt-2">

  <div class="container p-0">

    <div class="bg-white mt-3">
      <div class="card card_shadow">
        <div class="card-header d-flex justify-content-between">
          <div class="card-title font-weight-bolder">All Visitors <span class="badge bg-primary text-white" id="counts"></span> </div>
          <div class="export-options-container">
            <div class="exportOptions">
              <div class="DTTT btn-group">
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive sm-m-b-15">
            <table class="table table-hover no-footer w-100" id="showRecord">
              <thead>
                <tr>
                  <th>Sr#</th>
                  <th>Date</th>
                  <th>IP Address</th>
                  <th>Country</th>
                  <th>City</th>
                  <th>State</th>
                  <th>Postal Code</th>
                  <th>Time Zone</th>
                  <th>Platform</th>
                  <th>Platform Version</th>
                  <th>Browser</th>
                  <th>Browser Version</th>
                  <th>Device</th>
                  <th>Desktop</th>
                  <th>Phone</th>
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
<!-- visitors.js -->
@endsection

@section('scripts')
<script> var get_usrr_info = "{{url('get_usrr_info')}}" </script>
<script type="text/javascript" src="{{asset('admin/js/visitors.js')}}"></script>

@show