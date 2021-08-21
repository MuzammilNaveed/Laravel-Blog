@extends('admin.layout.master')
@section('page_title','Add Post')
@section('pages','active')
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
        <li class="breadcrumb-item active">Add Page
        </li>
    </ul>
</div>

<div class="mb-5">

    <form id="addRecord" enctype="multipart/form-data">

        <div class="card card_shadow p-3 border-0 rounded-0">

            <div class="row">
                <div class="col-12">
                    <div class="form-group form-group-default">
                        <label>Page Name</label>
                        <input id="page_name" name="page_name" type="text" class="form-control input-sm" placeholder="Page Name" required>
                    </div>
                </div>
            </div>

            <textarea name="page_desc" class="editor" id="description" class="w-100" required></textarea>

            <div class="custom-control custom-checkbox mt-2">
                <input type="checkbox" class="custom-control-input" id="enabled">
                <label class="custom-control-label" for="enabled">is Enabled</label>
            </div>

            <button type="submit" class="btn btn-primary mt-4"><i class="fas fa-check-circle mr-1"></i> Save</button>
        </div>

    </form>
</div>

@endsection
@section('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/js/froala_editor.pkgd.min.js"></script>

<script>
    FroalaEditor.DefineIcon('my_dropdown', {NAME: 'cog', SVG_KEY: 'cogs'});
    FroalaEditor.RegisterCommand('my_dropdown', {
        title: 'Advanced options',
        type: 'dropdown',
        focus: false,
        undo: false,
        refreshAfterCallback: true,
        options: {
        'v1': 'Option 1',
        'v2': 'Option 2'
        },
        callback: function (cmd, val) {
        console.log (val);
        },
        // Callback on refresh.
        refresh: function ($btn) {
        console.log ('do refresh');
        },
        // Callback on dropdown show.
        refreshOnShow: function ($btn, $dropdown) {
        console.log ('do refresh when show');
        }
    });

    
    new FroalaEditor('.editor', {

        // toolbarButtons: ['bold', 'italic', 'underline', 'strikeThrough','subscript', 'superscript',
        // 'fontFamily','fontSize','textColor','backgroundColor','inlineClass',
        // 'inlineStyle','clearFormatting','my_dropdown','alignLeft', 'alignCenter', 'formatOLSimple', 'alignRight', 'alignJustify', 'formatOL', 'formatUL',
        //  'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent', 'quote','insertLink', 'insertImage', 
        //  'insertTable', 'emoticons', 'fontAwesome', 'specialCharacters', 'embedly', 'insertFile', 'insertHR','undo', 'redo', 'fullscreen', 'print', 'getPDF', 'spellChecker', 'selectAll', 'html', 'help'],
        moreText: {
        // List of buttons used in the  group.
        buttons: ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'clearFormatting'],

        // Alignment of the group in the toolbar.
        align: 'left',

        // By default, 3 buttons are shown in the main toolbar. The rest of them are available when using the more button.
        buttonsVisible: 3
        },


        moreParagraph: {
        buttons: ['alignLeft', 'alignCenter', 'formatOLSimple', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent', 'quote'],
        align: 'left',
        buttonsVisible: 3
        },

        moreRich: {
        buttons: ['insertLink', 'insertImage', 'insertVideo', 'insertTable', 'emoticons', 'fontAwesome', 'specialCharacters', 'embedly', 'insertFile', 'insertHR'],
        align: 'left',
        buttonsVisible: 3
        },

        moreMisc: {
        buttons: ['undo', 'redo', 'fullscreen', 'print', 'getPDF', 'spellChecker', 'selectAll', 'html', 'help'],
        align: 'right',
        buttonsVisible: 2
        },

        height: 200,
        imageUploadParam: 'image_param',
        imageUploadURL: '{{url("upload_post_imgs")}}',
        imageUploadParams: { id: 'my_editor'},
        imageUploadMethod: 'POST',
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

    $('#addRecord').submit(function(e) {
        e.preventDefault();
        
        let form_data = new FormData(this);

        var status = 0;

        if( $("#enabled").is(":checked") ) {
            form_data.append('status',1);
        }else{
            form_data.append('status',0);
        }

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{url("insert_page_data")}}',
            type: 'POST',
            data: form_data,
            dataType: 'JSON',
            async:true,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend:function(data) {
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
            },
            error: function(e) {
                console.log(e);
            }
        });
    });
</script>
@show