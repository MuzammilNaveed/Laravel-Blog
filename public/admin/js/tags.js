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
                url: "tags",
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
                        let date = new Date();
                        let from = moment(date).startOf('month').format('YYYY-MM-DD');
                        let to = moment(date).endOf('month').format('YYYY-MM-DD');
                        getAllTags(from,to);
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
                url: "tags/" + id,
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
                        let date = new Date();
                        let from = moment(date).startOf('month').format('YYYY-MM-DD');
                        let to = moment(date).endOf('month').format('YYYY-MM-DD');
                        getAllTags(from,to);
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


    getAllTags()
    
});


function getAllTags() {    
    $.ajax({
        type: "GET",
        url: "tags",
        dataType:'json',
        beforeSend:function(data) {
            $(".loader_container").show();
        },
        success: function(data) {

            $("#counts").text(data.length);
            $('#tag_table').DataTable().destroy();
            $.fn.dataTable.ext.errMode = 'none';
            var tbl = $('#tag_table').DataTable({
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
                    "data" : "slug",
                },
                {
                    "render": function (data, type, full, meta) {
                        return ` <div class="d-flex justify-content-center">
                            <button onclick="viewRecord(`+ full.id +`, '`+full.name+`')" type="button" class="btn btn-primary rounded" title="Edit">
                            <i class="material-icons" style="font-size:15px">edit</i> Edit </button>
                            <button onclick="deleteRecord(`+full.id+`)" type="button" class="btn btn-danger text-white ml-2 rounded" title="Delete">
                            <i class="material-icons" style="font-size:15px">delete</i> Delete</button>
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
    $("#id").val(id);
    $("#name").val(name);
    $("#tagname").text(name);
}


function deleteRecord(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          
        $.ajax({
            type: "DELETE",
            url: "tags/" + id,
            success: function(data) {
    
                if ((data.status == 200) & (data.success == true)) {
                    getAllTags();
                    Swal.fire(
                        'Deleted!',
                        data.message,
                        'success'
                    )
                } else {
                    Swal.fire(
                        'Cancelled!',
                        data.message,
                        'error'
                    )
                }
    
            },
            error: function(e) {
                console.log(e);
            }
        });
        }
      })
}
