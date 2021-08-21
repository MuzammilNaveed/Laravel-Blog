$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });


    getAllPosts();
});


function getAllPosts() {
    $("#post_table").DataTable().destroy();
    $.fn.dataTable.ext.errMode = "none";
    var tbl =$("#post_table").DataTable({
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
            url: posts
        },
        columns: [
            {
                data: null,
                defaultContent: ""
            },
            {
                "render": function(data, type, full, meta) {
                  let img = `<img src="/images/`+full.image+`" width="80" height="50" class="shadow-sm rounded">`;
                  return img;
                }
              },
              {
                  "render": function(data, type, full, meta) {
                      let link = `<div class="mt-2">
                          <a style="font-size:1rem" data-toggle="tooltip" data-placement="top" title="`+full.title+`" href="edit_post/`+full.id+`">`+full.title.substr(0,30) + '...' +`</a>
                              <br> created at: <span class="small text-muted">`+moment(full.created_at).format("DD-MM-YYYY h:m:s")+`</span>
                          </div>`;
                      return link;
                  }
              },
              {
                  "className" : "text-center",
                  "render": function(data, type, full, meta) {
                      return full.view_count;
                  }
              },
              {
                  "className" : "small",
                  "render": function(data, type, full, meta) {
                      return `<span class="small">`+full.category.name+`</span>`;
                  }
              },
              {
                  "data": "section",
                  "render": function(data, type, full, meta) {
                      if(full.section == 1) {
                          return `<span class="small">Header</span>`;
                      }else if(full.section == 2) {
                          return `<span class="small">Project</span>`;
                      }else{
                          return `<span class="small">Tutorials</span>`;
                      }
                  }
              },
              {
                  "className" : "small",
                  "render": function(data, type, full, meta) {
                      if(full.user != null && full.user != '') {
                          let created_by = `<a href="javascript:void(0)" onclick="showUserDetails(`+full.user.id+`)">`+full.user.name +`</a>`
                          return created_by;
                      }else{
                          return `-`;
                      }
                      
                  }
              },
              {
                  "className" : "small text-center",
                  "render": function(data, type, full, meta) {
                      if(full.comments.length > 0) {

                          for(var c = 0; c < full.comments.length; c++) {
                              return `<a onclick="showComments(`+full.comments[c].id+`,'`+full.title+`')" href="javascript:void(0)">`+full.comments.length+`</a>`;
                          }
                      }else{
                          return full.comments.length;
                      }
                      
                  }
              },
              
              {
                  "render": function(data, type, full, meta) {
                    var tag_arr = [];
                    for(var i=0; i < full.tags.length;i++) {
                      var tag = `<span class="badge badge-pill mt-1 mr-1 bg-primary text-white">`+full.tags[i].name+`</span>`;
                      tag_arr.push(tag);
                    }
                    return tag_arr.join(' ');
                }
              },
              {
                  "className" : "text-left",
                  "render": function(data, type, full, meta) {
                      let check = `<i class="fas fa-check text-success"></i>`;
                      let cancel = `<i class="fas fa-times text-danger"></i>`;
                    return `
                      <ul class="small seo pl-0" style="list-style:none">
                          <li >`+(full.meta_title !=null ? check + ' Meta Title' : cancel+ ' Meta Title')+`</li>
                          <li >`+(full.meta_author !=null ? check + ' Meta Author Name ': cancel+ ' Meta Author Name ')+`</li>
                          <li >`+(full.meta_description !=null ? check + ' Meta Description': cancel+ ' Meta Description')+` </li>
                          <li >`+(full.meta_tags !=null ? check + ' Meta Tags': cancel + ' Meta Tags')+` </li>
                      </ul>
                    `;
                }
              },
              {
                  "render": function(data, type, full, meta) {
                    return `
                    <div class="custom-control custom-switch">
                      <input onchange="changeStatus(`+full.id+`)" type="checkbox" class="custom-control-input" id="active_post_`+full.id+`"  `+(full.is_active == 1 ? 'checked' : '-')+` >
                      <label class="custom-control-label" for="active_post_`+full.id+`"></label>
                    </div>
                    `;
                }

              },
              {
                  "render": function(data, type, full, meta) {
                      let view_btn = `<a data-toggle="tooltip" data-placement="top" title="view post" href="`+view_post+`/`+full.id+`"class="btn btn-info text-white btn_cirlce ml-2">
                      <i class="far fa-eye"></i></a>`;
                      let update_btn = ` <a href="edit_post/`+full.id+`" type="button" class="btn btn-primary text-white btn_cirlce ml-2" data-toggle="tooltip" data-placement="top" title="edit post"><i class="fas fa-pen"></i></a>`;
                      let del_btn = `<button data-toggle="tooltip" data-placement="top" title="delete post" onclick="deleteRecord(`+ full.id + `)" type="button" class="btn btn-danger text-white ml-2 text-white btn_cirlce">
                      <i class="fas fa-trash"></i></button>`;
                      
                      var update = $("#update").text();
                      var del = $("#delete").text();
                      
                      if(update != "" && del != "") {
                          if(update == 1 && del == 1) {
                              return view_btn + update_btn + del_btn
                          } else if(update == 1 && del == 0) {
                              return view_btn + update_btn;
                          }else if(update == 0 && del == 1) {
                              return view_btn + del_btn;
                          }else{
                              return view_btn;
                          }
                      }
                  
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




function changeStatus(id) {
    if( $("#active_post_"+id).is(":checked") ) {
        $.ajax({
            type: "GET",
            url: "active_post/" + id,
            data: {is_active:1},
            success: function(data) {
                if ((data.status == 200) & (data.success == true)) {
                    notyf.success(data.message);
                } else {
                    notyf.error(data.message);
                }
            },
            error: function(e) {
                console.log(e);
            }
        });
    }else{
        $.ajax({
            type: "GET",
            url: "active_post/" + id,
            data: {is_active:0},
            success: function(data) {
                if ((data.status == 200) & (data.success == true)) {
                    notyf.success(data.message);
                } else {
                    notyf.error(data.message);
                }
            },
            error: function(e) {
                console.log(e);
            }
        });
    }
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

function showComments(id , post_title) {

    $("#commentViewModal").modal('show');
    $("#postname").text(post_title);

    $.ajax({
        type: "post",
        url: comment_details,
        data: {id:id},
        beforeSend: function(data) {
            $("#cmt_loader").show();
        },
        success: function(data) {
            console.log(data, "a");
            let count = 1;
            let html = ``;
            for(var i = 0; i < data.length; i++) {

                html +=`
                    <p> <strong>`+count+`.</strong> `+data[i].comment+`</p>
                `;
            }
 
            $("#comment_detail").html(html);

        },
        complete: function(data) {
            $("#cmt_loader").hide();
        },
        error: function(e) {
            console.log(e);
        }
    });
}