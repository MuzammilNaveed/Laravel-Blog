@extends('admin.layout.master')
@section('page_title','Edit Post')
@section('container')
<style>
    .tag {
        width: fit-content !important;
    }

    .bootstrap-tagsinput {
        display: flex !important;
        margin-top: 5px !important;
        box-shadow: none !important;
    }

    .label-info {
        background-color: #6d5eac !important;
    }
    #videoUpload-1 {
        display:none !important;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />

<div class="mt-1 mb-5">
    <div class="">
        <ul class="breadcrumb p-l-0">
            <li class="breadcrumb-item"><a href="{{route('post.index')}}">Post</a>
            </li>
            <li class="breadcrumb-item active">Edit Post
            </li>
        </ul>
    </div>

    <form id="editRecord">
        <input type="hidden" id="post_id" name="post_id" value="{{$post->id}}">

        <div class="row">
            <div class="col-md-9">
                <h4>1. <span class="text-primary">Post Section</span> </h4>
                <div class="card card_shadow p-3 border-0 rounded-0">
                    <div class="form-group form-group-default">
                        <label>Title</label>
                        <input name="title" id="title" type="text" value="{{$post->title}}" class="form-control input-sm" placeholder="Post Title">
                    </div>
                    <span class="text-muted small ml-1"> <i>Title Should be 50 -60 characters For better SEO</i> </span>


                    <div class="form-group form-group-default form-group-default-select2 mt-2">
                        <label class="">Tags</label>
                        <select class="full-width select2-hidden-accessible" name="tags[]" id="tags" multiple="multiple" data-placeholder="Select Tags" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
                            @foreach($tags as $tag)
                            <option value="{{$tag->id}}">{{$tag->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <div class="form-group form-group-default form-group-default-select2">
                                <label class="">Category</label>
                                <select class="full-width select2-hidden-accessible" name="category" data-placeholder="Select Category" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
                                    <option>Select</option>
                                    @foreach($categories as $cat)
                                    <option value="{{$cat->id}}" {{$cat->id == $post->cat_id ? "selected" : '-'}}>{{$cat->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-default form-group-default-select2">
                                <label class="">Author</label>
                                <select class="full-width select2-hidden-accessible" id="author_id" name="author_id" data-placeholder="Select Author" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
                                    <option>Select</option>
                                    @foreach($users as $user)
                                    <option value="{{$user->id}}" {{$user->id == $post->meta_author_id ? "selected" : '-'}}>{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-default form-group-default-select2">
                                <label class="">Section</label>
                                <select class="full-width select2-hidden-accessible" name="section" data-placeholder="Select Section" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
                                    <option value="">Select</option>
                                    <option value="1" {{$post->section == 1 ? "selected" : '-'}}>Header</option>
                                    <option value="2" {{$post->section == 2 ? "selected" : '-'}}>Project</option>
                                    <option value="3" {{$post->section == 3 ? "selected" : '-'}}>Tutorials</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="loader_container" id="card1">
                        <div class="loader"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mt-3 mt-md-0">
                <div class="card card_shadow p-3 border-0 rounded-0">
                    <div class="form-group">
                        <label for="image" class="small font-weight-bold text-dark">Feature Image</label>
                        <input type="file" class="form-control dropify" data-height="150" data-default-file="{{asset('images')}}/{{$post->image}}" name="image">
                    </div>
                    <div class="form-group form-group-default">
                        <label>Image ALT Name <span class="text-danger">*</span></label>
                        <input name="post_img_alt" value="{{$post->post_img_alt}}" type="text" class="form-control input-sm" placeholder="Image ALT Name">
                    </div>
                    <span class="text-muted small ml-1"> <i>For better image SEO</i> </span>
                    <div class="loader_container" id="card2">
                        <div class="loader"></div>
                    </div>
                </div>
            </div>
        </div>


        <div class="card mt-4 p-3 border-0 card_shadow rounded-0">
            <textarea name="description" class="editor" id="description" class="w-100">{{$post->description}}</textarea>
            <div class="loader_container" id="card3">
                <div class="loader"></div>
            </div>
        </div>

        <div class="row">
            <h4>2. <span class="text-primary">Post SEO Section</span> </h4>
            <div class="card  card_shadow p-3 border-0 rounded-0">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group form-group-default bg-light">
                            <label>Title</label>
                            <input type="text" value="{{$post->meta_title}}" id="meta_title" class="form-control input-sm" placeholder="Post Meta Title" disabled>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-group-default bg-light">
                            <label>Author</label>
                            <input type="text" value="{{$post->meta_author}}" id="authr_name" class="form-control input-sm" placeholder="Post Author Name" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-default required">
                    <label>Meta Tags</label>
                    <input class="tagsinput custom-tag-input" type="text" style="display: none;">
                    <div class="bootstrap-tagsinput" style="display:flex !important"> <input value="{{$post->meta_tags}}" name="meta_tags" id="meta_tags" size="2" type="text" class=""></div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group form-group-default">
                            <label>Description <span class="text-danger">*</span> </label>
                            <textarea cols="30" rows="10" name="meta_description" type="text" class="form-control" style="resize:none;height:80px" placeholder="Post Description">{{$post->meta_description}}</textarea>
                        </div>
                    </div>
                </div>

                <div class="loader_container" id="card4">
                    <div class="loader"></div>
                </div>

            </div>
        </div>

        <button type="submit" class="btn btn-primary p-2 mb-5 w-100"><i class="fas fa-check-circle mr-1"></i> Save</button>

    </form>
</div>

@endsection
@section('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/js/froala_editor.pkgd.min.js"></script>
<script>
    new FroalaEditor('.editor', {
        // Set the image upload parameter.
        imageUploadParam: 'image_param',

        // Set the image upload URL.
        imageUploadURL: '{{url("upload_post_imgs")}}',

        // Additional upload params.
        imageUploadParams: {
            id: 'my_editor'
        },

        // Set request type.
        imageUploadMethod: 'POST',

        // Set max image size to 5MB.
        imageMaxSize: 5 * 1024 * 1024,

        // Allow to upload PNG and JPG.
        imageAllowedTypes: ['jpeg', 'jpg', 'png'],

    });


    $('#editRecord').submit(function(e) {
        e.preventDefault();

        let post_id = $("#post_id").val();
        let form_data = new FormData(this);
        let meta_title = $("input[name='title']").val();
        form_data.append('meta_title', meta_title);

        let author_name = $("#author_id option:selected").text();
        form_data.append('meta_author', author_name);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{url('update_post')}}",
            type: 'POST',
            data: form_data,
            dataType: 'JSON',
            async:true,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend:function(data) {
                $("#card1").show();
                $("#card2").show();
                $("#card3").show();
                $("#card4").show();
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
                $("#card1").hide();
                $("#card2").hide();
                $("#card3").hide();
                $("#card4").hide();
            },
            error: function(e) {
                $("#card1").hide();
                $("#card2").hide();
                $("#card3").hide();
                $("#card4").hide();
            }
        });
    });

    $("#author_id").on('change', function() {
        $("#authr_name").val($("#author_id option:selected").text());
    });

    $("#title").keyup(function() {
        $("#meta_title").val($(this).val());
    });
    $('#tags').select2({});
    $('#tags').val(<?php echo $post_all_tags; ?>).trigger('change');
    $('.dropify').dropify();
    $("#meta_tags").tagsinput('items')

    setTimeout(() => {
        $("#card1").fadeOut(500);
        $("#card2").fadeOut(500);
        $("#card3").fadeOut(500);
        $("#card4").fadeOut(500);
    }, 4000);
</script>

@show