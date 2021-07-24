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
                url: "roles",
                data: $("#addRecord").serialize(),
                beforeSend:function(data) {
                    $("#save").hide();
                    $("#add_loader").show();
                },
                success: function(data) {
                    console.log(data, "a");
                    if ((data.status == 200) & (data.success == true)) {
                        notyf.success(data.message);

                        $("#addModal").modal("hide");
                        $("#addRecord")[0].reset();    
                        
                        getAllRoles();
                    } else {
                        notyf.error(data.message);
                    }
                },
                complete:function(data) {
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
                url: "roles/" + id,
                data: $("#updateRecord").serialize(),
                beforeSend:function(data) {
                    $("#edit_loader").show();
                },
                success: function(data) {
                    console.log(data, "a");
                    if ((data.status == 200) & (data.success == true)) {
                        
                        notyf.success(data.message);
                        $("#updateModal").modal("hide");
                        getAllRoles();

                    } else {
                        notyf.error(data.message);
                    }
                },
                complete:function(data) {
                    $("#edit_loader").hide();
                },
                error: function(e) {
                    console.log(e);
                    $("#edit_loader").hide();
                }
            });
        }
    });

    getAllRoles()
    
});


function getAllRoles() {

    $.ajax({
        type: "GET",
        url: "roles",
        beforeSend:function(data) {
            $(".loader_container").show();
        },
        success: function(data) {
            console.log(data, "a");

            $("#counts").text(data.length);
            $('#roles_table').DataTable().destroy();
            $.fn.dataTable.ext.errMode = 'none';
            var tbl = $('#roles_table').DataTable({
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
                        return full.name != null ? full.name : '-';
                    }
                },
                {
                    "render": function (data, type, full, meta) {
                        let user = `<a href="javascript:void(0)" onclick="showUserDetails(`+full.id+`)">`+full.user_count+`</a>`;
                        return full.user_count != null ? user : '-';
                    }
                },
                {
                    "render": function (data, type, full, meta) {
                        let update_btn = `<button onclick="viewRecord(`+ full.id +`, '`+full.name+`')" type="button" 
                        class="btn btn-primary text-white btn_cirlce" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-pencil-alt"></i></button>`;

                        let del_btn = `<button onclick="deleteRecord(`+full.id+`)" type="button" 
                        class="btn btn-danger ml-2 text-white btn_cirlce" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash"></i></button>`;

                        var update = $("#update").text();
                        var del = $("#delete").text();

                        if(update == 1 && del == 1) {
                            return update_btn + del_btn
                        } else if(update == 1 && del == 0) {
                            return update_btn;
                        }else if(update == 0 && del == 1) {
                            return del_btn;
                        }else{
                            return '-';
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
    $("#id").val(id)
    $("#name").val(name)
    $("#role_name").text(name)
}


function deleteRecord(id) {
    $.ajax({
        type: "DELETE",
        url: "roles/" + id,
        success: function(data) {
            if(data.status == 200 && data.success == true) {
                notyf.success(data.message);
                getAllRoles();
            }else{
                notyf.error(data.message);
            }           
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
        data: {id:id,page:'role'},
        beforeSend: function(data) {
            $("#user_loader").show();
        },
        success: function(data) {
            console.log(data, "a");
            
            let html = ``;

            for(var i = 0; i < data.length; i++) {
                let active = `<span class="badge bg-success text-white">active</span>`;
                let deactive = `<span class="badge bg-danger text-white">de-active</span>`;
                let status = data[i].status == 1 ? active : deactive;
                let img = `<img src="/users/`+ data[i].profile_pic +`" width="120" height="70" class="rounded">`;
                let noimage = `<span class="text-danger">Profile Picture is Missing</span>`;

                html += `
                <div class="card-group horizontal mb-1" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="card card-default  m-b-0">

                      <div class="card-header" role="tab" id="headingOne">
                        <div class="card-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne_`+data[i].id+`" aria-expanded="false" aria-controls="collapseOne_`+data[i].id+`" class="collapsed">
                             `+data[i].name+` - `+ status +`  
                            </a>
                        </div>
                      </div>

                      <div id="collapseOne_`+data[i].id+`" class="collapse" role="tabcard" aria-labelledby="headingOne" style="">
                        <div class="card-body">
                            <div class="row pt-0">
                                <div class="col-md-8">
                                    
                                    <p class="p-0 m-0"> `+(data[i].name != null ? `<i class="fas fa-user"></i> `+ data[i].name :'-')+` </p>
                                    <p class="p-0 m-0"> `+(data[i].email != null ? `<i class="fas fa-envelope"></i> `+ `<a href="mailto:`+data[i].email +`">`+data[i].email +`</a>`:'-')+` </p>

                                    
                                    <p class="p-0 m-0"> `+(data[i].phone != null ? `<i class="fas fa-phone"></i> `+ `<a href="tel:`+data[i].phone +`">`+data[i].phone +`</a>` :'-')+` </p>
                                    <p class="p-0 m-0"> `+(data[i].address != null ? `<i class="fas fa-map-marker-alt"></i> `+ data[i].address :'-')+`</p>

                                    <p class="p-0 m-0"> `+(data[i].facebook != null ? `<i class="fab fa-facebook"></i> `+ `<a href="`+data[i].facebook+`">`+data[i].facebook+`</a>` :'-')+`</p>
                                    <p class="p-0 m-0"> `+(data[i].linkedin != null ? `<i class="fab fa-linkedin"></i> `+  `<a href="`+data[i].linkedin+`">`+data[i].linkedin+`</a>` :'-')+`</p>
                                    <p class="p-0 m-0"> `+(data[i].instagram != null ? `<i class="fab fa-instagram"></i> `+  `<a href="`+data[i].instagram+`">`+data[i].instagram+`</a>` :'-')+`</p>
                                    <p class="p-0 m-0"> `+(data[i].twitter != null ? `<i class="fab fa-twitter"></i> `+   `<a href="`+data[i].twitter+`">`+data[i].twitter+`</a>` :'-')+`</p>
                                </div>
                                <div class="col-md-4">
                                    `+ ( data[i].profile_pic != null && data[i].profile_pic != '' ? img : noimage) +`
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
                `;

            }
            
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


