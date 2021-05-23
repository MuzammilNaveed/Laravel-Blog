$(document).ready(function() {

    let date = new Date();
    let from = moment(date).startOf('month').format('YYYY-MM-DD');
    let to = moment(date).endOf('month').format('YYYY-MM-DD');
    
    getAllPosts(from,to);
});

function getAllPosts(from,to) {
    $("#from_date").text(from);
    $("#to_date").text(to);

    $.ajax({
        type: "GET",
        url: "posts",
        data: {from:from,to:to},
        beforeSend: function(data) {
            $(".loader_container").show();
        },
        success: function(data) {
            console.log(data, "a");

            $("#counts").text(data.length);
            $("#post_table").DataTable().destroy();
            $.fn.dataTable.ext.errMode = "none";
            var tbl = $("#post_table").DataTable({
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
                      "render": function(data, type, full, meta) {
                        let img = `<img src="/images/`+full.image+`" style="width:250px;height:60px" class="img-fluid rounded">`;
                        return img;
                      }
                    },
                    {
                        "render": function(data, type, full, meta) {
                            return moment(full.created_at).format(
                                "DD-MM-YYYY h:m:s"
                            );
                        }
                    },
                    {
                        "render": function(data, type, full, meta) {
                            let link = `<a href="edit_post/`+full.id+`">`+full.title+`</a>`;
                            return link;
                        }
                    },
                    {
                        "className" : "small",
                        "data": "category[0].name"
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
                            return (
                                ` <div class="d-flex justify-content-center">
                          <a href="edit_post/`+full.id+`" onclick="viewRecord(`+ full.id +`, '` + full.name +`')" type="button" class="btn btn-primary card_shadow round" title="Edit"><i class="fas fa-pen"></i></a>
                          <button onclick="deleteRecord(`+ full.id + `)" type="button" class="btn btn-danger ml-2 card_shadow round" title="Delete">
                          <i class="fas fa-trash"></i></button>
                      </div>`
                            );
                        }
                    }
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

function filterData(value) {
    var today = new Date();
    switch (value) {
        case "current_month":
            var from_date1 =  moment(today).startOf('month').format('YYYY-MM-DD');
            var too_date1 =  moment(today).endOf('month').format('YYYY-MM-DD');
            getAllPosts(from_date1,too_date1)
            $("#date_range_filter").attr("style", "display:none !important");
            break;
        case "previous_month":
            var from_date =  moment(today).subtract(1,'months').startOf('month').format('YYYY-MM-DD');
            var too_date =  moment(today).subtract(1,'months').endOf('month').format('YYYY-MM-DD');
            getAllPosts(from_date,too_date)
            $("#date_range_filter").attr("style", "display:none !important");
            break;
        case "all_time":
            let to_date = moment(today, "YYYY-MM-DD").format("YYYY-MM-DD");
            getAllPosts('2000-01-01',to_date)
            $("#date_range_filter").attr("style", "display:none !important");
            break;
        case "date_range":
            $("#date_range_filter").css("display", "block");
            break;
    }
}

function dateWiseData() {
    var from = $("#start").val();
    var to = $("#end").val();

    getAllPosts(from,to)
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