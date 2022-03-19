$(document).ready(function() {
    let posts_arr = [];
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    posts.get();
    
});


const posts = {

    get :() => {
        fetch(get_posts)
        .then( (response) => response.json() )
        .then((data) => {
            $('.loading__').attr('style', 'display: block !important');
            if(data.status_code == 200) {
                posts_arr = data.posts;
                $("#catCount").text(data.posts.length);
                $('#showRecord').DataTable().destroy();
                $.fn.dataTable.ext.errMode = 'none';
                var tbl = $('#showRecord').DataTable({
                    data: data.posts,
                    "pageLength": 10,
                    "bInfo": false,
                    "paging": true,
                    "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                        $(nRow).attr('id', 'row__'+aData.id);
                    },
                    'columnDefs': [
                        {
                            'targets': 0,
                            'createdCell':  function (td, cellData, rowData, row, col) {
                                $(td).attr('id',rowData.id); 
                            }
                        }
                    ],
                    columns: [
                        {
                            "className":'details-control text-left',
                            "orderable":false,
                            "data":null,
                            "defaultContent": ''
                        },
                        {
                            "render": function(data, type, full, meta) {
                                let img = `<img src="${base_url}/${full.image}" class="rounded" height="50" width="50">`;
                                return full.image != null ? img : '-';
                            }
                          },
                        {
                            "render": function(data, type, full, meta) {
                                return ` <a href="#"> ${full.title} </a> `;
                            }
                          },
                          {
                              "render": function(data, type, full, meta) {
                                  return full.hasOwnProperty('category_name') ? (full.category_name != null ? full.category_name : '-')  : '-';
                              }
                          },
                          {
                              "className" : "small",
                              "render": function(data, type, full, meta) {
                                  let name = ``;
                                  for(let index in full.tags) {
                                      if(full.tags[index].name != null) name += `<span class="badge bg-light-primary" style="margin:2px"> ${full.tags[index].name} </span>`;
                                  }
                                  return name;
                              }
                          },
                          {
                            "render": function(data, type, full, meta) {
                                let pending = `<span class="badge bg-light-danger"> Pending </span>`;
                                let public = `<span class="badge bg-light-success"> Public </span>`;
                                return full.status == 1 ? public : pending;
                                
                            }
                        },
                          {
                            "render": function(data, type, full, meta) {
                                return full.created_at != null ? full.created_at : '-';
                                
                            }
                        },
                        {
                            "render": function(data, type, full, meta) {
                                return full.hasOwnProperty('created_by_name') ? (full.created_by_name != null ? full.created_by_name : '-')  : '-';                                
                            }
                        },
                          {
                              "render": function(data, type, full, meta) {
                                return `<div class="form-check form-switch form-check-primary">
                                        <input type="checkbox" class="form-check-input" id="customSwitch10" ${full.status == 1 ? 'checked' : ''}>
                                        <label class="form-check-label" for="customSwitch10">
                                            <span class="switch-icon-left"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
                                            <span class="switch-icon-right"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></span>
                                        </label>
                                    </div>`;
                            }
                          },
                        {
                            render: function(data, type, full, meta) {
                                return `<div class="dropdown-items-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical" id="dropdownMenuLink1" role="button" data-bs-toggle="dropdown" aria-expanded="false"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink1" style="">

                                    <a class="dropdown-item" href="${base_url + '/posts'}/${full.id}/edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 font-medium-3 me-50"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                        <span class="align-middle">Edit Post</span>
                                    </a>
                                    <a class="dropdown-item" href="${base_url + '/posts'}/${full.id}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 font-medium-3 me-50"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                        <span class="align-middle">View Post</span>
                                    </a>
                                    <a class="dropdown-item" onclick="posts.deleteRecord(${full.id})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash font-medium-3 me-50"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        <span class="align-middle">Delete Post</span>
                                    </a>
                                </div>
                            </div>`;
                            }
                        },
                    ],
                });

                // Add event listener for opening and closing details
                $('#showRecord tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = tbl.row( tr );
                    var id = $(this).attr('id');

                    console.log(id , "id");

                    if ( row.child.isShown() ) {
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        row.child( posts.showCompleteDetail(id) ).show();
                        tr.addClass('shown');
                    }
                });

            }else{
                // notyf.error('Something Went Wrong');
            }
        })
        .then( () => {
            $('.loading__').attr('style', 'display: none !important');
        })
        .catch( (error) => {
            // notyf.error('Something Went Wrong');
        });

    },


    showCompleteDetail : (id) => {

        var item = posts_arr.find(item => item.id == parseInt(id));
        console.log(item)
        if(item != null && item != "" && item != undefined && item != []) {
            let name = ``;
            for(let tags in item.tags) {
                name += `<span class="badge bg-light-primary" style="margin:2px"> ${item.tags[tags].name} </span>`;
            }
            return `
                <div class="row bg-light p-1">
                    <div class="col-md-4">
                        <div>
                            <span class="small text-mited"> Title </span>
                            <h6> ${item.title} </h6>
                        </div>
                        <div>
                            <span class="small text-mited"> Category </span>
                            <h6> ${item.category_name} </h6>
                        </div>
                        <div>
                            <span class="small text-mited"> Created at </span>
                            <h6> ${item.created_at} </h6>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div>
                            <span class="small text-mited"> Created by </span>
                            <h6> ${item.created_by_name} </h6>
                        </div>
                        <div>
                            <span class="small text-mited"> Tags </span>
                            <h6> ${name} </h6>
                        </div>
                        <div>
                            <span class="small text-mited"> Status </span>
                            <span class="badge bg-light-${item.status == 1 ? 'success' : 'danger'}"> ${item.status == 1 ? 'Public' : 'Pending'} </span>
                        </div>
                    </div>   
                    <div class="col-md-4">
                        <div>
                            <span class="small text-mited"> Feature Image </span> <br>
                            <img class="rounded" src="${base_url}/${item.image}" alt="avatar" height="100" width="100">
                        </div>
                    </div>                   
                </div>`;
        }
    },

    deleteRecord : (id) => {
        $("#id").val(id);
        $("#deleteModal").modal('show');
    }

}

