@extends('admin.layout.master')
@section('page_title','Menu Item')
@section('appearance','active')
@section('menu','active')
@section('container')

<div class="row mt-2 add_margin">
    <div class="container-fluid p-0">

        <h2>Edit Menu Item</h2>
        @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{session('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <div class="col-md-6">
            <div class="card p-3">
                <form action="{{url('update-menu-item')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group form-group-default">
                        <label> Name <span class="text-danger">*</span> </label>
                        <input name="name" value="{{$menuitem->name}}" type="text" class="form-control" placeholder="Menu Name" required>
                    </div>

                    <input type="hidden" name="item_id" value="{{$menuitem->id}}">

                    <div class="form-group form-group-default form-group-default-select2 required mt-2">
                        <label class="">Type</label>
                        <select class="full-width" name="type" id="type" data-placeholder="Select Type" data-init-plugin="select2">
                            <option value="category" {{$menuitem->type == "category" ? 'selected' : ''}}>Category</option>
                            <option value="page" {{$menuitem->type == "page" ? 'selected' : ''}}>Page</option>
                            <option value="url" {{$menuitem->type == "url" ? 'selected' : ''}}>URL</option>
                        </select>
                    </div>

                    <div class="form-group form-group-default form-group-default-select2 required mt-2" id="category_dropdown" style="display:{{$menuitem->type == 'category' ? 'block' : 'none'}}">
                        <label class="">Category</label>
                        <select class="full-width" name="category_id" data-placeholder="Select Type" data-init-plugin="select2">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}" {{$menuitem->category_id != null || $menuitem->category_id == $category->id ? 'selected' : ''}} > {{$category->name}} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group form-group-default form-group-default-select2 required mt-2" id="page_dropdown" style="display:{{$menuitem->type == 'page' ? 'block' : 'none'}}">
                        <label class="">Page</label>
                        <select class="full-width" name="page_id" data-placeholder="Select Type" data-init-plugin="select2">
                            <option value="">Select Page</option>
                            @foreach($pages as $page)
                                <option value="{{$page->id}}" {{$menuitem->page != null || $menuitem->page_id == $page->id ? 'selected' : ''}} > {{$page->page_name}} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group form-group-default mt-2" id="url_input" style="display:{{$menuitem->type == 'url' ? 'block' : 'none'}}">
                        <label> URL <span class="text-danger">*</span></label>
                        <input name="url" type="text" class="form-control" placeholder="Menu URL" value={{$menuitem->url != null ? $menuitem->url : ''}}>
                    </div>

                    <div class="form-group form-group-default mt-2">
                        <label> Icon</label>
                        <input name="icon" type="text" value="{{$menuitem->icon}}" class="form-control" placeholder="Menu Icon">
                    </div>

                    <div class="form-group form-group-default form-group-default-select2 required mt-2">
                        <label class="">Target</label>
                        <select class="full-width" name="target" data-placeholder="Select Target" data-init-plugin="select2">
                            <option value="_self" {{$menuitem->target == '_self' ? 'selected' : ''}}>Same Tab</option>
                            <option value="_blank" {{$menuitem->target == '_blank' ? 'selected' : ''}}>New Tab</option>
                        </select>
                    </div>

                    <div class="form-group form-group-default form-group-default-select2 required mt-2">
                        <label class="">Parent Menu Item</label>
                        <select class="full-width" name="parent_menu_id" data-placeholder="Select Parent Menu Item" data-init-plugin="select2">
                            <option value="0" {{$menuitem->parent_id == 0 ? 'selected' : ''}}>Root</option>
                            @foreach($menuItems as $item)
                                <option value="{{$item->id}}" {{$menuitem->parent_id == $item->id ? 'selected' : ''}}> {{$item->name}} </option>
                            @endforeach
                        </select>
                    </div>

                    @if($menuitem->status == 1)
                        <div class="form-check primary mt-2">
                            <input type="checkbox" id="enabled_menu" name="enabled_menu" checked>
                            <label for="enabled_menu"> Enable this menu item </label>
                        </div>
                    @else
                        <div class="form-check primary mt-2">
                            <input type="checkbox" id="enabled_menu" name="enabled_menu">
                            <label for="enabled_menu"> Enable this menu item </label>
                        </div>
                    @endif

                    <button type="submit" class="btn btn-primary btn-cons btn-lg mt-2">Save</button>
                </form>
            </div>
        </div>

    </div>
</div>



@endsection
@section('scripts')
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
@show