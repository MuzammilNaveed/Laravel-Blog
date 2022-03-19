let category_arr = [];
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });


    categories.fetch();


    $("#saveCategory").submit(function(e) {
        e.preventDefault();
        let action = $(this).attr('action');
        let method = $(this).attr('method');

        let formData = new FormData(this);
        const plainFormData = Object.fromEntries(formData.entries());

        categories.saveCategory(action , method , plainFormData);
    });

    // delete category
    $("#deleteRecord").click(function() {
        var id = $("#did").val();
        categories.deleteCategory(id);
    });

});

    const categories  = {

        openModal : () => {
            $("#showModal").modal('show');
            $("#modal_title").text("Add Category");
            $("#saveCategory").trigger('reset');
            $("#id").val("");
        },

        saveCategory : (url , method , data) => {

            $('.loadingBtn').attr('style' , 'display: block !important');
            $('.saveBtn').attr('style' , 'display: none !important');

            fetch( url , {
                method: method,
                body: JSON.stringify(data),
                headers: {
                    "Content-Type": "application/json; charset=UTF-8",
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
            })
            .then((response) => response.json())
            .then((data) =>  {
                if ( data.status == 200 && data.success == true) {
                    $("#showModal").modal("hide");
   
                    categories.fetch();
                    notyf.success(data.message);
    
                } else {
                    notyf.error(data.message);
                }
            }).then( () => {
                $('.loadingBtn').attr('style' , 'display: none !important');
                $('.saveBtn').attr('style' , 'display: block !important');
            })
            .catch( (error) => {
                $('.loadingBtn').attr('style' , 'display: none !important');
                $('.saveBtn').attr('style' , 'display: block !important');
                notyf.error('Something Went Wrong');
            });
        },

        fetch : () => {

            fetch(getCategory)
            .then( (response) => response.json() )
            .then((data) => {
                $('.loading__').attr('style', 'display: block !important');
                if(data.status_code == 200) {

                    category_arr = data.categories;
                    $("#catCount").text(data.categories.length);
                    $('#showRecord').DataTable().destroy();
                    $.fn.dataTable.ext.errMode = 'none';
                    var tbl = $('#showRecord').DataTable({
                        data: data.categories,
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
                                    return full.name != null ? full.name : "-";
                                }
                            },
                            {
                                render: function(data, type, full, meta) {
                                    return full.description != null ? full.description.substring(0, 30) + "..." : "-";
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
                                        <button onclick="categories.viewCategory(${full.id})" 
                                            type="button" class="btn btn-icon rounded-circle btn-outline-primary waves-effect" data-toggle="tooltip" data-placement="top" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 font-medium-3"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                        </button>

                                        <button onclick="categories.deleteModal(${full.id})" 
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

        viewCategory : (id) => {

            let item = category_arr.find(item => item.id === id);

            if(item != null) {
                $("#id").val(id);
                $("#name").val(item.name);
                $("#description").val(item.description);

                item.status == 1 ? $("#status").prop("checked", true) : $("#status").prop("checked", false);

                $("#showModal").modal("show");
                $("#modal_title").text("Edit Category");
            }

        },

        deleteModal : (id) => {
            $("#deleteModal").modal('show');
            $("#cid").val(id);
        },

        deleteCategory :(id) => {
            $('.delLoader').attr('style' , 'display: block !important');
            $('.delBtn').attr('style' , 'display: none !important');

            fetch( delCategory +`/${id}` , {
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