@extends('admin.layout.master')
@section('page_title','Manage widgets')
@section('appearance','active')
@section('widget','active')
@section('content')

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

<!-- add tag modal -->
<div class="modal fade slide-right" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> <span class="text-muted small">Add</span> <span class="text-primary">Widget</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addRecord">
            <div class="row mt-3">
                <div class="form-check form-check-inline complete">
                    <input type="radio" name="state" id="footerCheckbox" checked="checked">
                    <label for="footerCheckbox"> Footer </label>
                </div>
                <div class="form-check form-check-inline complete">
                    <input type="radio" name="state" id="sidebarCheckbox" value="">
                    <label for="sidebarCheckbox"> Sidebar </label>
                </div>
            </div>
            
            <div class="row">
                <div class="form-group form-group-default form-group-default-select2">
                    <label class="">Section</label>
                    <select class="full-width select2-hidden-accessible" onchange="selectWidget(this.value)" id="widget" data-placeholder="Select Section" data-init-plugin="select2" tabindex="-1" aria-hidden="true">
                        <option value="">Select Widget</option>
                        <option value="textWidget">Text</option>
                        <option value="menuWidget">Menu</option>
                        <option value="popularPostWidget">Popular Posts</option>
                        <option value="categoryWidget">Categories</option>
                        <option value="tagWidget">Tags</option>
                        <option value="newsletterWidget">Newsletter</option>
                    </select>
                </div>
            </div>


            <div class="row" id="show">
            </div>
        
          <div class="modal-footer pr-0">
            <button id="add-app" type="submit" class="btn btn-primary  btn-cons"> Save</button>
            <button aria-label="" type="button" class="btn btn-cons" data-dismiss="modal"> Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="row mt-2 add_margin">
    <div class="container-fluid p-0">
        <button class="btn btn-primary btn-lg" onclick="openModal()" style="float:right"> <i class="fas fa-plus-circle"></i> Add Widget</button> <br>
        <div class="row mt-3">
            
            <div class="col-md-10">

                <div class="row">
                    <div class="col-md-6 droppable-column">

                        <div class="droppable-item">
                            <div class="card" id="footer_div">
                                <div class="card-header bg-light"> <strong>Footer</strong> </div>
                                <div class="card-body p-0">
                                    <ul class="sortable p-0 bg-white p-2" id="footer">
                                    </ul>
                                </div>
                            </div>
                        </div> 

                    </div>
                    <div class="col-md-6 droppable-column">

                        <div class="droppable-item">
                            <div class="card" id="footer_div">
                                <div class="card-header bg-light"> <strong>Sidebar</strong>  </div>
                                <div class="card-body p-0">
                                    <ul class="sortable p-0 bg-white p-2" id="sidebar">
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

