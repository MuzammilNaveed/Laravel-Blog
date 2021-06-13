@extends('admin.layout.master')
@section('page_title','Email Subscription')
@section('container')

<div class="row">
    <div class="container p-0">
        <div class="card card_shadow mt-4 border-0 rounded-0">
            <!-- <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 style="font-size:1rem" class="text-dark font-weight-bold mt-3">Comments <span class="badge bg-primary text-white" id="counts"></span> </h4>
                </div>
            </div> -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table w-100 text-dark text-center" id="email_table">
                        <thead>
                            <tr>
                                <th>Sr#</th>
                                <th>Date</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="loader_container">
                    <div class="loader"></div>
                </div>

            </div>
        </div>
    </div>
</div>



@endsection
@section('scripts')

<script src="{{asset('admin/js/email.js')}}"></script>

@show