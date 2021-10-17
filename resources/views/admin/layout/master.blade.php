<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
  <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
  <meta charset="utf-8" />
  <title>@yield('page_title')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
  <link rel="apple-touch-icon" href="pages/ico/60.png">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="apple-touch-icon" sizes="76x76" href="pages/ico/76.png">
  <link rel="apple-touch-icon" sizes="120x120" href="pages/ico/120.png">
  <link rel="apple-touch-icon" sizes="152x152" href="pages/ico/152.png">
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
  <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css"/>
  <link href="{{asset('admin/assets/plugins/pace/pace-theme-flash.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('admin/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
  <script src="https://kit.fontawesome.com/5fcfcbf541.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="{{asset('admin/assets/plugins/jquery-scrollbar/jquery.scrollbar.css')}}" rel="stylesheet" type="text/css" media="screen" />
  <link href="{{asset('admin/assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" media="screen" />
  <link class="main-stylesheet" href="{{asset('admin/pages/css/themes/corporate.css')}}" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
  <link href="{{asset('admin/assets/plugins/bootstrap-tag/bootstrap-tagsinput.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('admin/assets/plugins/dropzone/css/dropzone.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('admin/assets/plugins/bootstrap-datepicker/css/datepicker3.css')}}" rel="stylesheet" type="text/css" media="screen">
  <link href="{{asset('admin/assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css')}}" rel="stylesheet" type="text/css" media="screen">
  <link href="{{asset('admin/assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" media="screen">

  <link class="main-stylesheet" href="{{asset('admin/assets/css/style.css')}}" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog==" crossorigin="anonymous" />
  <style>
    .loader_container {
      width: 100%;
      height: 100%;
      background-color: #fff;
      opacity: 0.9;
      position: absolute;
      top: 0px;
      right: 0px;
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1;
    }

    .loader {
      width: 30px;
      height: 30px;
      border: 2px solid;
      color: #111;
      border-radius: 50%;
      border-top-color: transparent;
      animation: loader 0.8s linear infinite;
    }

    @keyframes loader {
      25% {
        color: #37b0e9;
      }

      50% {
        color: #6d5eac;
      }

      75% {
        color: #37b0e9;
      }

      100% {
        color: #6d5eac;
      }

      to {
        transform: rotate(360deg);
      }
    }
    table th, table td{
        white-space: nowrap !important;
    }
    table tbody tr td{
        vertical-align: middle !important;
    }
    .btn_cirlce {
      border-radius: 100px;
      padding: 8px 9px;
    }
    .table tbody tr td {
        padding:8px;
    }

    /* width */
    ::-webkit-scrollbar {
      width: 10px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
      background: #f1f1f1;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
      background: #b5b5b5;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
      background: #555;
    }
    .page-sidebar .sidebar-menu .menu-items > li > a > .title {
      width: 80% !important;
    }
    .page-sidebar .sidebar-menu .menu-items > li > a > .arrow {
      float: right;
      padding-right: 0px !important;
    }
    .fr-toolbar , .second-toolbar{
        border-radius: 2px !important;
    }
    #logo {
        display: none;
    }
    .fr-toolbar {
      background-color: #f8f9fa !important;
    }
  </style>
