$(document).ready(function() {
    let users_arr = [];
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    //for insert user record
    $("#addRecord").submit(function(e) {
        e.preventDefault();

        users.saveUser( $(this).attr('action') , $(this).attr('method')  ,new FormData(this) );

    });

     // delete category
     $("#deleteRecord").click(function() {
        var id = $("#did").val();
        users.deleteRecord(id);
    });

    users.fetch();
    
});

const users = {

    openModal : () => {
        $("#addRecordModal").modal('show');
        $("#modal_title").text("Add User");
        $("#addRecord").trigger('reset');
        $("#id").val("");
    },

    saveUser : (url , method , data) => {

        $.ajax({
            type: method,
            url: url,
            data: data,
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function(data) {
                $('.loadingBtn').show();
                $('.saveBtn').hide();
            },
            success: function(data) {
                if ((data.status_code == 200) & (data.success == true)) {
                    $("#addRecordModal").modal("hide");   
                    notification('success' , data.message , 'Success');
                } else {
                    notification('error' , data.message , 'Failed');
                }
            },
            complete: function(data) {
                $('.loadingBtn').hide();
                $('.saveBtn').show();
            },
            error: function(e) {
                console.log(e);
                $('.loadingBtn').hide();
                $('.saveBtn').show();
            }
        });
    },

    fetch : () => {

        fetch(get_users)
        .then( (response) => response.json() )
        .then((data) => {
            $('.loading__').attr('style', 'display: block !important');
            if(data.status_code == 200) {

                users_arr = data.users;
                $("#sectionCount").text(data.users.length);
                $('#showRecord').DataTable().destroy();
                $.fn.dataTable.ext.errMode = 'none';
                var tbl = $('#showRecord').DataTable({
                    data: data.users,
                    "pageLength": 10,
                    "bInfo": false,
                    "paging": true,
                    "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                        $(nRow).attr('id', 'row__'+aData.id);
                    },
                    columns: [
                        {
                            data: null,
                            defaultContent: ""
                        },
                        {
                            render: function(data, type, full, meta) {
                                return full.name != null ? `<a href="${base_url}/profile/${full.id}" class="fw-bolder">${full.name}</a>` : "-";
                            }
                        },
                        {
                            render: function(data, type, full, meta) {
                                return full.email != null ? `<a href="mailto:${full.email}">${full.email}</a>` : "-";
                            }
                        },
                        {
                            render: function(data, type, full, meta) {
                                return full.role_id != null ? full.role_id : '-';
                            }
                        },
                        {
                            render: function(data, type, full, meta) {
                                return `<span class="badge bg-light-${full.status == 1 ? "success" : "danger"}"> ${full.status == 1 ? "Active" : "Inactive"}</span>`;
                            }
                        },
                        {
                            render: function(data, type, full, meta) {
                                return full.created_at != null ? full.created_at : '-';
                            }
                        },
                        {
                            render: function(data, type, full, meta) {
                                return `
                                <div class="d-flex justify-content-start">
                                    <button onclick="users.viewRecord(${full.id})" 
                                        type="button" class="btn btn-icon rounded-circle btn-outline-primary waves-effect" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 font-medium-3"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                    </button>

                                    <button onclick="users.deleteModal(${full.id})" 
                                        type="button" class="btn btn-icon rounded-circle btn-outline-danger mx-1 waves-effect" data-toggle="tooltip" data-placement="top" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash font-medium-3"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    </button>

                                </div>`;
                            }
                        },
                    ],
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
            }else{
                notification('error' , 'Something went wrong' , 'Failed');
            }
        })
        .then( () => {
            $('.loading__').attr('style', 'display: none !important');
        })
        .catch( (error) => {
            notification('error' , 'Something went wrong' , 'Failed');
        });

    },

    viewRecord : (id) => {

        let item = users_arr.find(item => item.id === id);

        if(item != null) {
            $("#id").val(id);
            $("#name").val(item.name);
            $("#email").val(item.email);
            $("#role").val(item.role_id);

            $("#password").attr('readonly' , true);

            item.status == 1 ? $("#status").prop("checked", true) : $("#status").prop("checked", false);

            $("#addRecordModal").modal('show');
            $("#modal_title").text("Edit User");
        }

    },

    deleteModal : (id) => {
        $("#deleteModal").modal('show');
        $("#did").val(id);
    },

    deleteRecord :(id) => {
        $('.delLoader').attr('style' , 'display: block !important');
        $('.delBtn').attr('style' , 'display: none !important');

        fetch( deluser +`/${id}` , {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json; charset=UTF-8",
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
        })
        .then((response) => response.json())
        .then((data) =>  {
            console.log(data);
            if ( data.status == 200 && data.success == true) {
                $("#deleteModal").modal('hide');
                $("#row__"+id).remove();

                let sectionCount = $("#sectionCount").text();
                sectionCount != 0 ? $("#sectionCount").text( ($("#sectionCount").text() - 1) ) : $("#sectionCount").text(0);
                
                notification('success' , data.message , 'Success');

            } else {
                notification('error' , data.message , 'Failed');
            }
        }).then( () => {
            $('.delLoader').attr('style' , 'display: none !important');
            $('.delBtn').attr('style' , 'display: block !important');
        })
        .catch( (error) => {
            notification('error' , 'Something went wrong' , 'Failed');
            $('.delLoader').attr('style' , 'display: none !important');
            $('.delBtn').attr('style' , 'display: block !important');
        });
    }
}
