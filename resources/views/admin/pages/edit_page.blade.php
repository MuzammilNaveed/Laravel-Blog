@extends('admin.layout.master')
@section('page_title','Edit Page')
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


<div class="">
    <ul class="breadcrumb p-l-0">
        <li class="breadcrumb-item"><a href="{{route('pages.index')}}">Page</a>
        </li>
        <li class="breadcrumb-item active">Edit Page
        </li>
    </ul>
</div>

<div class="" style="margin-bottom:30px">

    <form id="addRecord" enctype="multipart/form-data">

        <div class="row">
            <div class="col-12">
                <div class="card card_shadow p-3 border-0 rounded-0">
                    <input type="hidden" name="id" value="{{$page->id}}">
                    <div class="form-group form-group-default">
                        <label>Page Name</label>
                        <input name="title" id="title" name="title" value="{{$page->page_name}}" type="text" class="form-control input-sm" placeholder="Post Title">
                    </div>
                    <div class="loader_container" id="card1">
                        <div class="loader"></div>
                    </div>

                </div>
            </div>
        </div>


        <div class="card mt-2 p-3 border-0 card_shadow rounded-0">
            <textarea name="description" class="editor" id="description" class="w-100">{{$page->page_desc}}</textarea>
            <div class="loader_container" id="card3">
                <div class="loader"></div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-lg mb-5"><i class="fas fa-check-circle mr-1"></i> Save</button>

    </form>
</div>

@endsection
@section('scripts')
<script src="{{asset('admin/js/posts.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/js/froala_editor.pkgd.min.js"></script>

<script>
    new FroalaEditor('.editor', {
        // Set the image upload parameter.
        height: 250,
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

    $("#author_id").on('change', function() {
        $("#authr_name").val($("#author_id option:selected").text());
    });

    $("#title").keyup(function() {
        $("#meta_title").val($(this).val());
    });

    $('#tags').select2({});
    $('.category').select2({});
    $('.dropify').dropify();
    $("#meta_tags").tagsinput('items')

    $('#addRecord').submit(function(e) {
        e.preventDefault();

        let form_data = new FormData(this);
        let meta_title = $("input[name='title']").val();
        form_data.append('meta_title', meta_title);

        let author_name = $("#author_id option:selected").text();
        form_data.append('meta_author', author_name);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{url("save_edit_page")}}',
            type: 'POST',
            data: form_data,
            dataType: 'JSON',
            async:true,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend:function(data) {
                $("#card1").show();
                $("#card3").show();
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
                $("#card3").hide();
            },
            error: function(e) {
                console.log(e)
                $("#card1").hide();
                $("#card3").hide();
            }

        });

    });
</script>
@show