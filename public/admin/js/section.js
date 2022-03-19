$(document).ready(function() {
    let section_arr = [];
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $("#saveForm").submit(function(e) {
        e.preventDefault();
        let action = $(this).attr('action');
        let method = $(this).attr('method');

        section.saveSection(action , method , new FormData(this));
    });


    // delete category
    $("#deleteBtn").click(function() {
        let id = $("#delid").val();
        section.deleteRecord(id);
    });

    section.fetch();
    
});

const section  = {

    openModal : () => {
        $("#modal_title").text("Add Section");
        $("#showModal").modal('show'); 
        $("#saveForm").trigger("reset"); 
        $("#posts").val("").trigger("change");
    },

    saveSection : (url , method , data) => {

        $.ajax({
            url: url,
            type: method,
            data: data,
            dataType: 'JSON',
            async:true,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend:function(data) {
                $('.saveBtn').hide();
                $('.loadingBtn').show();
            },
            success: function(data) {
                console.log(data);
                if ((data.status == 200) & (data.success == true)) {
                    $("#showModal").modal('hide'); 
                    section.fetch();
                    notyf.success(data.message);
                } else {
                    notyf.error(data.message);
                }
            },
            complete:function(data) {
                $('.saveBtn').show();
                $('.loadingBtn').hide();
            },
            error: function(e) {
                $('.saveBtn').show();
                $('.loadingBtn').hide();
                console.log(e);
            }

        });
    },

    fetch : () => {

        fetch(getSections)
        .then( (response) => response.json() )
        .then((data) => {
            $('.loading__').attr('style', 'display: block !important');
            if(data.status_code == 200) {

                section_arr = data.sections;
                $("#sectionCount").text(data.sections.length);

                $('#showRecord').DataTable().destroy();
                $.fn.dataTable.ext.errMode = 'none';
                var tbl = $('#showRecord').DataTable({
                    data: data.sections,
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
                                return full.title != null ? full.title : "-";
                            }
                        },
                        {
                            render: function(data, type, full, meta) {
                                let name = ``;
                                  for(let index in full.posts) {
                                      if(full.posts[index].title != null) {
                                        name += `<a href="${base_url + '/posts'}/${full.posts[index].id}"> <span class="badge bg-light-primary" style="margin:2px"> ${full.posts[index].title} </span> </a>`;
                                      }
                                  }
                                return name;
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
                                    <button onclick="section.viewRecord(${full.id})" 
                                        type="button" class="btn btn-icon rounded-circle btn-outline-primary waves-effect" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 font-medium-3"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                    </button>

                                    <button onclick="section.deleteModal(${full.id})" 
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
                notyf.error('Something Went Wrong');
            }
        })
        .then( () => {
            $('.loading__').attr('style', 'display: none !important');
        })
        .catch( (error) => {
            notyf.error('Something Went Wrong');
        });

    },

    viewRecord: (id) => {
        let item = section_arr.find(item => item.id === id);

        if(item != null) {

            $("#id").val(id);
            $("#name").val(item.title != null ? item.title : '');

            item.status == 1 ? $("#status").prop("checked", true) : $("#status").prop("checked", false);

            if(item.hasOwnProperty('posts') && item.posts != null && item.posts.length > 0) {
                let post_id = $.map(item.posts , function (post_item , index) {
                    return post_item.id;
                });
        
                post_id != null ? $("#posts").val(post_id).trigger("change") : '';
            }

            
            $("#modal_title").text("Edit Category");
            $("#showModal").modal("show");
        }
    },

    deleteModal : (id) => {
        $("#deleteModal").modal('show');
        $("#delid").val(id);
    },

    deleteRecord :(id) => {
        $('.delLoader').attr('style' , 'display: block !important');
        $('.delBtn').attr('style' , 'display: none !important');

        fetch( section_url +`/${id}` , {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json; charset=UTF-8",
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
        })
        .then((response) => response.json())
        .then((data) =>  {
            if ( data.status == 200 && data.success == true) {
                $("#deleteModal").modal('hide');
                $("#row__"+id).remove();
                notyf.success(data.message);

            } else {
                notyf.error(data.message);
            }
        }).then( () => {
            $('.delLoader').attr('style' , 'display: none !important');
            $('.delBtn').attr('style' , 'display: block !important');
        })
        .catch( (error) => {
            $('.delLoader').attr('style' , 'display: none !important');
            $('.delBtn').attr('style' , 'display: block !important');
            notyf.error('Something Went Wrong');
        });
    }
}


function viewRecord(id,name,status) {

    $("#addModal").modal('show');
    $("#id").val(id);
    $("#title").val(name);

    $("#modal_title").text("Edit Section");

    if(status == 1) {
        $("#checkcircleColorOpt2").prop("checked",true);
    }else{
        $("#checkcircleColorOpt2").prop("checked",false);
    }
}


function deleteRecord(id) {
    $("#sid").val(id);
    $("#deleteModal").modal('show');
}


function get_all_sections() {
    $("#section_table").DataTable().destroy();
    $.fn.dataTable.ext.errMode = "none";
    var tbl =$("#section_table").DataTable({
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
        ajax: { url: base_url + "/get_section" },
        columns: [
            {
                data: null,
                defaultContent: ""
            },
            {
                render: function(data, type, full, meta) {
                    return full.title;
                }
            },
            {
                render: function(data, type, full, meta) {
                    let active = `<span class="badge badge-pill bg-success text-white"> active </span>`;
                    let de_active = `<span class="badge badge-pill bg-danger text-white"> not active </span>`;
                    return full.status == 1 ? active : de_active;
                }
            },
            {
                render: function(data, type, full, meta) {
                    return full.posts_count;
                }
            },
            {
                render: function(data, type, full, meta) {
                    return moment(full.created_at).local().format("MMM Do YYYY @ hh:mm A");
                }
            },
            {
                render: function(data, type, full, meta) {
                    return `
                        <button onclick="viewRecord(`+ full.id +`, '`+full.title+`',`+full.status+`)" type="button" 
                            class="btn btn-primary text-white btn_cirlce" data-toggle="tooltip" data-placement="top" title="Edit" >
                            <i class="fas fa-pencil-alt"></i> 
                        </button>
                        <button onclick="deleteRecord(`+full.id+`)" type="button" 
                            class="btn btn-danger text-white ml-2 text-white btn_cirlce" data-toggle="tooltip" data-placement="top" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>`;
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
