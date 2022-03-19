@extends('admin.layout.master')
@section('page_title','Dashboard')
@section('dashboard','active')
@section('content')


<div class="container-fluid">

    <h1>Dashboard</h1>

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
@show