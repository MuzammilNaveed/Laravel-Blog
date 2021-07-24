@extends('admin.layout.master')
@section('page_title','Dashboard')
@section('container')

<style>
    .table tbody tr td {
        padding:8px;
    }
</style>
<div class="">
    <div class="row mt-3">

        <div class="col-md-3">
            <div class="card  bg-primary no-margin">
                <div class="card-header ">
                    <div class="card-title">
                        <span class="font-montserrat fs-11 all-caps">Total Posts</span>
                    </div>
                </div>
                <div class="p-l-20 pb-2">
                    <h3 class="no-margin p-b-5">{{$post_count}}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
        <a href="{{route('category.index')}}">
            <div class="card  bg-warning no-margin">
                <div class="card-header ">
                    <div class="card-title">
                        <span class="font-montserrat fs-11 all-caps">Total Categories</span>
                    </div>
                </div>
                <div class="p-l-20 pb-2">
                    <h3 class="no-margin p-b-5">{{$category_count}}</h3>
                </div>
            </div>
        </a>
        </div>

        <div class="col-md-3">
        <a href="{{route('tag.index')}}">
            <div class="card  bg-success no-margin">
                <div class="card-header ">
                    <div class="card-title">
                        <span class="font-montserrat fs-11 all-caps">Total Tags</span>
                    </div>
                </div>
                <div class="p-l-20 pb-2">
                    <h3 class="no-margin p-b-5">{{$tag_count}}</h3>
                </div>
            </div>
        </a>
        </div>

        <div class="col-md-3">
            <a href="{{route('user.index')}}">
            <div class="card no-margin text-white" style="background:#323237">
                <div class="card-header ">
                    <div class="card-title">
                        <span class="font-montserrat fs-11 all-caps">Total Users</span>
                    </div>
                </div>
                <div class="p-l-20 pb-2">
                    <h3 class="no-margin p-b-5">{{$user_count}}</h3>
                </div>
            </div>
            </a>
        </div>

    </div>

    <div class="row mt-3">

    <div class="col-md-3">
            <a href="{{route('user.index')}}">
            <div class="card bg-menu-light no-margin">
                <div class="card-header ">
                    <div class="card-title">
                        <span class="font-montserrat fs-11 all-caps">Total Comments</span>
                    </div>
                </div>
                <div class="p-l-20 pb-2">
                    <h3 class="no-margin p-b-5">{{$comment_count}}</h3>
                </div>
            </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{route('user.index')}}">
            <div class="card  bg-info no-margin">
                <div class="card-header ">
                    <div class="card-title">
                        <span class="font-montserrat fs-11 all-caps">Total Replies</span>
                    </div>
                </div>
                <div class="p-l-20 pb-2">
                    <h3 class="no-margin p-b-5">{{$reply_count}}</h3>
                </div>
            </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{route('user.index')}}">
            <div class="card  bg-complete no-margin">
                <div class="card-header ">
                    <div class="card-title">
                        <span class="font-montserrat fs-11 all-caps">Total Active Posts</span>
                    </div>
                </div>
                <div class="p-l-20 pb-2">
                    <h3 class="no-margin p-b-5">{{$active_post}}</h3>
                </div>
            </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{route('user.index')}}">
            <div class="card  bg-light no-margin">
                <div class="card-header ">
                    <div class="card-title">
                        <span class="font-montserrat fs-11 all-caps">Total In-Active Posts</span>
                    </div>
                </div>
                <div class="p-l-20 pb-2">
                    <h3 class="no-margin p-b-5">{{$inactive_post}}</h3>
                </div>
            </div>
            </a>
        </div>

    </div>
    
</div>


<!-- tags & Categories  -->


<div class="row mt-3">

    <div class="col-md-6">

        <div class="card card_shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title font-weight-bolder">Categories </div>
            </div>
            <div class="card-body">
                <div class="table-responsive sm-m-b-15">
                <table class="table table-hover no-footer text-center w-100 small" id="category_table">
                    <thead>
                    <tr role="row">
                        <th>Sr #</th>
                        <th>Name</th>
                        <th>Created By</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                </div>
            </div>
            <div class="loader_container" style="display:none" id="category_loader">
                <div class="loader"></div>
            </div>
        </div>

    </div>

    <div class="col-md-6">

        <div class="card card_shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title font-weight-bolder">Tags </div>
            </div>
            <div class="card-body">
                <div class="table-responsive sm-m-b-15">
                <table class="table table-hover no-footer w-100 text-center" id="tags_table">
                    <thead>
                    <tr role="row">
                        <th>Sr #</th>
                        <th>Name</th>
                        <th>Created By</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                </div>
            </div>
            <div class="loader_container" style="display:none" id="tag_loader">
                <div class="loader"></div>
            </div>
        </div>

    </div>

</div>

