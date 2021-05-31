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
        <div class="card p-4">

            <canvas id="myChart"></canvas>

        </div>

    </div>

    <div class="col-md-7">

        <div class="card p-4">

            <canvas id="visitorChart"></canvas>

        </div>

    </div>

</div>


@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script>

        var ctx = document.getElementById('myChart');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
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
                    hoverOffset: 10
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
                text: 'Chart.js Pie Chart'
            }
            }
        },
        });

    </script>

    
<script>

    var ctx = document.getElementById('visitorChart').getContext('2d');
    var chart = new Chart(ctx , {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','July'],
            datasets : [{
                label: 'visitor',
                backgroundColor: '#f48fb1',
                borderColor:'#ec407a',
                data :[0,10,5,2,20,30,43],
                fill: true,
            }]
        },
        options: {}
    });

</script>

@show