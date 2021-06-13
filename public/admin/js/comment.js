
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

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
                        return `<a href="`+view_post+`/`+full.post.id+`">`+full.post.title+`</a>`;
                    }
                },
                {
                    "render": function (data, type, full, meta) {
                        return `<span class="badge bg-primary text-white">`+full.replies + `</span>`;
                    }
                },
                {
                    "render": function (data, type, full, meta) {
                        let approve = `<span class="badge bg-success text-white">Approved</span>`;
                        let pending = `<span class="badge bg-warning text-white">Pending</span>`;
                        let reject = `<span class="badge bg-danger text-white">Rejected</span>`;
                        if(full.status == 1) {
                            return approve;
                        } else if(full.status == 2) {
                            return reject;
                        }else {
                            return pending;
                        }
                    }
                },
                {
                    "render": function (data, type, full, meta) {
                        return `<div class="d-flex justify-content-center">
                            <button data-toggle="tooltip" data-placement="top" title="Approve Comment" onclick="commentStatus(`+ full.id +`,'approve')" type="button" class="btn btn-success text-white btn_cirlce"><i class="fas fa-check"></i></button>
                            <button data-toggle="tooltip" data-placement="top" title="Dis-approve Comment" onclick="commentStatus(`+full.id+`,'reject')" type="button" class="btn btn-danger text-white ml-2 btn_cirlce">
                            <i class="fas fa-ban"></i>
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
                            $('[data-toggle="tooltip"]').tooltip();
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
            $('[data-toggle="tooltip"]').tooltip();
        },
        error: function(e) {
            console.log(e);
        }
    });
}

function format ( data ) {

    var row = ``;
    var count =1;
    for(var i =0; i< data.length; i++) {

        cmt_rp_status = '';
        if(data[i].status == 1) {
            cmt_rp_status = '<span class="badge bg-success text-white">Approved</span>';
        } else if(data[i].status == 2) {
            cmt_rp_status = '<span class="badge bg-danger text-white">Rejected</span>';
        }else {
            cmt_rp_status = '<span class="badge bg-warning text-white">Pending</span>';
        }

        row += `
            <tr>
                <td>`+count+`</td>
                <td>`+moment(data[i].created_at).format('DD-MM-YYYY h:m:s')+`</td>
                <td>`+data[i].name + `</td>
                <td>`+data[i].email+`</td>
                <td>`+data[i].comment+`</td>
                <td>`+ cmt_rp_status +`</td>
                <td>
                    <div class="d-flex justify-content-center">
                        <button data-toggle="tooltip" data-placement="top" title="Approve Reply" onclick="commentReplyStatus(`+ data[i].id +`,'approve')" type="button" class="btn btn-success text-white btn_cirlce" title="Edit"><i class="fas fa-check"></i></button>
                        <button data-toggle="tooltip" data-placement="top" title="Disapprove Reply" onclick="commentReplyStatus(`+data[i].id+`,'reject')" type="button" class="btn btn-danger ml-2 text-white btn_cirlce" title="Delete">
                            <i class="fas fa-ban"></i>
                        </button>
                    </div>
                </td>
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

function commentStatus(id,action) {
    $.ajax({
        type: "POST",
        url: approve_comment,
        dataType:'json',
        data:{id:id,action:action},
        beforeSend:function(data) {
            $(".loader_container").show();
        },  
        success: function(data) {
            if (data.status == 200 && data.success == true) {
                getAllComments()
                notyf.success(data.message);
            } else {
                notyf.error(data.message);
            }
        },
        complete:function(data) {
            $(".loader_container").hide();
        },
        error: function(e) {
            console.log(e);
        }
    });
}

function commentReplyStatus(id,action) {
    $.ajax({
        type: "POST",
        url: approve_comment_reply,
        dataType:'json',
        data:{id:id,action:action},
        beforeSend:function(data) {
            $(".loader_container").show();
        },  
        success: function(data) {
            if (data.status == 200 && data.success == true) {
                // getAllComments()
                notyf.success(data.message);
            } else {
                notyf.error(data.message);
            }
        },
        complete:function(data) {
            $(".loader_container").hide();
        },
        error: function(e) {
            console.log(e);
        }
    });
}