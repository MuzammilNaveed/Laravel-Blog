
$(document).ready(function() {

    getAllComments();

});

function getAllComments() {

    $.ajax({
        type: "GET",
        url: get_comments,
        beforeSend:function(data) {
            $(".loader_container").show();
        },
        success: function(data) {
            console.log(data, "a");

            $("#counts").text(data.length);
            $('#comment_table').DataTable().destroy();
            $.fn.dataTable.ext.errMode = 'none';
            var tbl = $('#comment_table').DataTable({
                data: data,
                "pageLength":25,
                "bInfo": true,
                "paging": true,
                columns: [
                    {
                        "className":'details-control',
                        "orderable":false,
                        "data":null,
                        "defaultContent": ''
                    },
                    {
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
                    "data" : "email",
                },
                {
                    "data" : "comment",
                },
                {
                    "render": function (data, type, full, meta) {
                        return `<a href="#">`+full.post.title+`</a>`;
                    }
                },
                {
                    "data" : "replies",
                },
                {
                    "render": function (data, type, full, meta) {
                        let approve = `<span class="badge bg-success text-white">Approved</span>`;
                        let reject = `<span class="badge bg-warning text-white">Pending</span>`;
                        return full.status == 1 ? approve: reject;
                    }
                },
                {
                    "render": function (data, type, full, meta) {
                        return ` <div class="d-flex justify-content-center">
                            <button onclick="viewRecord(`+ full.id +`, '`+full.name+`')" type="button" class="btn btn-primary card_shadow round" title="Edit"><i class="fas fa-check"></i></button>
                            <button onclick="deleteRecord(`+full.id+`)" type="button" class="btn btn-danger ml-2 card_shadow round" title="Delete">
                            <i class="fas fa-trash"></i></button>
                        </div>`
                    }
                },
            ],
            });


            $('#comment_table tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = tbl.row(tr);
                var rowData = row.data();

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    $.ajax({
                        type: "GET",
                        url: get_comment_replies+ "/" + rowData.id,
                        beforeSend:function(data) {
                            $(".loader_container").show();
                        },
                        success: function(data) {
                            row.child( format(data) ).show();
                            tr.addClass('shown');
                        },
                        complete:function(data) {
                            $(".loader_container").hide();
                        },
                        error: function(e) {
                            console.log(e);
                        }
                    });

                    

                }
            });


            tbl.on('order.dt search.dt', function () {
                tbl.column(1, {
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


function format ( data ) {
    console.log(data, "data");
    var row = ``;
    var count =1;
    for(var i =0; i< data.length; i++) {

        row += `
            <tr>
                <td>`+count+`</td>
                <td>`+moment(data[i].created_at).format('DD-MM-YYYY h:m:s')+`</td>
                <td>`+data[i].name + `</td>
                <td>`+data[i].email+`</td>
                <td>`+data[i].comment+`</td>
                <td>`+data[i].status+`</td>
                <td>-</td>
            </tr>
        `;
        count++;
    }

    return `<table class="table table-hover w-75 text-center " style="padding-left:50px;">
        <thead>
            <tr>
                <th>Sr#</th>
                <th>Date</th>
                <th>Name</th>
                <th>Email</th>
                <th>Reply</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            `+row+`
        </tbody>
    </table>`;
}