@extends('admin.layout.master')
@section('page_title','Manage Categories')
@section('container')


<style>
    td.details-control {
        background: url('../../website/details_open.png') no-repeat center center !important;
        cursor: pointer;
    }

    tr.shown td.details-control {
        background: url('../../website/details_close.png') no-repeat center center !important;
        cursor: pointer;
    }
</style>

<div class="row add_margin">
    <div class="container-fluid p-0">
        <div class="card card_shadow mt-4 border-0 rounded-0">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 style="font-size:1rem" class="text-dark font-weight-bold mt-3">Comments <span class="badge bg-primary text-white" id="counts"></span> </h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table w-100 text-dark text-center" id="comment_table">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>Sr#</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Comment</th>
                                <th>Post Title</th>
                                <th>Replies</th>
                                <th>Status</th>
                                <th>Action</th>
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

<script>
    let get_comments = "{{url('getComments')}}";
    let get_comment_replies = "{{url('get_replie_by_id')}}";
    let view_post = "{{url('view_post')}}";
    let approve_comment = "{{url('approve_comment')}}";
    let approve_comment_reply = "{{url('approve_comment_reply')}}";
</script>
<script src="{{asset('admin/js/comment.js')}}"></script>

@show