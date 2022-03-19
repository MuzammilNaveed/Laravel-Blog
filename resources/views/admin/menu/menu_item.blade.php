@extends('admin.layout.master')
@section('page_title','Menu Item')
@section('appearance','active')
@section('menu','active')
@section('content')

<div class="">
    <div class="container-fluid p-0">

        <h2>Create Menu Item</h2>
        @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{session('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <div class="col-md-12">
            <div class="card p-1">
                <form action="{{url('insert-menu-items')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="menu_id" value="{{$id}}">

                    <div class="row">
                        <div class="col-md-6">
                            <label> Name <span class="text-danger">*</span> </label>
                            <input name="name" type="text" class="form-control" placeholder="Menu Name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="">Type</label>
                            <select class="select2" name="type" id="type" data-placeholder="Select Type" data-init-plugin="select2">
                                <option value="category">Category</option>
                                <option value="page">Page</option>
                                <option value="url">URL</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-md-6">
                            <label> URL <span class="text-danger">*</span></label>
                            <input name="url" type="text" class="form-control" placeholder="Menu URL">
                        </div>
                        <div class="col-md-6">
                            <label> Icon</label>
                            <input name="icon" type="text" class="form-control" placeholder="Menu Icon">
                        </div>
                    </div>

                    
                    <div class="row mt-1">
                        <div class="col-md-6">
                            <label class="">Target</label>
                            <select class="select2" name="target" data-placeholder="Select Target" data-init-plugin="select2">
                                <option value="_self">Same Tab</option>
                                <option value="_blank">New Tab</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="">Parent Menu Item</label>
                            <select class="select2" name="parent_menu_id" data-placeholder="Select Parent Menu Item" data-init-plugin="select2">
                                <option value="0">Root</option>
                                @foreach($menuItems as $item)
                                    <option value="{{$item->id}}"> {{$item->name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-1">

<div class="col-md-6" id="category_dropdown">
    <label class="">Category</label>
    <select class="select2" name="category_id" data-placeholder="Select Type" data-init-plugin="select2">
        <option value="">Select Category</option>
        @foreach($categories as $category)
            <option value="{{$category->id}}"> {{$category->name}} </option>
        @endforeach
    </select>
</div>

<div class="col-md-6" id="page_dropdown" style="display:none">
    <label class="">Page</label>
    <select class="select2" name="page_id" data-placeholder="Select Type" data-init-plugin="select2">
        <option value="">Select Page</option>
        @foreach($pages as $page)
            <option value="{{$page->id}}"> {{$page->page_name}} </option>
        @endforeach
    </select>
</div>

</div>

                    <div class="form-check primary mt-2">
                        <input type="checkbox" id="enabled_menu" name="enabled_menu">
                        <label for="enabled_menu"> Enable this menu item </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-cons btn-lg mt-2">Save</button>
                </form>
            </div>
        </div>

    </div>
</div>



@endsection
@section('js')
<script>
    $(document).ready(function() {

        $("#type").on('change', function() {
            let value = $(this).val();

            if(value == "page") {

                $("#page_dropdown").show(); 
                $("#category_dropdown").hide(); 
                $("#url_input").hide();

            }else if(value == "url") {

                $("#url_input").show();
                $("#category_dropdown").hide(); 
                $("#page_dropdown").hide(); 
            
            }else if(value == "category") {

                $("#category_dropdown").show(); 
                $("#url_input").hide();
                $("#page_dropdown").hide(); 

            }
        });
    });
</script>
@endsection