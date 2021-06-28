$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });


    getAllPages();

});

function getAllPages() {

    $.ajax({
        type: "GET",
        url: get_all_pages,
        dataType: 'json',
        beforeSend: function(data) {
            $(".loader_container").show();
        },
        success: function(data) {
            console.log(data, "a");

            $("#counts").text(data.length);
            $("#pages_table").DataTable().destroy();
            $.fn.dataTable.ext.errMode = "none";
            var tbl = $("#pages_table").DataTable({
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
                        return full.page_name != null ? full.page_name : '-';
                      }
                    },
                    {
                        "render": function(data, type, full, meta) {
                            return full.page_slug != null ? full.page_slug : '-';
                        }
                    },
                    {
                        "render": function(data, type, full, meta) {
                            return full.created_by;
                        }
                    },
                    {
                        "render": function(data, type, full, meta) {
                            return (
                                ` <div class="d-flex justify-content-center">

                                    <a href="#" type="button" class="btn btn-primary text-white btn_cirlce ml-2" data-toggle="tooltip" data-placement="top" title="Edit Page"><i class="fas fa-pen"></i></a>
                                    
                                    <button data-toggle="tooltip" data-placement="top" title="Delete Page" type="button" class="btn btn-danger text-white ml-2 text-white btn_cirlce">
                                    <i class="fas fa-trash"></i></button>
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


            $("#sections").on('change', function () {
                tbl.column(5).search($(this).val()).draw();
            });

            $("#category_id").on('change', function () {
                tbl.column(4).search($(this).val()).draw();
            });
        },
        complete: function(data) {
            $(".loader_container").hide();
            $('[data-toggle="tooltip"]').tooltip();
        },
        error: function(e) {
            console.log(e);
        }
    });
}



function showUserDetails(id) {

    $("#userViewModal").modal('show');

    $.ajax({
        type: "post",
        url: user_detail,
        data: {id:id,page:'post'},
        beforeSend: function(data) {
            $("#user_loader").show();
        },
        success: function(data) {
            console.log(data, "a");
            $("#username").text(data.name);
            let img = `<img src="/users/`+ data.profile_pic +`" width="120" height="70" class="shadow-sm rounded">`;

            let html = `
                <table class="table table-hover table-bordered table-sm">
                    <tr>
                        <td class="p-1">Name</td>
                        <td class="p-1">`+(data.name != null ? data.name : '-')+`</td>
                    </tr>
                    <tr>
                        <td class="p-1">Role</td>
                        <td class="p-1">`+(data.role != null ? data.role.name : '-')+`</td>
                    </tr>
                    <tr>
                        <td class="p-1">Email</td>
                        <td class="p-1">`+(data.email != null ? data.email : '-')+`</td>
                    </tr>
                    <tr>
                        <td class="p-1">Phone</td>
                        <td class="p-1">`+(data.phone != null ? data.phone : '-')+`</td>
                    </tr>
                    <tr>
                        <td class="p-1">Address</td>
                        <td class="p-1">`+(data.address != null ? data.address : '-')+`</td>
                    </tr>
                    <tr>
                        <td class="p-1">Facebook</td>
                        <td class="p-1">`+(data.facebook != null ? data.facebook : '-')+`</td>
                    </tr>
                    <tr>
                        <td class="p-1">Twitter</td>
                        <td class="p-1">`+(data.twitter != null ? data.twitter : '-')+`</td>
                    </tr>
                    <tr>
                        <td class="p-1">Linkedin</td>
                        <td class="p-1">`+(data.linkedin != null ? data.linkedin : '-')+`</td>
                    </tr>
                    <tr>
                        <td class="p-1">Instagram</td>
                        <td class="p-1">`+(data.instagram != null ? data.instagram : '-')+`</td>
                    </tr>
                    <tr>
                        <td class="p-1">Profile Image</td>
                        <td class="p-1">`+ ( data.profile_pic != null ? img : '-') +`</td>
                    </tr>
                </table>
            `;
            $("#user_detail").html(html);

        },
        complete: function(data) {
            $("#user_loader").hide();
        },
        error: function(e) {
            console.log(e);
        }
    });
}