</head>
<body class="fixed-header windows desktop js-focus-visible pace-done menu-pin">

  <nav class="page-sidebar" data-pages="sidebar">
    <div class="sidebar-header">
      @if( Session('dashboard_logo') != null && Session('dashboard_logo') != '' )
        <img src="{{asset('settings')}}/{{Session('dashboard_logo')}}" alt="logo" class="brand" data-src="{{asset('settings')}}/{{Session('dashboard_logo')}}" data-src-retina="{{asset('settings')}}/{{Session('dashboard_logo')}}" width="78" height="22">
      @else
        <p>Dashboard</p>
      @endif
      <div class="sidebar-header-controls" style="margin-left:58px">
        <button aria-label="Pin Menu" type="button" class="btn btn-icon-link invert d-lg-inline-block d-xlg-inline-block d-md-inline-block d-sm-none d-none" data-toggle-pin="sidebar">
          <i class="pg-icon"></i>
        </button>
      </div>
    </div>
    
    @include('admin.layout.sidebar')

  </nav>

  <div class="page-container ">
    <div class="header ">
      <a href="#" class="btn-link toggle-sidebar d-lg-none pg-icon btn-icon-link" data-toggle="sidebar">
        menu</a>
      <div class="">
        <div class="brand inline  m-l-10 ">
        @if( Session('dashboard_logo') != null && Session('dashboard_logo') != '' )
          <img src="{{asset('settings')}}/{{Session('dashboard_logo')}}" alt="logo" class="brand" data-src="{{asset('settings')}}/{{Session('dashboard_logo')}}" data-src-retina="{{asset('settings')}}/{{Session('dashboard_logo')}}" style="width:50px">
        @else
          <strong>Dashboard</strong>
        @endif
          <!-- <img src="{{asset('admin/assets/img/logo.png')}}" alt="logo"  width="78" height="22"> -->
        </div>
        <span class="ml-3 font-weight-bold" id="showDateTime"></span>        
        
      </div>
      <div class="d-flex align-items-center">
        <div class="dropdown pull-right d-lg-block d-none">
          <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="profile dropdown">
            <span class="thumbnail-wrapper d32 circular inline">
              <img src="{{asset('users')}}/{{Auth::user()->profile_pic}}" width="32" height="32">
            </span>
          </button>
          <div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
            <a href="#" class="dropdown-item">
              <span>Signed in as <br /> <b>{{Auth::user()->name}}</b> </span>
            </a>
            <div class="dropdown-divider"></div>
              @if( strtolower(Session('role_name')) == "admin" || strtolower(Session('role_name')) == "administrator" || 
                  strtolower(Session('role_name')) == "super admin" || strtolower(Session('role_name')) == "super administrator") 
                <a href="{{route('setting.index')}}" class="dropdown-item"><i class="fas fa-cog"></i> Settings</a>
              @endif

            <a href="{{route('logout.user')}}" class="dropdown-item text-danger"><i class="fas fa-power-off"></i> Logout</a>
            
          </div>
        </div>
      </div>
    </div>


    <!-- main content -->
    <div class="page-content-wrapper ">
      <div class="content">
        <div class=" container-fluid ">
          @section('container')

          @show
        </div>
      </div>

    </div>

  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.0-alpha.1/jquery-ui.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{asset('admin/assets/plugins/pace/pace.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('admin/assets/plugins/liga.js')}}" type="text/javascript"></script>
  <script src="{{asset('admin/assets/plugins/modernizr.custom.js')}}" type="text/javascript"></script>
  <script src="{{asset('admin/assets/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('admin/assets/plugins/popper/umd/popper.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('admin/assets/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('admin/assets/plugins/jquery/jquery-easy.js')}}" type="text/javascript"></script>
  <script src="{{asset('admin/assets/plugins/jquery-unveil/jquery.unveil.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('admin/assets/plugins/jquery-ios-list/jquery.ioslist.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('admin/assets/plugins/jquery-actual/jquery.actual.min.js')}}"></script>
  <script src="{{asset('admin/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('admin/assets/plugins/select2/js/select2.full.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('admin/assets/plugins/classie/classie.js')}}"></script>
  <script src="{{asset('admin/pages/js/pages.js')}}"></script>
  <script src="{{asset('admin/assets/js/scripts.js')}}" type="text/javascript"></script>
  <script src="{{asset('admin/assets/js/scripts.js')}}" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

  <script type="text/javascript" src="{{asset('admin/assets/plugins/jquery-autonumeric/autoNumeric.js')}}"></script>
  <script type="text/javascript" src="{{asset('admin/assets/plugins/dropzone/dropzone.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('admin/assets/plugins/bootstrap-tag/bootstrap-tagsinput.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('admin/assets/plugins/jquery-inputmask/jquery.inputmask.min.js')}}"></script>
  <script src="{{asset('admin/assets/plugins/bootstrap-form-wizard/js/jquery.bootstrap.wizard.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('admin/assets/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('admin/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}" type="text/javascript"></script>
  <script src="{{asset('admin/assets/plugins/quill/quill.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('admin/assets/plugins/moment/moment.min.js')}}"></script>
  <script src="{{asset('admin/assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
  <script src="{{asset('admin/assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js')}}"></script>
  <script src="{{asset('admin/assets/plugins/bootstrap-typehead/typeahead.bundle.min.js')}}"></script>
  <script src="{{asset('admin/assets/plugins/bootstrap-typehead/typeahead.jquery.min.js')}}"></script>
  <script src="{{asset('admin/assets/plugins/handlebars/handlebars-v4.0.5.js')}}"></script>
  <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  <script>
    var base_url = window.location.origin;
    var notyf = new Notyf({
      duration: 2000,
      position: {
        x: 'right',
        y: 'top',
      },
    });
   
    function showDateTime() {
      $("#showDateTime").html(moment().format('MMMM Do YYYY - h:mm:ss a - dddd'));
    }

    setInterval(() => {
      showDateTime();
    }, 1000);
    
  </script>

  @section('scripts')
  @show
</body>
</html>