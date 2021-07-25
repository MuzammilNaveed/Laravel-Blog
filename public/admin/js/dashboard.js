$(document).ready(function() {
    getAllCategories();
    getAllTags();
    var today = new Date();
    let to_date = moment(today).format("YYYY-MM-DD");
    getAllPosts('2000-01-01',to_date);
    getAllUsers();
});

function getAllCategories() {
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        type: "GET",
        url: categories,
        beforeSend: function(data) {
            $("#category_loader").show();
        },
        success: function(data) {
            console.log(data , "a");

            $("#category_table").DataTable().destroy();
            $.fn.dataTable.ext.errMode = "none";
            var tbl = $("#category_table").DataTable({
                data: data,
                pageLength: 5,
                bInfo: true,
                paging: true,
                columns: [
                    {
                        data: null,
                        defaultContent: ""
                    },
                    {
                        "className" : "small",
                        "render": function(data, type, full, meta) {
                            return full.name != null ? full.name : '-';
                        }
                    },
                    {
                        "className" : "small",
                        "render": function(data, type, full, meta) {
                            if(full.created_by != null) {
                                let name = full.created_by.name != null ? full.created_by.name : '-';
                                return `<p class="text-primary" style="cursor: pointer;" onclick="showUserDetails(`+full.created_by.id+`)">`+ name +`</p>`;
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
        },
        complete: function(data) {
            $("#category_loader").hide();
            $('[data-toggle="tooltip"]').tooltip();
        },
        error: function(e) {
            $("#category_loader").hide();
            console.log(e);
        }
    });
}

function showUserDetails(id) {
    $("#userViewModal").modal('show');
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        type: "post",
        url: user_detail,
        data: {id:id,page:'post'},
        beforeSend: function(data) {
            $("#userprofile_loader").show();
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
            $("#userprofile_loader").hide();
        },
        error: function(e) {
            $("#userprofile_loader").hide();
            console.log(e);
        }
    });
    
}

function getAllTags() {    
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        type: "GET",
        url: "tags",
        dataType:'json',
        beforeSend:function(data) {
            $("#tag_loader").show();
        },
        success: function(data) {

            $('#tags_table').DataTable().destroy();
            $.fn.dataTable.ext.errMode = 'none';
            var tbl = $('#tags_table').DataTable({
                data: data,
                "pageLength":5,
                "bInfo": true,
                "paging": true,
                columns: [{
                    "data": null,
                    "defaultContent": ""
                },
                {
                    "render": function (data, type, full, meta) {
                        return full.name != null ? full.name : '--';
                    }
                },
                {
                    "render": function (data, type, full, meta) {
                        if(full.created_by != null) {
                            let name = full.created_by.name != null ? full.created_by.name : '-';
                            return `<p class="text-primary" style="cursor: pointer;" onclick="showUserDetails(`+full.created_by.id+`)">`+ name +`</p>`;
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
            $("#tag_loader").hide();
            $('[data-toggle="tooltip"]').tooltip();
        },
        error: function(e) {
            $("#tag_loader").hide();
            console.log(e);
        }
    });
}

function getAllPosts(from,to) {
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        type: "GET",
        url: "posts",
        data: {from:from,to:to},
        beforeSend: function(data) {
            $("#post_loader").show();
        },
        success: function(data) {
            $("#post_table").DataTable().destroy();
            $.fn.dataTable.ext.errMode = "none";
            var tbl = $("#post_table").DataTable({
                data: data,
                pageLength: 5,
                bInfo: true,
                paging: true,
                columns: [
                    {
                        data: null,
                        defaultContent: ""
                    },
                    {
                        "render": function(data, type, full, meta) {
                            let link = `<div class="mt-2">
                                <a style="font-size:1rem" data-toggle="tooltip" data-placement="top" title="`+full.title+`" href="edit_post/`+full.id+`">`+full.title.substr(0,25) + '...' +`</a>
                                    <br> date: <span class="small text-muted text-dark">`+moment(full.created_at).format("DD-MM-YYYY h:m:s")+`</span>
                                </div>`;
                            return link;
                        }
                    },
                    {
                        "render": function(data, type, full, meta) {
                            if(full.user != null) {
                                let name = full.user.name != null ? full.user.name : '-';
                                return `<p class="text-primary" style="cursor: pointer;" onclick="showUserDetails(`+full.user.id+`)">`+ name +`</p>`;
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

        },
        complete: function(data) {
            $("#post_loader").hide();
            $('[data-toggle="tooltip"]').tooltip();
        },
        error: function(e) {
            $("#post_loader").hide();
            console.log(e);
        }
    });
}

function getAllUsers() {
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        type: "GET",
        url: get_all_users,
        dataType: "json",
        beforeSend: function(data) {
            $("#user_loader").show();
        },
        success: function(data) {
            console.log(data);

            $("#user_table").DataTable().destroy();
            $.fn.dataTable.ext.errMode = "none";
            var tbl = $("#user_table").DataTable({
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
                        "className" : "text-left",
                        "render": function(data, type, full, meta) {
                            return `
                                <div>
                                    <p> <strong class="text-primary" style="cursor: pointer;" onclick="showUserDetails(`+full.id+`)">`+(full.name != null ? full.name : "-")+`</strong> <br> <span class="text-muted small"> `+(full.email)+`</span> </p>
                                </div>`;
                        }
                    },
                    {
                    "render": function(data, type, full, meta) {
                        let active = `<span class="badge text-white bg-success">Active</span>`;
                        let deactive = `<span class="badge text-white bg-danger">De-Active</span>`;
                        return full.status == 1 ? active : deactive;
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


            $("#role_select").on('change', function () {
                tbl.column(4).search($(this).val()).draw();
            });

        },
        complete: function(data) {
            $("#user_loader").hide();
            $('[data-toggle="tooltip"]').tooltip();
        },
        error: function(e) {
            $("#user_loader").hide();
            console.log(e);
        }
    });
}


    // var ctx = document.getElementById('visitorChart').getContext('2d');
    // var chart = new Chart(ctx , {
    //     type: 'line',
    //     data: {
    //         labels: ['Jan','Feb','Mar','Apr','May','Jun','July','aug','sep'],
    //         datasets : [{
    //             label: 'visitor',
    //             backgroundColor: '#f48fb1',
    //             borderColor:'#ec407a',
    //             data :[0,10,5,2,20,30,43,301,440],
    //             fill: true,
    //         }]
    //     },
    //     options: {
    //         animations: {
    //             y: {
    //                 easing: 'easeInOutElastic',
    //                 from: (ctx) => {
    //                     if (ctx.type === 'data') {
    //                         if (ctx.mode === 'default' && !ctx.dropped) {
    //                         ctx.dropped = true;
    //                         return 0;
    //                         }
    //                     }
    //                 }
    //             }
    //         },
    //     }
    // });


    // var delayed;
    // var ctx = document.getElementById('myplatformChart');
    // var myChart = new Chart(ctx, {
    //     type: 'polarArea',
    //     data: {
    //         labels: <?php echo $platform_names; ?>,
    //         datasets: [{
    //             label: '# of Votes',
    //             data: <?php echo $platform_counts; ?>,
    //             backgroundColor: [
    //                 '#1976d2',
    //                 '#eeeeee',
    //                 '#388e3c',
    //             ],
    //             borderColor: [
    //                 '#fff'
    //             ],
    //             borderWidth: 2,
    //             hoverOffset: 5
    //         }]
    //     },
    //     options: {
    //         responsive: true,
    //         plugins: {
    //             legend: {
    //                 position: 'bottom',
    //             },
    //             title: {
    //                 display: true,
    //                 text: 'OS Traffic'
    //             }
    //         },
    //         animation: {
    //             onComplete: () => {
    //                 delayed = true;
    //             },
    //             delay: (context) => {
    //                 let delay = 0;
    //                 if (context.type === 'data' && context.mode === 'default' && !delayed) {
    //                 delay = context.dataIndex * 300 + context.datasetIndex * 100;
    //                 }
    //                 return delay;
    //             },
    //         },
    //     },
    // });

    // var delayed;
    // var ctx = document.getElementById('countryChart');
    // var myChart = new Chart(ctx, {
    //     type: 'bar',
    //     data: {
    //         labels: <?php echo $country_names; ?>,
    //         datasets: [{
    //             label: ' Visitors',
    //             data: <?php echo $country_counts; ?>,
    //             backgroundColor: [
    //                 '#1976d2',
    //                 '#eeeeee',
    //                 '#388e3c',
    //             ],
    //             borderColor: [
    //                 '#fff'
    //             ],
    //             borderWidth: 2,
    //             hoverOffset: 5
    //         }]
    //     },
    //     options: {
    //         responsive: true,
    //         plugins: {
    //             legend: {
    //                 position: 'bottom',
    //             },
    //             title: {
    //                 display: true,
    //                 text: 'Country Wise Traffic'
    //             }
    //         },
    //         animation: {
    //             onComplete: () => {
    //                 delayed = true;
    //             },
    //             delay: (context) => {
    //                 let delay = 0;
    //                 if (context.type === 'data' && context.mode === 'default' && !delayed) {
    //                 delay = context.dataIndex * 300 + context.datasetIndex * 100;
    //                 }
    //                 return delay;
    //             },
    //         },
    //     },
    // });
