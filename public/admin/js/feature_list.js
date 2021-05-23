$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $("#roles").select2({
        placeholder: "Select",
        allowClear: true
    });
    $("#edit_roles").select2({
        placeholder: "Select",
        allowClear: true
    });


    $("#menu").click(function() {
        $("#toggle_title_field").css("display", "none");
        $("#route-title").css("display", "block");
    });

    $("#toggle_menu").click(function() {
        $("#toggle_title_field").css("display", "block");
        $("#route-title").css("display", "none");
    });

    // for add record 
    $("#addFeatureForm").submit(function(e) {
        e.preventDefault();

        var menu_route = $("#route").val();

        var form_data = new FormData(this);
        var action = $(this).attr('action');
        var method = $(this).attr('method');
        var menu_routes = "NULL";

        var role_id = "";

        $("#add_roles").each(function() {
            role_id += $(this).val() + ",";
        });
        form_data.append("role_id",role_id.replace(/,\s*$/, ""));

        if ($("#is_active").is(":checked")) {
            form_data.append("is_active", 1);
        }

        if ($("#menu").is(":checked")) {
            form_data.append("menu_routes",menu_route);
            form_data.append("feature_type", 1);
        }else{
            form_data.append("feature_type", 2);
            form_data.append("menu_routes",menu_routes);
        }

        $.ajax({
            type: method,
            url:action,
            data: form_data,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data);
                $('#addFeatureModal').modal('hide');
                $("#addFeatureForm")[0].reset();
                get_all_feature_list();

                $("#add_roles").val(" ");
            },
            error: function(e) {
                console.log(e);
            }
        });
    });

    // for update record
    $("#editFeatureForm").submit(function(e) {
        e.preventDefault();

        var menu_route = $("#edit_route").val();
        var form_data = new FormData(this);
        var action = $(this).attr('action');
        var method = $(this).attr('method');
        var menu_routes = "NULL";

        var role_id = "";

        $("#edit_roles").each(function() {
            role_id += $(this).val() + ",";
        });
        form_data.append("role_id",role_id.replace(/,\s*$/, ""));

        if ($("#edit_is_active").is(":checked")) {
            form_data.append("is_active", 1);
        }else{
            form_data.append("is_active", 0);
        }

        if ($("#flexRadioDefault4").is(":checked")) {
            form_data.append("menu_routes",menu_route);
            form_data.append("feature_type", 1);
        }else{
            form_data.append("feature_type", 2);
            form_data.append("menu_routes",menu_routes);
        }

        $.ajax({
            type: method,
            url:action,
            data: form_data,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data);
                $('#editFeatureModal').modal('hide');
                get_all_feature_list();
            },
            error: function(e) {
                console.log(e);
            }
        });
    });

    get_all_feature_list();
});

function get_all_feature_list() {
    $.ajax({
        type: "GET",
        url: feature_list,
        dataType: "json",
        beforeSend: function(data) {
            $(".loader_container").show();
        },
        success: function(data) {
            console.log(data, "feature list");

            var root = `<option value='0'>Root</option>`;
            var option = ``;

            data.forEach(element => {
                option += `<option value='`+element.id+`'>`+element.title+`</option>`;
            });

            $("#parent_id").html(root + option);
            $("#edit_parent_id").html(root + option);

            $('#showRecord').DataTable().destroy();
            $.fn.dataTable.ext.errMode = 'none';
            var tbl = $('#showRecord').DataTable({
                data: data,
                "pageLength":25,
                "bInfo": true,
                "paging": true,
                columns: [{
                    "data": null,
                    "defaultContent": ""
                },
                {
                    "data" : "title",
                },
                {
                    "data" : "route",
                },
                {
                    "render": function (data, type, full, meta) {
                        let active = `<span class="badge bg-success text-white">Active</span>`;
                        let in_active = `<span class="badge bg-danger text-white">In-Active</span>`;
                        return full.is_active == 1 ? active : in_active;
                    }
                },
                {
                     "render": function (data, type, full, meta) {
                        let roles = full.roles != null ? full.roles: '-';
                        var keys = [];
                        keys = Object.values(roles);
                        var x = keys.toString();
                        return x;
                    }
                },
                {
                    "data" : "sequence",
                },
                {
                    "render": function (data, type, full, meta) {
                        return `
                        <div class="d-flex justify-content-center">
                            <button data-toggle="tooltip" data-placement="top" title="Edit Feature"  onclick="showFeature(` + full.id + `)" class="btn btn-warning" style="border-radius: 100%; padding: 8px 10px;">
                            <i class="material-icons" style="font-size:15px">edit</i></button></button>
                        </div>
                        `;
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
        complete: function(data) {
            $(".loader_container").hide();
            
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        },
        error: function(e) {
            console.log(e);
        }
    });
}

function showFeature(id) {
    $("#editFeatureModal").modal("show");
    $("#feature_id").val(id);

    $.ajax({
        type: "GET",
        url: get_features_by_id+ "/" + id,
        dataType: "json",
        beforeSend: function(data) {
            $(".loader_container").show();
        },
        success: function(data) {
            console.log(data, "single menu");

            $("#edit_title").val(data.title);
            $("#edit_route").val(data.route);
            $("#edit_sequence").val(data.sequence);
            $("#edit_icon").val(
                data.menu_icon == null ? "-" : data.menu_icon
            );
            $("#edit_parent_id").val(data.parent_id);

            if (data.is_active == 1) {
                $("#edit_is_active").prop("checked", true);
            } else {
                $("#edit_is_active").prop("checked", false);
            }

            if (data.route == "NULL") {
                $("#flexRadioDefault5").prop("checked", true);
                $("#ed_route-title").css("display", "none");
            } else {
                $("#flexRadioDefault5").prop("checked", false);
                $("#flexRadioDefault4").prop("checked", true);
                $("#ed_route-title").css("display", "block");
            }

            var role_id =  data.role_id.split(",");
            $("#edit_roles").val(role_id).trigger("change");

        },
        complete: function(data) {
            $(".loader_container").hide();
        },
        error: function(e) {
            console.log(e);
        }
    });
}
///////////////////////////////







function delete_feature_list(id) {
    $.ajax({
        type: "DELETE",
        url: "features/" + id,
        dataType: "json",
        success: function(data) {
            // console.log(data);
            get_all_feature_list();
            toastr.success(data.message, {
                timeOut: 5000
            });
        },
        error: function(e) {
            console.log(e);
        }
    });
}


