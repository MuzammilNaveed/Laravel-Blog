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
                    $("#add_loader").show();
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
                complete: function(data) {
                    $("#add_loader").hide();
                },
                error: function(e) {
                    console.log(e);
                    $("#add_loader").hide();
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
                    $("#edit_loader").show();
                },
                success: function(data) {
                    console.log(data, "a");
                    if ((data.status == 200) & (data.success == true)) {
                        notyf.success(data.message);
                        $("#updateModal").modal("hide");  
                        
                        let date = new Date();
                        let from = moment(date).startOf('month').format('YYYY-MM-DD');
                        let to = moment(date).endOf('month').format('YYYY-MM-DD');
                        getAllTags(from,to);
                    } else {
                        notyf.error(data.message);
                    }
                },
                complete: function(data) {
                    $("#edit_loader").hide();
                },
                error: function(e) {
                    console.log(e);
                    $("#edit_loader").hide();
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
                    "render": function (data, type, full, meta) {
                        return full.name != null ? full.name : '--';
                    }
                },
                {
                    "render": function (data, type, full, meta) {
                        return full.slug != null ? full.slug : '--';
                    }
                },
                {
                    "render": function (data, type, full, meta) {
                        let update_btn = `
                            <button onclick="viewRecord(`+ full.id +`, '`+full.name+`')" type="button" 
                                class="btn btn-primary text-white btn_cirlce" data-toggle="tooltip" data-placement="top" title="Edit" >
                                <i class="fas fa-pencil-alt"></i> 
                            </button>`;
                        
                        let del_btn = `<button onclick="deleteRecord(`+full.id+`)" type="button" 
                                class="btn btn-danger text-white ml-2 text-white btn_cirlce" data-toggle="tooltip" data-placement="top" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>`;

                        var update = $("#update").text();
                        var del = $("#delete").text();
                        if(update != "" && del != "") {
                            if(update == 1 && del == 1) {
                                return update_btn + del_btn
                            } else if(update == 1 && del == 0) {
                                return update_btn;
                            }else if(update == 0 && del == 1) {
                                return del_btn;
                            }
                        }
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
            $('[data-toggle="tooltip"]').tooltip();
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