<script>
    var menus =  {!! json_encode($menus) !!};

    $(document).ready(function() { 

        $('#addRecord').submit(function(e) {
            e.preventDefault();

            var type = '';
            var content = '';

            if( $("#footerCheckbox").is(":checked")) {
                type = 'footer';
            }

            if( $("#sidebarCheckbox").prop("checked")) {
                type = 'sidebar';
            }

            var widget = $("#widget").val();
            var  widgetText = $("#widget option:selected").text();

            var name = $("#name").val();
            content = $(".contents").val();

            var form = {
                type: type,
                widget_id: widget,
                widget_name : widgetText,
                name : name,
                content:content,
            }

            $.ajax({
                headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")},
                type: "POST",
                url: "{{url('save-widget')}}",
                data :form,
                dataType : 'json',
                success: function(data) {
                    console.log(data, "a");
                    if(data.status == 200 && data.success == true) {
                        notyf.success(data.message);
                        getAllWidgets();

                        $("#addModal").modal('hide');
                    }else{
                        notyf.error(data.message);
                    }
                    },
                error: function(e) {
                    console.log(e);
                }
            });


        });

        getAllWidgets();

        $(".sortable").sortable({
        	connectWith: ".draggable",
            stop:function(event, ui) {

                let childrens = $(this)[0].children;
                var position_arr = [];

                $.each(childrens, function(index){
                    let widget_id =  $(this).attr('data-wid');
                    let type =  $(this).attr('data-type');
                    position_arr.push( {"widget_id" : widget_id , "position" : index, "type" : type});                   
                });

                var form_data = {"positions": JSON.stringify(position_arr), "type" : "position_update"};

                console.log(form_data , "asd");
                saveWidget(form_data);
            }  

        });

    });

    function openModal() {
        $("#addModal").modal('show');
        $("#widget").val(" ").trigger('change');
    }

    function selectWidget(value) {
        var html = ``;
        var heading = '';
        var name = `
            <div class="form-group form-group-default">
                <label> Name</label>
                <input id="name" name="name" type="text" class="form-control input-sm" placeholder="Name">
            </div>`;
   

        if( value == 'textWidget') {
            html = `
            <h5> <strong> Text Widget </strong> </h5>
            `+ name +`
            <div class="form-group form-group-default">
                <label>Content</label>
                <textarea cols="30" rows="10" type="text" class="form-control contents"  placeholder="Your Content"></textarea>
              </div>
            `;
        }

        if( value == 'menuWidget') {

            var options = ``;
            for(var i=0; i < menus.length; i++) {
                options += `<option value="`+ menus[i].id +`">`+menus[i].name+`</option>`;
            }
            

            html = `
            <h5> <strong> Menu Widget </strong> </h5>
            `+ name +`
            <div class="form-group w-100">
                <select id="menu_id" class="form-control contents">
                    `+options+`
                </select>
            </div>
            `;
            
            
        }

        if( value == 'popularPostWidget') {
            heading = 'Popular Post';
            html = `
            <h5> <strong> Menu Widget </strong> </h5>
            `+ name +`
            <div class="form-group form-group-default">
                <label> No of Popular Posts</label>
                <input id="name" name="name" type="number" class="form-control contents input-sm" placeholder="">
            </div>
            `;
        }

        if( value == 'categoryWidget') {
            heading = `Categories`;
            html = `
            <h5> <strong> Category Widget </strong> </h5>
            `+ name +`
            <div class="form-group form-group-default">
                <label> No of Categories</label>
                <input id="name" name="name" type="number" class="form-control contents input-sm" placeholder="">
            </div>`;
        }

        if( value == 'tagWidget') {
            heading = `Tag`;
            html = `
            <h5> <strong> Tag Widget </strong> </h5>
            `+ name +`
            <div class="form-group form-group-default">
                <label> No of Tags</label>
                <input id="name" name="name" type="number" class="form-control contents input-sm" placeholder="">
            </div>`;
        }

        if(value == 'newsletterWidget') {
            html = `
            `+ name +`
            `;
        }

        if( value == 'menuWidget') {
           

        }

        $("#show").html(html);


    }

    function saveWidget(form) {
        $.ajax({
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")},
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
  

    function getAllWidgets() {
        $.ajax({
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")},
            type: "GET",
            url: "{{url('get-widget')}}",
            dataType : 'json',
            success: function(data) {
                console.log(data, "a");

                var footerbar = ``;
                var sidebar = ``;

                $.each(data, function( index, value ) {

                    if(value.type == "footer") {

                        footerbar +=`
                            <li class="draggable bg-light border mt-2" data-id="`+value.widget_id+`" data-wid="`+value.id+`" data-type="`+value.type+`">
                                <div class="widget-handle" data-toggle="collapse" href="#`+value.type+`_`+value.id+`" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    <p class="widget-name m-0"> `+value.widget_name+`</p>
                                </div>
                                <div class="widget-content collapse" id="`+value.type+`_`+value.id+`">
                                    <form method="POST" id="`+value.widget_id+`Form" autocomplete="off" enctype="multipart/form-data" class="mt-2">
                                        <input type="hidden" name="widget_id" value="newletterWidget">
                                        <input type="hidden" name="widget_name" value="`+value.widget_name +`">
                                        <div class="form-group form-group-default">
                                            <label> Name</label>
                                            <input id="name" name="name" type="text" value="`+(value.name != null ? value.name : '')+`" class="form-control input-sm" placeholder="Name">
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Content</label>
                                            <textarea cols="30" rows="10" id="content" name="content" type="text" class="form-control" placeholder="Your Content">`+(value.content!= null ? value.content : '')+`</textarea>
                                        </div>
                                        <div class="widget-control-actions">
                                            <div class="float-left">
                                                <button type="button" onclick="deleteWidget(`+value.id+`)" class="btn btn-danger widget-control-delete">Delete</button>
                                            </div>
                                            <div class="float-right text-right">
                                                <button class="btn btn-primary widget_save">Save</button>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </form>
                                </div>
                            </li>`;
                    }else{

                        sidebar +=`
                            <li class="draggable bg-light border mt-2" data-id="`+value.widget_id+`" data-wid="`+value.id+`" data-type="`+value.type+`">
                                <div class="widget-handle" data-toggle="collapse" href="#`+value.type+`_`+value.id+`" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    <p class="widget-name m-0"> `+value.widget_name+`</p>
                                </div>
                                <div class="widget-content collapse" id="`+value.type+`_`+value.id+`">
                                    <form method="POST" id="`+value.widget_id+`Form" autocomplete="off" enctype="multipart/form-data" class="mt-2">
                                        <input type="hidden" name="widget_id" value="newletterWidget">
                                        <input type="hidden" name="widget_name" value="`+value.widget_name +`">
                                        <div class="form-group form-group-default">
                                            <label> Name</label>
                                            <input id="name" name="name" type="text" value="`+(value.name != null ? value.name : '')+`" class="form-control input-sm" placeholder="Name">
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Content</label>
                                            <textarea cols="30" rows="10" id="content" name="content" type="text" class="form-control" placeholder="Your Content">`+(value.content!= null ? value.content : '')+`</textarea>
                                        </div>
                                        <div class="widget-control-actions">
                                            <div class="float-left">
                                                <button type="button" onclick="deleteWidget(`+value.id+`)" class="btn btn-danger widget-control-delete">Delete</button>
                                            </div>
                                            <div class="float-right text-right">
                                                <button class="btn btn-primary widget_save">Save</button>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </form>
                                </div>
                            </li>`;
                    }
                });

                $('#footer').html(footerbar);
                $('#sidebar').html(sidebar);

            },
            error: function(e) {
                console.log(e);
            }
        });
    }

    function deleteWidget(id) {

        $.ajax({
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")},
            type: "POST",
            url: "{{url('delete-widget')}}",
            data :{id:id},
            dataType : 'json',
            success: function(data) {
                console.log(data, "a");
                if(data.status == 200 && data.success == true) {
                    notyf.success(data.message);
                    getAllWidgets();
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