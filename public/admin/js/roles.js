$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $("#addRecord").validate({
        rules: {
            name: {
                required: true
            },
        },
        submitHandler: function(form) {
            $.ajax({
                type: "POST",
                url: "roles",
                data: $("#addRecord").serialize(),
                beforeSend:function(data) {
                    $("#save").hide();
                    $("#process").show();
                },
                success: function(data) {
                    console.log(data, "a");
                    if ((data.status == 200) & (data.success == true)) {
                        notyf.success(data.message);
                        setTimeout(() => {
                            $("#addModal").modal("hide");
                            $("#addRecord")[0].reset();    
                        }, 1000);
                        $("#save").show();
                        $("#process").hide();
                        getAllRoles();
                    } else {
                        notyf.error(data.message);
                    }
                },
                error: function(e) {
                    console.log(e);
                    $("#save").show();
                    $("#process").hide();
                }
            });
        }
    });

    $("#updateRecord").validate({
        rules: {
            name: {
                required: true
            },
        },
        submitHandler: function(form) {
            var id = $("#id").val();
            $.ajax({
                type: "PUT",
                url: "roles/" + id,
                data: $("#updateRecord").serialize(),
                beforeSend:function(data) {
                    $("#save_up").hide();
                    $("#process_up").show();
                },
                success: function(data) {
                    console.log(data, "a");
                    if ((data.status == 200) & (data.success == true)) {
                        notyf.success(data.message);
                        setTimeout(() => {
                            $("#updateModal").modal("hide");  
                        }, 1000);
                        $("#save_up").show();
                        $("#process_up").hide();
                        getAllRoles();
                    } else {
                        notyf.error(data.message);
                    }
                },
                error: function(e) {
                    console.log(e);
                    $("#save_up").show();
                    $("#process_up").hide();
                }
            });
        }
    });

    getAllRoles()
    
});


function getAllRoles() {

    $.ajax({
        type: "GET",
        url: "roles",
        beforeSend:function(data) {
            $(".loader_container").show();
        },
        success: function(data) {
            console.log(data, "a");

            $("#counts").text(data.length);
            $('#roles_table').DataTable().destroy();
            $.fn.dataTable.ext.errMode = 'none';
            var tbl = $('#roles_table').DataTable({
                data: data,
                "pageLength":25,
                "bInfo": true,
                "paging": true,
                columns: [{
                    "data": null,
                    "defaultContent": ""
                },
                {
                    "render": function (data, type, full, meta) {
                        return moment(full.created_at).format('DD-MM-YYYY h:m:s');
                    }
                },
                {
                    "data" : "name",
                },
                {
                    "render": function (data, type, full, meta) {
                        return ` <div class="d-flex justify-content-center">
                            <button onclick="viewRecord(`+ full.id +`, '`+full.name+`')" type="button" class="btn btn-primary rounded" title="Edit"><i class="material-icons" style="font-size:15px">edit</i> Edit</button>
                            <button onclick="deleteRecord(`+full.id+`)" type="button" class="btn btn-danger ml-2 rounded text-white" title="Delete"><i class="material-icons" style="font-size:15px">delete</i> Delete</button>
                        </div>`
                    }
                },
                ],
            });

            tbl.on('order.dt search.dt', function () {
                tbl.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        },
        complete:function(data) {
            $(".loader_container").hide();
        },
        error: function(e) {
            console.log(e);
        }
    });
}


function viewRecord(id,name) {

    $("#updateModal").modal('show');
    $("#id").val(id)
    $("#name").val(name)
    $("#role_name").text(name)
}


function deleteRecord(id) {
    $.ajax({
        type: "DELETE",
        url: "roles/" + id,
        success: function(data) {
            if(data.status == 200 && data.success == true) {
                notyf.success(data.message);
                getAllRoles();
            }else{
                notyf.error(data.message);
            }           
        },
        error: function(e) {
            console.log(e);
        }
    });
}
