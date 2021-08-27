@extends('admin.layout.master')
@section('page_title','Manage widgets')
@section('appearance','active')
@section('widgets','active')
@section('container')

<style>
    .draggable {
        list-style: none;
        z-index: 9;
        cursor: pointer;
        margin: 0.5em;
        padding: 0.8em;
    }
    .ui-draggable-dragging {
        width: 100% !important;
    }

    #footer_div {
        min-height: 120px;
    }

    #footer_div ul {
        min-height: 80px !important;
    }

</style>

<div class="row mt-2 add_margin">
    <div class="container-fluid p-0">
        <div class="row">
            
            <div class="col-md-4 draggable-column">
                <ul class="p-0" id="drag-items">

                    <li class="draggable bg-light border" data-id="textWidget">
                        <div class="widget-handle" data-toggle="collapse" href="#textcollapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <p class="widget-name m-0">Text </p>
                        </div>
                        <div class="widget-content collapse" id="textcollapse">
                            <form method="POST" id="textWidgetForm" autocomplete="off" enctype="multipart/form-data" class="mt-2">
                                <input type="hidden" name="widget_id" value="textWidget">
                                <input type="hidden" name="widget_name" value="Text">
                                <div class="form-group form-group-default">
                                    <label> Name</label>
                                    <input id="name" name="name" type="text" class="form-control input-sm" placeholder="Name">
                                </div>
                                <div class="form-group form-group-default">
                                    <label>Content</label>
                                    <textarea cols="30" rows="10" id="content" name="content" type="text" class="form-control" placeholder="Your Content"></textarea>
                                </div>
                                <div class="widget-control-actions">
                                    <div class="float-left">
                                        <button class="btn btn-danger widget-control-delete">Delete</button>
                                    </div>
                                    <div class="float-right text-right">
                                        <button class="btn btn-primary widget_save">Save</button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                        </div>
                    </li>

                    <li class="draggable bg-light border" data-id="textWidget">
                        <div class="widget-handle" data-toggle="collapse" href="#menuCollapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <p class="widget-name m-0"> Menu </p>
                        </div>
                        <div class="widget-content collapse" id="menuCollapse">
                            <form method="POST" id="textWidgetForm" autocomplete="off" enctype="multipart/form-data" class="mt-2">
                                <input type="hidden" name="widget_id" value="textWidget">
                                <input type="hidden" name="widget_name" value="Text">
                                <div class="form-group form-group-default">
                                    <label> Name</label>
                                    <input id="name" name="name" type="text" class="form-control input-sm" placeholder="Name">
                                </div>
                                <div class="form-group form-group-default form-group-default-select2">
                                    <label class="">Menu</label>
                                    <select class="full-width select2-hidden-accessible" name="menu" data-placeholder="Select Menu" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
                                        <option>Select</option>
                                        @foreach($menus as $menu)
                                        <option value="{{$menu->id}}">{{$menu->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="widget-control-actions">
                                    <div class="float-left">
                                        <button class="btn btn-danger widget-control-delete">Delete</button>
                                    </div>
                                    <div class="float-right text-right">
                                        <button class="btn btn-primary widget_save">Save</button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                        </div>
                    </li>

                    <li class="draggable bg-light border" data-id="textWidget">
                        <div class="widget-handle" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <p class="widget-name m-0">Popular Post </p>
                        </div>
                        <div class="widget-content collapse" id="collapseExample">
                            <form method="POST" id="textWidgetForm" autocomplete="off" enctype="multipart/form-data" class="mt-2">
                                <input type="hidden" name="widget_id" value="textWidget">
                                <input type="hidden" name="widget_name" value="Text">
                                <div class="form-group form-group-default">
                                    <label> Name</label>
                                    <input id="name" name="name" type="text" class="form-control input-sm" placeholder="Name">
                                </div>
                                <div class="form-group form-group-default">
                                    <label>Popular Post</label>
                                    <input id="content" name="content" type="number" value="5" class="form-control input-sm" placeholder="No of Popular Post">
                                </div>
                                <div class="widget-control-actions">
                                    <div class="float-left">
                                        <button class="btn btn-danger widget-control-delete">Delete</button>
                                    </div>
                                    <div class="float-right text-right">
                                        <button class="btn btn-primary widget_save">Save</button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                        </div>
                    </li>

                    <li class="draggable bg-light border" data-id="textWidget">
                        <div class="widget-handle" data-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <p class="widget-name m-0">Categories </p>
                        </div>
                        <div class="widget-content collapse" id="collapseExample1">
                            <form method="POST" id="textWidgetForm" autocomplete="off" enctype="multipart/form-data" class="mt-2">
                                <input type="hidden" name="widget_id" value="textWidget">
                                <input type="hidden" name="widget_name" value="Text">
                                <div class="form-group form-group-default">
                                    <label> Name</label>
                                    <input id="name" name="name" type="text" class="form-control input-sm" placeholder="Name">
                                </div>
                                <div class="form-group form-group-default">
                                    <label>Categories</label>
                                    <input id="content" name="content" type="number" value="5" class="form-control input-sm" placeholder="No of Cateogies">
                                </div>
                                <div class="widget-control-actions">
                                    <div class="float-left">
                                        <button class="btn btn-danger widget-control-delete">Delete</button>
                                    </div>
                                    <div class="float-right text-right">
                                        <button class="btn btn-primary widget_save">Save</button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                        </div>
                    </li>
                    
                    <li class="draggable bg-light border" data-id="textWidget">
                        <div class="widget-handle" data-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <p class="widget-name m-0">Tags </p>
                        </div>
                        <div class="widget-content collapse" id="collapseExample3">
                            <form method="POST" id="textWidgetForm" autocomplete="off" enctype="multipart/form-data" class="mt-2">
                                <input type="hidden" name="widget_id" value="textWidget">
                                <input type="hidden" name="widget_name" value="Text">
                                <div class="form-group form-group-default">
                                    <label> Name</label>
                                    <input id="name" name="name" type="text" class="form-control input-sm" placeholder="Name">
                                </div>
                                <div class="form-group form-group-default">
                                    <label>Tags</label>
                                    <input id="content" name="content" type="number" value="5" class="form-control input-sm" placeholder="No of Tags">
                                </div>
                                <div class="widget-control-actions">
                                    <div class="float-left">
                                        <button class="btn btn-danger widget-control-delete">Delete</button>
                                    </div>
                                    <div class="float-right text-right">
                                        <button class="btn btn-primary widget_save">Save</button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                        </div>
                    </li>

                    <li class="draggable bg-light border" data-id="textWidget">
                        <div class="widget-handle" data-toggle="collapse" href="#collapseExample4" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <p class="widget-name m-0"> Newsletter </p>
                        </div>
                        <div class="widget-content collapse" id="collapseExample4">
                            <form method="POST" id="textWidgetForm" autocomplete="off" enctype="multipart/form-data" class="mt-2">
                                <input type="hidden" name="widget_id" value="textWidget">
                                <input type="hidden" name="widget_name" value="Text">
                                <div class="form-group form-group-default">
                                    <label> Name</label>
                                    <input id="name" name="name" type="text" class="form-control input-sm" placeholder="Name">
                                </div>
                                <div class="widget-control-actions">
                                    <div class="float-left">
                                        <button class="btn btn-danger widget-control-delete">Delete</button>
                                    </div>
                                    <div class="float-right text-right">
                                        <button class="btn btn-primary widget_save">Save</button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                        </div>
                    </li>

                </ul>
            </div>

            <div class="col-md-8">

                <div class="row">
                    <div class="col-md-6 droppable-column">

                        <div class="droppable-item">
                            <div class="card" id="footer_div">
                                <div class="card-header bg-light">Footer <span id="show"></span> </div>
                                <div class="card-body p-0">
                                    <ul class="sortable p-0 bg-white" id="drop-items">
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 droppable-column">

                        <div class="droppable-item">
                            <div class="card" id="footer_div">
                                <div class="card-header bg-light">Sidebar <span id="show"></span> </div>
                                <div class="card-body p-0">
                                    <ul class="sortable p-0 bg-white">

                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


            </div>

        </div>
    </div>
</div>



@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    $(document).ready(function() {


        $(".sortable").sortable({
        	connectWith: ".draggable",
            stop:function(event, ui) {
                console.log("ajax call");
            }  
        });

        $('.draggable').draggable({
            helper: "clone",
            connectToSortable: ".sortable",
        });

    });

    function saveWidget() {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            type: "POST",
            url: "{{url('save-widget')}}",
            data :form,
            dataType : 'json',
            success: function(data) {
                console.log(data, "a");
                if(data.status == 200 && data.success == true) {
                    notyf.success(data.message);
                }else{
                    notyf.error(data.message);
                }
                },
            error: function(e) {
                console.log(e);
            }
        });
    }
</script>
@show