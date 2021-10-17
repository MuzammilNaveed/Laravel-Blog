$(document).ready(function() {

    alert("asd");
    get_all_newsletterss(); 
});

function get_all_newsletterss() {
    $("#newslettters_table").DataTable().destroy();
    $.fn.dataTable.ext.errMode = "none";
    var tbl =$("#newslettters_table").DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        pageLength: 10,
        columnDefs: [
            {
                orderable: false,
                targets: 0
            }
        ],
        ajax: {
            url: base_url + '/get_all_newsletter',
        },
        columns: [
            {
                data: null,
                defaultContent: ""
            },
            {
                "className" : "text-center",
                "render": function(data, type, full, meta) {
                    return full.email != null ? full.email : '-';
                }
            },
            {
                "className" : "text-center",
                "render": function(data, type, full, meta) {
                    return full.created_at != null ? full.created_at : '-';
                }
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
}