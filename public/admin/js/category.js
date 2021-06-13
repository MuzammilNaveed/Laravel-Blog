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
            description: {
                required: true
            }
        },
        submitHandler: function(form) {
            $.ajax({
                type: "POST",
                url: categories,
                data: $("#addRecord").serialize(),
                beforeSend: function(data) {
                    $("#save").hide();
                    $("#process").show();
                },
                success: function(data) {
                    console.log(data, "a");
                    if ((data.status == 200) & (data.success == true)) {
                        $("#addRecord")[0].reset();
                        setTimeout(() => {
                            $("#addRecordModal").modal("hide");
                        }, 1000);
                        let date = new Date();
                        let from = moment(date)
                            .startOf("month")
                            .format("YYYY-MM-DD");
                        let to = moment(date)
                            .endOf("month")
                            .format("YYYY-MM-DD");

                        getAllCategories(from, to);
                        notyf.success(data.message);
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
            description: {
                required: true
            }
        },
        submitHandler: function(form) {
            var id = $("#id").val();
            $.ajax({
                type: "PUT",
                url: categories + "/" + id,
                data: $("#updateRecord").serialize(),
                beforeSend: function(data) {
                    $("#save_up").hide();
                    $("#process_up").show();
                },
                success: function(data) {
                    console.log(data, "a");
                    if (data.status == 200 && data.success == true) {
                        $("#updateModal").modal("hide");
                        let date = new Date();
                        let from = moment(date)
                            .startOf("month")
                            .format("YYYY-MM-DD");
                        let to = moment(date)
                            .endOf("month")
                            .format("YYYY-MM-DD");

                        getAllCategories(from, to);
                        notyf.success(data.message);
                    } else {
                        notyf.erro(data.message);
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


    getAllCategories();
});

function getAllCategories() {
    $.ajax({
        type: "GET",
        url: categories,
        beforeSend: function(data) {
            $(".loader_container").show();
        },
        success: function(data) {
            $("#counts").text(data.length);

            $("#showRecord").DataTable().destroy();
            $.fn.dataTable.ext.errMode = "none";
            var tbl = $("#showRecord").DataTable({
                data: data,
                pageLength: 25,
                bInfo: true,
                paging: true,
                columns: [
                    {
                        data: null,
                        defaultContent: ""
                    },
                    {
                        "render": function(data, type, full, meta) {
                            return moment(full.created_at).format("DD-MM-YYYY");
                        }
                    },
                    {
                        "render": function(data, type, full, meta) {
                            return full.name != null ? full.name : '-';
                        }
                    },
                    {
                        "className" : "small text-center",
                        "render": function(data, type, full, meta) {
                            let post_count =  full.post_count != null ? full.post_count : '-';
                            let cat_name = full.name != null ? full.name : '-';
                            return `<a href="#" onclick="showPosts(`+full.id+`,'`+cat_name+`')">`+post_count+`</a>`;
                        }
                    },
                    {
                        "render": function(data, type, full, meta) {
                            return full.description != null ? full.description.substring(0,30) + "...." : '-';
                        }
                    },
                    {
                        "render": function(data, type, full, meta) {
                            return (
                                ` <div class="d-flex justify-content-center">
                                    <button onclick="viewRecord(`+full.id + `, '` + full.name + `','` + full.description +`')" 
                                        type="button" class="btn btn-primary text-white btn_cirlce">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>

                                    <button  onclick="deleteRecord(`+ full.id + `)" type="button" 
                                        class="btn btn-danger ml-2 text-white btn_cirlce">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>`
                            );
                        }
                    }
                ]
            });

            tbl.on("order.dt search.dt", function() {
                tbl.column(0, {
                    search: "applied",
                    order: "applied"
                })
                    .nodes()
                    .each(function(cell, i) {
                        cell.innerHTML = i + 1;
                    });
            }).draw();
        },
        complete: function(data) {
            $(".loader_container").hide();
        },
        error: function(e) {
            console.log(e);
        }
    });
}

function viewRecord(id, name, description) {
    $("#updateModal").modal("show");
    $("#id").val(id);
    $("#name").val(name);
    $("#description").val(description);

    $("#catname").text(name);
}

function deleteRecord(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then(result => {
        if (result.isConfirmed) {
            $.ajax({
                type: "DELETE",
                url: categories + "/" + id,
                success: function(data) {
                    if (data.status == 200 && data.success == true) {
                        Swal.fire("Deleted!", data.message, "success");
                        getAllCategories();
                    } else {
                        Swal.fire("Cancelled!", data.message, "error");
                    }
                },
                error: function(e) {
                    console.log(e);
                }
            });
        }
    });
}


function showPosts(id,name) {

    $("#categoryname").text(name);
    $("#postViewModal").modal('show');

    $.ajax({
        type: "POST",
        url: category_posts,
        data: {id:id},
        dataType:'json',
        beforeSend: function(data) {
            $("#cat_post_loader").show();
        },
        success: function(data) {
            console.log(data);

            let html = ``;
            let index = 1;
            for(var i = 0; i < data.length; i ++) {

                html +=`
                    <li style="list-style:none"><strong>`+index+`. </strong> <a href="`+view_post+`/`+data[i].id+`">`+data[i].title+`</a></li>
                `;
                index++;
            }

            $("#category_post").html(html);
        },
        complete: function(data) {
            $("#cat_post_loader").hide();
        },
        error: function(e) {
            console.log(e);
        }
    });

}