@extends('admin.layout.master')
@section('page_title','Comment - ' . $comment->comment)
@section('comments','active')
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
            <div class="card-body">
                <h4 class="m-0">Post</h4>
                <a href="{{url('view_post')}}/{{$post->id}}">{{$post->title}}</a>

                <hr class="mt-2 mb-1">

                <h4>Comment Details</h4>
                <div class="row">
                    <div class="col-md-3">
                        <strong>Name</strong> <br>
                        <span class="text-muted small">{{$comment->name}}</span>
                    </div>
                    <div class="col-md-3">
                        <strong>Email</strong> <br>
                        <span class="text-muted small">{{$comment->email}}</span>
                    </div>
                    <div class="col-md-3">
                        <strong>Created at</strong> <br>
                        <span class="text-muted small">{{$comment->created_at}}</span>
                    </div>
                    <div class="col-md-3">
                        <strong> Status </strong> <br>
                        <span class="text-muted small">
                            @php
                                $status = ($comment->status == 0) ? "Pending" : (($comment->status == 1)  ? "Approved" : "Rejected");
                            @endphp
                            {{$status}}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h4>Message</h4>
                        <p class="m-0 text-muted">
                            {{$comment->comment}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
@section('scripts')

@show