@extends('admin.layout.master')
@section('page_title','Add Post')
@section('blog','open active')
@section('post','active')
@section('content')


@section('css')

<link href="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"/>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.8/tagify.min.css" integrity="sha512-3TQTxe+kPDiA+h9hlIm4ydUdtreW8fVei75UUVmBioKA+prR2aYZqSDsCOBqGBmXJ4JSXKyj3bMHD1VAFDGyTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

<div class="content-overlay"></div>
<div class="header-navbar-shadow"></div>
<div class="content-wrapper p-0">
    <div class="content-header row">
        
        <div class="content-header-left">
            <div class="row breadcrumbs-top">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="breadcrumb-wrapper">
                        <h3 class="content-header-title fw-bolder float-start mb-0"> Edit Post </h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a> </li>
                                <li class="breadcrumb-item"><a href="{{route('posts.index')}}">Posts</a> </li>
                                <li class="breadcrumb-item"> {{$data->title != null ? $data->title : 'Edit Post'}} </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

<div class="mt-2 mb-2">

    <form id="addRecord" method="POST" action="{{route('posts.store')}}" enctype="multipart/form-data" onsubmit="return false">
        <input type="hidden" name="id" value="{{$data->id}}">
        <div class="row">
            <div class="col-md-9">
                <h4>1. <span class="text-primary">Post Section</span> </h4>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group form-group-default">
                            <label class="fw-bold">Title</label>
                            <input id="title" name="title" type="text" value="{{$data->title != null ? $data->title : ''}}" class="form-control" placeholder="Post Title">
                        </div>
                        <span class="text-muted small ml-1"> <i class="text-danger">Title Should be 50 -60 characters For better SEO</i> </span>

                        <div class="col-md-12 mt-1">
                            <label class="fw-bold" for="tags">Tags </label>
                            <select class="select2" name="tags[]" id="tags" multiple>
                                @foreach($tags as $tag)
                                    <option value="{{$tag->id}}">{{$tag->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-4 mt-1">
                                <label class="fw-bold">Category</label>
                                <select class="select2" name="category">
                                    <option value="">Select</option>
                                    @foreach($categories as $cat)
                                        <option value="{{$cat->id}}" {{$data->cat_id == $cat->id ? 'selected' : ''}} >{{$cat->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mt-1">
                                <label class="fw-bold">Author</label>
                                <select class="select2" id="author" name="author">
                                    <option value="">Select</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mt-1">
                                <label class="fw-bold"> Status </label>
                                <select class="select2" id="status" name="status">
                                    <option value="0" {{$data->status == 0 ? 'selected' : ''}} > Pending </option>
                                    <option value="1" {{$data->status == 1 ? 'selected' : ''}} > Public </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <h4><span class="text-primary"> Feature Post </span> </h4>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            @if($data->image != null)
                            <input type="file" class="form-control dropify" 
                                name="image" data-allowed-file-extensions="png jpeg jpg" 
                                data-max-file-size-preview="3M" data-height="200" data-default-file="{{ request()->root() . '/' . $data->image }}">
                            @else
                            <input type="file" class="form-control dropify" 
                                name="image" data-allowed-file-extensions="png jpeg jpg" 
                                data-max-file-size-preview="3M" data-height="200" data-default-file="">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="col-12">
                    <textarea name="description" class="editor form-control" id="description" class="w-100">{{$data->description}}</textarea>
                </div>
            </div>
        </div>

        <div class="col-12">
            <h4>2. <span class="text-primary">Post SEO Section</span> </h4>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="fw-bold">Post Meta Title</label>
                                <input type="text" id="meta_title" value="{{$data->title != null ? $data->title : ''}}" readonly name="meta_title" class="form-control input-sm" placeholder="Post Meta Title" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-1">
                        <label class="fw-bold">Post Meta Tags</label>
                        <input name='meta_tags' id="meta_tags" type="text" class='form-control' value="{{$data->meta_tags}}">
                    </div>
                    <div class="col-12 mt-1">
                        <div class="form-group form-group-default">
                            <label class="fw-bold">Post Meta Description <span class="text-danger">*</span> </label>
                            <textarea cols="30" rows="5" name="meta_description" type="text" class="form-control"  placeholder="Post Description"> {{$data->meta_description}} </textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary save_btn"> <i data-feather='check'></i> Save</button>

        <button class="btn btn-primary waves-effect loader_btn" style="display:none" type="button" disabled="">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span class="ms-25 align-middle">Saving...</span>
        </button>

        <a href="{{route('posts.index')}}" class="btn btn-danger"> <i data-feather='refresh-cw'></i> Cancel & Go Back</a>

    </form>
</div>

@endsection
@section('js')

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/js/froala_editor.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.8/tagify.min.js"></script>

<script>
    $('.dropify').dropify();

    let tags = {!! json_encode($data->tags) !!};
    console.log(tags);

    if(tags != null && tags.length > 0)  {
        let tag_id = $.map(tags , function (item , index) {
            return item.id;
        });

        tag_id != null ? $("#tags").val(tag_id).trigger("change") : '';
    }  
    
    let input = document.querySelector('input[name=meta_tags]');
    new Tagify(input, {
        originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')
    })

    
    new FroalaEditor('.editor', {
        // Set the image upload parameter.
        height: 250,
        imageUploadParam: 'image_param',
        imageUploadURL: '{{url("upload_post_imgs")}}',
        imageUploadParams: {
            id: 'my_editor'
        },
        imageUploadMethod: 'POST',
        // Set max image size to 5MB.
        imageMaxSize: 5 * 1024 * 1024,
        imageAllowedTypes: ['jpeg', 'jpg', 'png'],
        events: {
            'image.removed': function($img) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {

                    // Image was removed.
                    if (this.readyState == 4 && this.status == 200) {
                        console.log('image was deleted');
                    }
                };
                var img_path =  $img.attr('src');
                var origin_path  = window.location.origin + '/uploads/'; 
                var image_name  = img_path.replace(origin_path,'');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{url("delete_post_imgs")}}',
                    type: 'POST',
                    data: {image_name : image_name},
                    dataType: 'JSON',
                    success: function(data) {
                        console.log(data);
                    },
                    error: function(e) {
                        console.log(e)
                    }

                });
            }
        }

    });

    $("#title").keyup(function() {
        $("#meta_title").val($(this).val());
    });

    $('#addRecord').submit(function(e) {
        e.preventDefault();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $(this).attr('action'),
            type: 'POST',
            data: new FormData(this),
            dataType: 'JSON',
            async:true,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend:function(data) {
                $('.save_btn').hide();
                $('.loader_btn').show();
            },
            success: function(data) {
                console.log(data);
                if ((data.status == 200) & (data.success == true)) {
                    notyf.success(data.message);
                } else {
                    notyf.error(data.message);
                }
            },
            complete:function(data) {
                $('.save_btn').show();
                $('.loader_btn').hide();
            },
            error: function(e) {
                $('.save_btn').show();
                $('.loader_btn').hide();
                console.log(e);
            }

        });

    });
</script>
@endsection