@extends('admin.layout.master')
@section('page_title','Manage Menu')
@section('appearance','active')
@section('menu','active')
@section('content')

@section('css')
<style type="text/css">

    /**
 * Nestable
 */

    .dd {
        position: relative;
        display: block;
        margin: 0;
        padding: 0;
        width: 100% !important;
        max-width: 600px;
        list-style: none;
        font-size: 13px;
        line-height: 20px;
    }

    .dd-list {
        display: block;
        position: relative;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .dd-list .dd-list {
        padding-left: 30px;
    }

    .dd-collapsed .dd-list {
        display: none;
    }

    .dd-item,
    .dd-empty,
    .dd-placeholder {
        display: block;
        position: relative;
        margin: 0;
        padding: 0;
        min-height: 20px;
        font-size: 13px;
        line-height: 28px;
    }

    .dd-handle {
        display: block;
        height: 38px;
        margin: 5px 0;
        padding: 5px 10px;
        color: #333;
        text-decoration: none;
        font-weight: bold;
        border: 1px solid #ccc;
        background: #fafafa;
        background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
        background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
        background: linear-gradient(top, #fafafa 0%, #eee 100%);
        -webkit-border-radius: 3px;
        border-radius: 3px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    .dd-handle:hover {
        color: #2ea8e5;
        background: #fff;
    }

    .dd-item>button {
        display: block;
        position: relative;
        cursor: move;
        float: left;
        width: 25px;
        height: 20px;
        margin: 10px 0;
        padding: 0;
        text-indent: 100%;
        white-space: nowrap;
        overflow: hidden;
        border: 0;
        background: transparent;
        font-size: 12px;
        line-height: 1;
        text-align: center;
        font-weight: bold;
    }

    .dd-item>button:before {
        content: '+';
        display: block;
        position: absolute;
        width: 100%;
        text-align: center;
        text-indent: 0;
    }

    .dd-item>button[data-action="collapse"]:before {
        content: '-';
    }

    .dd-placeholder,
    .dd-empty {
        margin: 5px 0;
        padding: 0;
        min-height: 30px;
        background: #f2fbff;
        border: 1px dashed #b6bcbf;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    .dd-empty {
        border: 1px dashed #bbb;
        min-height: 100px;
        background-color: #e5e5e5;
        background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
            -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
        background-image: -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
            -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
        background-image: linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
            linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
        background-size: 60px 60px;
        background-position: 0 0, 30px 30px;
    }

    .dd-dragel {
        position: absolute;
        pointer-events: none;
        z-index: 9999;
    }

    .dd-dragel>.dd-item .dd-handle {
        margin-top: 0;
    }

    .dd-dragel .dd-handle {
        -webkit-box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, .1);
        box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, .1);
    }

    /**
 * Nestable Extras
 */

    .nestable-lists {
        display: block;
        clear: both;
        padding: 30px 0;
        width: 100%;
        border: 0;
        border-top: 2px solid #ddd;
        border-bottom: 2px solid #ddd;
    }

    #nestable-menu {
        padding: 0;
        margin: 20px 0;
    }

    #nestable-output,
    #nestable2-output {
        width: 100%;
        height: 7em;
        font-size: 0.75em;
        line-height: 1.333333em;
        font-family: Consolas, monospace;
        padding: 5px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    #nestable2 .dd-handle {
        color: #fff;
        border: 1px solid #999;
        background: #bbb;
        background: -webkit-linear-gradient(top, #bbb 0%, #999 100%);
        background: -moz-linear-gradient(top, #bbb 0%, #999 100%);
        background: linear-gradient(top, #bbb 0%, #999 100%);
    }

    #nestable2 .dd-handle:hover {
        background: #bbb;
    }

    #nestable2 .dd-item>button:before {
        color: #fff;
    }

    @media only screen and (min-width: 700px) {

        .dd {
            float: left;
            width: 48%;
        }

        .dd+.dd {
            margin-left: 2%;
        }

    }

    .dd-hover>.dd-handle {
        background: #2ea8e5 !important;
    }

    /**
 * Nestable Draggable Handles
 */

    .dd3-content {
        display: block;
        height: 30px;
        margin: 5px 0;
        padding: 5px 10px 5px 40px;
        color: #333;
        text-decoration: none;
        font-weight: bold;
        border: 1px solid #ccc;
        background: #fafafa;
        background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
        background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
        background: linear-gradient(top, #fafafa 0%, #eee 100%);
        -webkit-border-radius: 3px;
        border-radius: 3px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    .dd3-content:hover {
        color: #2ea8e5;
        background: #fff;
    }

    .dd-dragel>.dd3-item>.dd3-content {
        margin: 0;
    }

    .dd3-item>button {
        margin-left: 30px;
    }

    .dd3-handle {
        position: absolute;
        margin: 0;
        left: 0;
        top: 0;
        cursor: pointer;
        width: 30px;
        text-indent: 100%;
        white-space: nowrap;
        overflow: hidden;
        border: 1px solid #aaa;
        background: #ddd;
        background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
        background: -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
        background: linear-gradient(top, #ddd 0%, #bbb 100%);
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .dd3-handle:before {
        content: '≡';
        display: block;
        position: absolute;
        left: 0;
        top: 3px;
        width: 100%;
        text-align: center;
        text-indent: 0;
        color: #fff;
        font-size: 20px;
        font-weight: normal;
    }

    .dd3-handle:hover {
        background: #ddd;
    }

    /**
 * Socialite
 */

    .socialite {
        display: block;
        float: left;
        height: 35px;
    }

    .menu-item-actions {
        float: left;
        display: inline-block;
        margin-top: 8px;
        margin-right: 12px;
        margin-left: 6px;
    }
    .menu-item-actions a{
        color:black;
    }
</style>
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
							<h3 class="content-header-title fw-bolder float-start mb-0">Menu Items </h3>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a>
									</li>
									<li class="breadcrumb-item"> Menu  Items</li>
								</ol>
							</div>
						</div>
                        <a href="{{url('menu-item')}}/{{$id}}" class="btn btn-primary"> <i data-feather='plus'></i> Menu Items</a>
					</div>
				</div>
			</div>
		</div>
		
	</div>


<div class="">
    <div class="container-fluid p-0">

        @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{session('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <input type="hidden" id="menu_id" value="{{$id}}">


        <div class="col-md-12 mt-2">

            @if($id)
            
                <div class="card p-1">
                    <div class="dd" id="nestable">
                        <ol class="dd-list">
                            @foreach($menuItems as $item)
                            <li class="dd-item" data-id="{{$item->id}}" data-position="{{$item->id}}">
                                <div class="menu-item-actions">
                                    <a href="{{url('edit-menu-item')}}/{{$item->id}}/{{$id}}">
                                        <i data-feather='edit-2'></i> </a>
                                    <i data-feather='trash' onclick="deleteMenuItem({{$item->id}})"></i>
                                </div>
                                <div class="dd-handle"> {{$item->name}} </div>
                                @if(count($item->childs))
                                @include('admin.menu.manage_child',['childs' => $item->childs])
                                @endif
                            </li>
                            @endforeach
                        </ol>
                    </div>
                </div>

                <button type="button" class="btn btn-primary saveMenuPosition">Save</button>


            @else
                <div class="alert alert-info" role="alert">
                    Please save the menu first to add menu items.
                </div>
            @endif

        </div>


        <input id="output" type="hidden">

    </div>
</div>

<!-- delete category Modal -->
<div class="modal fade stick-up shadow" id="deleteCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog border">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary"> Confirmation </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteMenuItem" method="GET" enctype="multipart/form-data">
                <div class="modal-body">
                    <p>Are you sure you want to delete?</p>

                    <input type="hidden" id="itemid" >

                </div>
                <div class="modal-footer bg-light p-3">

                    <button data-dismiss="modal" type="button" class="btn btn-secondary btn-cons btn-animated from-top">
                        <span>Cancel</span>
                        <span class="hidden-block"> <i class="fas fa-times"></i> </span>
                    </button>

                    <button type="submit" id="deleteCategory" class="btn btn-danger text-white btn-cons btn-animated from-top">
                        <span>Delete</span>
                        <span class="hidden-block"> <i class="fas fa-trash"></i> </span>
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>



@endsection
@section('js')
<script src="{{asset('admin/js/nestable.js')}}"></script>
<script>
    function deleteMenuItem (id) {
        var url = "{{url('delete-menu-item')}}/" +id;
        $("#deleteMenuItem").attr('action',url);
        $("#deleteCategoryModal").modal('show');
    }

    $(document).ready(function() {

        var menu_id = $("#menu_id").val();

        var arr = '';

        var updateOutput = function(e) {
            var list = e.length ? e : $(e.target),
                output = list.data('output');
            $("#output").val(list.nestable('serialize'));

            arr = list.nestable('serialize');

            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };

        // activate Nestable for list 1
        $('#nestable').nestable({
            group: 1
        }).on('change', updateOutput);


        // output initial serialised data
        updateOutput($('#nestable').data('output', $('#nestable-output')));

        $('#nestable-menu').on('click', function(e) {
            var target = $(e.target),
                action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });


        $('.saveMenuPosition').click(function() {
            sortMenuItems(arr, menu_id);
        });


    });


    function sortMenuItems(values, menu_id) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            type: "POST",
            url: "{{url('update-menu-item-position')}}",
            data: {
                data: values,
                menu_id: menu_id
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                if (data.status == 200 && data.success == true) {
                    notyf.success(data.message);
                } else {
                    notyf.error(data.message);
                }
            },
            error: function(e) {
                console.log(e);
            }
        });
    }
</script>
@endsection