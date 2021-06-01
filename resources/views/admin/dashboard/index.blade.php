@extends('admin.layout.master')
@section('page_title','Dashboard')
@section('container')


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


<div class="row mt-3">

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

</div>


@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script>
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

</script>
@show