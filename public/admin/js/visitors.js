$(document).ready(function() {
    getAllComments();
});

function getAllComments() {
    $.ajax({
        type: "GET",
        url: get_usrr_info,
        beforeSend: function(data) {
            $(".loader_container").show();
        },
        success: function(data) {
            console.log(data, "a");
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
                        "data": "ip_add"
                    },
                    {
                        "data": "country"
                    },
                    {
                        "data": "city"
                    },
                    {
                        "data": "state"
                    },
                    {
                        "data": "postal_code"
                    },
                    {
                        "data": "time_zone"
                    },
                    {
                        "data": "pltform"
                    },
                    {
                        "data": "pltform_version"
                    },
                    {
                        "data": "browser"
                    },
                    {
                        "data": "browser_version"
                    },
                    {
                        "data": "devices"
                    },
                    {
                        "data": "desktop"
                    },
                    {
                        "data": "phone"
                    },
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
