@extends('admin.layout.master')
@section('page_title','Add Post')
@section('blog','open active')
@section('post','active')
@section('content')


@section('css')
<link href="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.8/tagify.min.css" />
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
                        <h3 class="content-header-title fw-bolder float-start mb-0"> Create Post </h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a> </li>
                                <li class="breadcrumb-item"><a href="{{route('posts.index')}}">Posts</a> </li>
                                <li class="breadcrumb-item"> Create Post </li>
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
        <input type="hidden" name="id">
        <div class="row">
            <div class="col-md-9">
                <h4>1. <span class="text-primary">Post Section</span> </h4>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group form-group-default">
                            <label class="fw-bold">Title</label>
                            <input name="title" id="title" name="title" type="text" class="form-control" placeholder="Post Title">
                        </div>
                        <span class="text-muted small ml-1"> <i class="text-danger">Title Should be 50 -60 characters For better SEO</i> </span>

                        <div class="col-md-12 mt-1">
                                
                                <div class="d-flex justify-content-between">
                                    <label class="fw-bold" for="tags">Tags</label>

                                    <a href="javascript:void(0)" onclick="tagsModal()" class="text-success small"> 
                                        <i data-feather='plus-circle'></i> add new </a>
                                </div>
                                <select class="select2" name="tags[]" id="tags" multiple>
                                    @foreach($tags as $tag)
                                    <option value="{{$tag->id}}">{{$tag->name}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-4 mt-1">

                                <div class="d-flex justify-content-between">
                                    <label class="fw-bold" for="tags"> Category </label>
                                    <a href="javascript:void(0)" onclick="categoryModal()" class="text-success small"> 
                                        <i data-feather='plus-circle'></i> add new </a>
                                </div>

                                <select class="select2" name="category">
                                    <option value="">Select</option>
                                    @foreach($categories as $cat)
                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
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
                                    <option value="0"> Pending </option>
                                    <option value="1"> Public </option>
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
                            <input type="file" class="form-control dropify" name="image" data-allowed-file-extensions="png jpeg jpg" data-max-file-size-preview="3M" data-height="200">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="col-12">
                    <textarea name="description" class="editor form-control" id="description" class="w-100"></textarea>
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
                                <input type="text" id="meta_title" name="meta_title" class="form-control input-sm" placeholder="Post Meta Title" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-1">
                        <label class="fw-bold">Post Meta Tags</label>
                        <input name='meta_tags' id="meta_tags" type="text" class='form-control'>
                    </div>
                    <div class="col-12 mt-1">
                        <div class="form-group form-group-default">
                            <label class="fw-bold">Post Meta Description <span class="text-danger">*</span> </label>
                            <textarea cols="30" rows="10" name="meta_description" type="text" class="form-control" style="resize:none;height:80px" placeholder="Post Description"></textarea>
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


<!-- add update  category modal  -->
<div class="modal fade text-start" id="categoryModal" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="modal_title"> Add Category </h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="saveCategory" method="POST" enctype="multipart/form-data" action="{{route('category.store')}}">
					<input type="hidden" name="id" id="id">

					<div class="col-sm-12">
						<div class="form-group form-group-default">
							<label>Category Name <span class="text-danger">*</span> </label>
							<input name="name" id="name" type="text" required="required" class="form-control" placeholder="Name of Category">
						</div>
					</div>

					<div class="col-sm-12 mt-1">
						<div class="form-group form-group-default">
							<label>Description</label>
							<textarea cols="30" rows="5" name="description" id="description" type="text" class="form-control" placeholder="Tell us more about it"></textarea>
						</div>
					</div>

					<div class="col-md-12 mt-1">
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="status" value="1" name="status">
							<label class="form-check-label" for="status">Active</label>
						</div>
					</div>

					<div class="modal-footer mt-2">
						<button aria-label="" type="button" class="btn btn-danger" data-bs-dismiss="modal"> Cancel</button>
						<button class="btn btn-primary waves-effect loadingBtn" style="display:none" type="button" disabled="">
							<span class="spinner-border spinner-border-sm " role="status" aria-hidden="true"></span>
							<span class="ms-25 align-middle">Saving...</span>
						</button>
						<button id="save_btn" type="submit" class="btn btn-primary saveBtn"> Save</button>
						<button id="loader" type="button" style="display:none" role="button" class="btn btn-primary  btn-cons" disabled> <i class="fas fa-circle-notch fa-spin"></i> </button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- add update tags modal  -->
<div class="modal fade text-start" id="tagsModal" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="modal_title"> Add Tag </h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="saveForm" method="POST" enctype="multipart/form-data" action="{{route('tag.store')}}">
					<input type="hidden" name="id" id="id">

					<div class="col-sm-12">
						<div class="form-group form-group-default">
							<label class="fw-bold">Name <span class="text-danger">*</span> </label>
							<input name="name" id="name" type="text" required="required" class="form-control" placeholder="Name of tag">
						</div>
					</div>

					<div class="col-md-12 mt-1">
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="checkbox" id="status" value="1" name="status">
							<label class="form-check-label" for="status">Active</label>
						</div>
					</div>

					<div class="modal-footer border-0 mt-2">

						<button aria-label="" type="button" class="btn btn-danger" data-bs-dismiss="modal"> Cancel</button>

						<button class="btn btn-primary waves-effect loadingBtn" style="display:none"  type="button" disabled="">
							<span class="spinner-border spinner-border-sm " role="status" aria-hidden="true"></span>
							<span class="ms-25 align-middle">Saving...</span>
						</button>

						<button id="save_btn" type="submit" class="btn btn-primary saveBtn"> Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection
@section('js')

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/js/froala_editor.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.8/tagify.min.js"></script>

<script>
    $('.dropify').dropify();

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

    function tagsModal() {
        $("#tagsModal").modal('show');
    }

    function categoryModal() {
        $("#categoryModal").modal('show');
    }
</script>
@endsection