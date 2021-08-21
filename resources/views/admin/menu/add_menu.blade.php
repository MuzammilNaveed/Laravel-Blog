@extends('admin.layout.master')
@section('page_title','Manage Menu')
@section('appearance','active')
@section('menu','active')
@section('container')

<div class="row mt-2 add_margin">
    <div class="container-fluid p-0">

        <h2>Create Menu</h2>

        @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{session('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif


        <div class="row">

            <div class="col-md-6">

                @if($id) 
                    <a href="{{url('menu-item')}}/{{$id}}" class="btn btn-primary">Add Menu Items</a>
                    <div class="card">

                    </div>
                @else
                    <div class="alert alert-info" role="alert">
                        Please save the menu first to add menu items.
                    </div>
                @endif


                
            </div>
            
            <div class="col-md-6">
                <div class="card p-3"   >
                    <form action="{{url('insert-menu')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group form-group-default">
                            <label> Name</label>
                            <input name="name" type="text" class="form-control" placeholder="Menu Name" required>
                        </div>
                        <div class="form-check primary mt-3">
                            <input type="checkbox" id="enabled_menu" name="enabled_menu">
                            <label for="enabled_menu"> Enable this Menu </label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-cons btn-lg mt-2">Save</button>
                    </form>
                </div>
            </div>

        </div>

    </div>
</div>



@endsection
@section('scripts')
@show