<div class="row mt-3">

    <div class="col-md-6">

        <div class="card card_shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title font-weight-bolder">Post </div>
            </div>
            <div class="card-body">
                <div class="table-responsive sm-m-b-15">
                <table class="table table-hover no-footer w-100" id="post_table">
                    <thead>
                    <tr role="row">
                        <th>Sr #</th>
                        <th>Name</th>
                        <th>Created By</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                </div>
            </div>
            <div class="loader_container" style="display:none" id="post_loader">
                <div class="loader"></div>
            </div>
        </div>

    </div>

    <div class="col-md-6">

        <div class="card card_shadow">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title font-weight-bolder">User </div>
            </div>
            <div class="card-body">
                <div class="table-responsive sm-m-b-15">
                <table class="table table-hover no-footer w-100 text-center" id="user_table">
                    <thead>
                    <tr role="row">
                        <th>Sr #</th>
                        <th>Name</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                </div>
            </div>
            <div class="loader_container" style="display:none" id="user_loader">
                <div class="loader"></div>
            </div>
        </div>

    </div>

</div>



<!-- grapgs -->
<!-- <div class="row mt-3">

    <div class="col-md-5">
        <div class="card p-3">

            <canvas id="myChart"></canvas>

        </div>

    </div>

    <div class="col-md-7">

        <div class="card p-4">

            <canvas id="visitorChart"></canvas>

        </div>

    </div>

</div>


<div class="row mt-3">

    <div class="col-md-5">
        <div class="card p-3">

            <canvas id="myplatformChart"></canvas>

        </div>

    </div>

    <div class="col-md-7">

        <div class="card p-4">

            <canvas id="countryChart"></canvas>

        </div>

    </div>

</div> -->

<!-- user view modal -->
<div class="modal fade stick-up" id="userViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

        <h5 class="modal-title" id="exampleModalLabel"> <span class="text-primary" id="username"></span> Detail</h5>
      </div>
      <div class="modal-body mt-2" id="user_detail">

      </div>
    </div>

    <div class="loader_container" id="userprofile_loader">
      <div class="loader"></div>
    </div>

  </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
    var categories = "{{url('categories')}}";
    var user_detail = "{{url('user_detail')}}";
    var view_post = "{{url('view_post')}}";
    var get_all_users = "{{url('get_all_users')}}";
</script>
<script>
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


</script>

    <!-- <script>
        var delayed;
        var ctx = document.getElementById('myChart');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo $browser_names; ?>,
                datasets: [{
                    label: '# of Votes',
                    data: <?php echo $browser_counts; ?>,
                    backgroundColor: [
                        '#ec407a',
                        '#00838f',
                        '#fdd835',
                        '#283593',
                        '#7b1fa2',
                        '#ff8f00'
                    ],
                    borderColor: [
                        '#fff'
                    ],
                    borderWidth: 2,
                    hoverOffset: 20
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Browser Traffic'
                    }
                },
                animation: {
                    onComplete: () => {
                        delayed = true;
                    },
                    delay: (context) => {
                        let delay = 0;
                        if (context.type === 'data' && context.mode === 'default' && !delayed) {
                        delay = context.dataIndex * 300 + context.datasetIndex * 100;
                        }
                        return delay;
                    },
                },
            },
        });

    </script>

    
<script>

    var ctx = document.getElementById('visitorChart').getContext('2d');
    var chart = new Chart(ctx , {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','July','aug','sep'],
            datasets : [{
                label: 'visitor',
                backgroundColor: '#f48fb1',
                borderColor:'#ec407a',
                data :[0,10,5,2,20,30,43,301,440],
                fill: true,
            }]
        },
        options: {
            animations: {
                y: {
                    easing: 'easeInOutElastic',
                    from: (ctx) => {
                        if (ctx.type === 'data') {
                            if (ctx.mode === 'default' && !ctx.dropped) {
                            ctx.dropped = true;
                            return 0;
                            }
                        }
                    }
                }
            },
        }
    });

</script>


<script>
    var delayed;
    var ctx = document.getElementById('myplatformChart');
    var myChart = new Chart(ctx, {
        type: 'polarArea',
        data: {
            labels: <?php echo $platform_names; ?>,
            datasets: [{
                label: '# of Votes',
                data: <?php echo $platform_counts; ?>,
                backgroundColor: [
                    '#1976d2',
                    '#eeeeee',
                    '#388e3c',
                ],
                borderColor: [
                    '#fff'
                ],
                borderWidth: 2,
                hoverOffset: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                title: {
                    display: true,
                    text: 'OS Traffic'
                }
            },
            animation: {
                onComplete: () => {
                    delayed = true;
                },
                delay: (context) => {
                    let delay = 0;
                    if (context.type === 'data' && context.mode === 'default' && !delayed) {
                    delay = context.dataIndex * 300 + context.datasetIndex * 100;
                    }
                    return delay;
                },
            },
        },
    });

</script>


<script>
    var delayed;
    var ctx = document.getElementById('countryChart');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo $country_names; ?>,
            datasets: [{
                label: ' Visitors',
                data: <?php echo $country_counts; ?>,
                backgroundColor: [
                    '#1976d2',
                    '#eeeeee',
                    '#388e3c',
                ],
                borderColor: [
                    '#fff'
                ],
                borderWidth: 2,
                hoverOffset: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                title: {
                    display: true,
                    text: 'Country Wise Traffic'
                }
            },
            animation: {
                onComplete: () => {
                    delayed = true;
                },
                delay: (context) => {
                    let delay = 0;
                    if (context.type === 'data' && context.mode === 'default' && !delayed) {
                    delay = context.dataIndex * 300 + context.datasetIndex * 100;
                    }
                    return delay;
                },
            },
        },
    });

</script> -->
@show