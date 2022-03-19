@extends('admin.layout.master')
@section('page_title','Manage Users')
@section('users','open')
@section('user','active')
@section('content')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />
@endsection

<div class="">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper p-0">
        <div class="content-header row">

            <div class="content-header-left">
                <div class="row breadcrumbs-top">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="breadcrumb-wrapper">
                                <h3 class="content-header-title fw-bolder float-start mb-0">Profile </h3>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"> <a href="{{route('user.index')}}"> users </a> </li>
                                    <li class="breadcrumb-item"> {{$user->name}} Profile </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<div class="col-12 my-2">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-75">About</h5>
                    <p class="card-text">
                        Tart I love sugar plum I love oat cake. Sweet ⭐️ roll caramels I love jujubes. Topping cake wafer.
                    </p>
                    <div class="mt-2">
                        <h5 class="mb-75">Joined:</h5>
                        <p class="card-text">November 15, 2015</p>
                    </div>
                    <div class="mt-2">
                        <h5 class="mb-75">Lives:</h5>
                        <p class="card-text">New York, USA</p>
                    </div>
                    <div class="mt-2">
                        <h5 class="mb-75">Email:</h5>
                        <p class="card-text">bucketful@fiendhead.org</p>
                    </div>
                    <div class="mt-2">
                        <h5 class="mb-50">Website:</h5>
                        <p class="card-text mb-0">www.pixinvent.com</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" id="homeIcon-tab" data-bs-toggle="tab" href="#homeIcon" aria-controls="home" role="tab" aria-selected="false"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg> Profile </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="profileIcon-tab" data-bs-toggle="tab" href="#profileIcon" aria-controls="profile" role="tab" aria-selected="true"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tool">
                                    <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                                </svg> Categorie </a>
                        </li>
                        <li class="nav-item">
                            <a href="disabledIcon" id="disabledIcon-tab" class="nav-link disabled"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye-off">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                    <line x1="1" y1="1" x2="23" y2="23"></line>
                                </svg> Tags </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="aboutIcon-tab" data-bs-toggle="tab" href="#aboutIcon" aria-controls="about" role="tab" aria-selected="false"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg> Posts </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane" id="homeIcon" aria-labelledby="homeIcon-tab" role="tabpanel">
                            <p>
                                Candy canes donut chupa chups candy canes lemon drops oat cake wafer. Cotton candy candy canes marzipan
                                carrot cake. Sesame snaps lemon drops candy marzipan donut brownie tootsie roll. Icing croissant bonbon
                                biscuit gummi bears. Pudding candy canes sugar plum cookie chocolate cake powder croissant.
                            </p>
                            <p>
                                Carrot cake tiramisu danish candy cake muffin croissant tart dessert. Tiramisu caramels candy canes
                                chocolate cake sweet roll liquorice icing cupcake. Candy cookie sweet roll bear claw sweet roll.
                            </p>
                        </div>
                        <div class="tab-pane active" id="profileIcon" aria-labelledby="profileIcon-tab" role="tabpanel">
                            <p>
                                Dragée jujubes caramels tootsie roll gummies gummies icing bonbon. Candy jujubes cake cotton candy.
                                Jelly-o lollipop oat cake marshmallow fruitcake candy canes toffee. Jelly oat cake pudding jelly beans
                                brownie lemon drops ice cream halvah muffin. Brownie candy tiramisu macaroon tootsie roll danish.
                            </p>
                            <p>
                                Croissant pie cheesecake sweet roll. Gummi bears cotton candy tart jelly-o caramels apple pie jelly
                                danish marshmallow. Icing caramels lollipop topping. Bear claw powder sesame snaps.
                            </p>
                        </div>
                        <div class="tab-pane" id="disabledIcon" aria-labelledby="disabledIcon-tab" role="tabpanel">
                            <p>
                                Chocolate croissant cupcake croissant jelly donut. Cheesecake toffee apple pie chocolate bar biscuit
                                tart croissant. Lemon drops danish cookie. Oat cake macaroon icing tart lollipop cookie sweet bear claw.
                            </p>
                        </div>
                        <div class="tab-pane" id="aboutIcon" aria-labelledby="aboutIcon-tab" role="tabpanel">
                            <p>
                                Gingerbread cake cheesecake lollipop topping bonbon chocolate sesame snaps. Dessert macaroon bonbon
                                carrot cake biscuit. Lollipop lemon drops cake gingerbread liquorice. Sweet gummies dragée. Donut bear
                                claw pie halvah oat cake cotton candy sweet roll. Cotton candy sweet roll donut ice cream.
                            </p>
                            <p>
                                Halvah bonbon topping halvah ice cream cake candy. Wafer gummi bears chocolate cake topping powder.
                                Sweet marzipan cheesecake jelly-o powder wafer lemon drops lollipop cotton candy.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('js')

@endsection