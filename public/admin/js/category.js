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

    let date = new Date();
    let from = moment(date)
        .startOf("month")
        .format("YYYY-MM-DD");
    let to = moment(date)
        .endOf("month")
        .format("YYYY-MM-DD");

    getAllCategories(from, to);
});

function getAllCategories(from, to) {
    $.ajax({
        type: "GET",
        url: categories,
        data: { from: from, to: to },
        beforeSend: function(data) {
            $(".loader_container").show();
        },
        success: function(data) {
            $("#counts").text(data.length);

            $("#from_date").text(from);
            $("#to_date").text(to);

            $("#showRecord")
                .DataTable()
                .destroy();
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
                        render: function(data, type, full, meta) {
                            return moment(full.created_at).format("DD-MM-YYYY");
                        }
                    },
                    {
                        data: "name"
                    },
                    {
                        data: "description"
                    },
                    {
                        render: function(data, type, full, meta) {
                            return (
                                ` <div class="d-flex justify-content-center">
                            <button onclick="viewRecord(` +
                                full.id +
                                `, '` +
                                full.name +
                                `','` +
                                full.description +
                                `')" type="button" class="btn btn-primary card_shadow round">
                            <i class="material-icons" style="font-size:15px">edit</i> Edit</button>
                            <button  onclick="deleteRecord(` +
                                full.id +
                                `)" type="button" class="btn btn-danger ml-2 card_shadow round">
                            <i class="material-icons" style="font-size:15px">delete</i> Delete</button>
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
                        let date = new Date();
                        let from = moment(date)
                            .startOf("month")
                            .format("YYYY-MM-DD");
                        let to = moment(date)
                            .endOf("month")
                            .format("YYYY-MM-DD");

                        Swal.fire("Deleted!", data.message, "success");
                        getAllCategories(from, to);
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

function filterData(value) {
    var today = new Date();
    switch (value) {
        case "current_month":
            var from_date1 = moment(today)
                .startOf("month")
                .format("YYYY-MM-DD");
            var too_date1 = moment(today)
                .endOf("month")
                .format("YYYY-MM-DD");
            getAllCategories(from_date1, too_date1);
            $("#date_range_filter").attr("style", "display:none !important");
            break;
        case "previous_month":
            var from_date = moment(today)
                .subtract(1, "months")
                .startOf("month")
                .format("YYYY-MM-DD");
            var too_date = moment(today)
                .subtract(1, "months")
                .endOf("month")
                .format("YYYY-MM-DD");
            getAllCategories(from_date, too_date);
            $("#date_range_filter").attr("style", "display:none !important");
            break;
        case "all_time":
            let to_date = moment(today).format("YYYY-MM-DD");
            getAllCategories("2000-01-01", to_date);
            $("#date_range_filter").attr("style", "display:none !important");
            break;
        case "date_range":
            $("#date_range_filter").css("display", "block");
            break;
    }
}
function getDateWiseData() {
    let from = $("#from").val();
    let to = $("#to").val();
    getAllCategories(from, to);
}
