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
                        let img = `<img src="/images/`+full.image+`" width="80" height="50" class="shadow-sm rounded">`;
                        return img;
                      }
                    },
                    {
                        "render": function(data, type, full, meta) {
                            let link = `<div class="mt-2">
                                <a style="font-size:1rem" data-toggle="tooltip" data-placement="top" title="`+full.title+`" href="edit_post/`+full.id+`">`+full.title.substr(0,40) + '...' +`</a>
                                    <br> date: <span class="small text-muted text-dark">`+moment(full.created_at).format("DD-MM-YYYY h:m:s")+`</span>
                                </div>`;
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
                            return (
                                ` <div class="d-flex justify-content-center">
                                    <a data-toggle="tooltip" data-placement="top" title="view post" href="`+view_post+`/`+full.id+`"class="btn btn-info text-white ml-2 card_shadow round">
                                    <i class="far fa-eye"></i></a>
                                    <a href="edit_post/`+full.id+`" onclick="viewRecord(`+ full.id +`, '` + full.name +`')" type="button" class="btn btn-primary card_shadow round ml-2" data-toggle="tooltip" data-placement="top" title="edit post"><i class="fas fa-pen"></i></a>
                                    <button data-toggle="tooltip" data-placement="top" title="delete post" onclick="deleteRecord(`+ full.id + `)" type="button" class="btn btn-danger text-white ml-2 card_shadow round">
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
            $('[data-toggle="tooltip"]').tooltip();
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
            let to_date = moment(today).format("YYYY-MM-DD");
            getAllPosts('2000-01-01',to_date);
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