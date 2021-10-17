@extends('admin.layout.master')
@section('page_title','View Contact')
@section('contact','active')
@section('container')

<div class="row mt-2">
  <div class="container-fluid p-0">


    <div class="card card_shadow">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <span class="text-muted small m-0"> Name </span>
                    <h4 class="m-0">{{$contact->name}}</h4>
                </div>
                <div>
                    <span class="text-muted small m-0">Email</span>
                    <h4 class="m-0">{{$contact->email}}</h4>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-2">
                <div>
                    <span class="text-muted small mt-5"> Subject </span>
                    <h4 class="m-0">{{$contact->subject}}</h4>
                </div>
                <div>
                    <span class="text-muted small m-0">Created at</span>
                    <h4 class="m-0">{{$contact->created_at->diffForhumans()}}</h4>
                </div>
            </div>

            <hr class="m-1">
            <span class="text-muted small m-0">Message</span>
            <p>{{$contact->message}}</p>
        </div>
        
    </div>
    <button class="btn btn-primary btn-lg">Reply</button>



  </div>
</div>




@endsection
