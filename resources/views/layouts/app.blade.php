<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="Creative Tim">
    <title>Radio</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Argon CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor.min.css') }}" rel="stylesheet">

    <base href="https://demos.creative-tim.com/argon-dashboard-pro/pages/dashboards/">
</head>
{{--
<body>
<!-- Navbar -->
<!-- Main content -->
<main class="main-content">
    @yield('content')
</main>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/vendor.chart.min.js') }}"></script>
<script src="{{ asset('js/vendor.min.js') }}"></script>
</body>
--}}
<body class="@yield('body-class')">
<!-- Sidenav -->
<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header d-flex align-items-center">
            <a class="navbar-brand" href="#">
                <img src="https://demos.creative-tim.com/argon-dashboard-pro/assets/img/brand/blue.png"
                     class="navbar-brand-img" alt="...">
            </a>
            <div class="ml-auto">
                <!-- Sidenav toggler -->
                <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="fas fa-rocket text-primary"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-radio-collapse" data-toggle="collapse" role="button"
                           aria-expanded="true" aria-controls="navbar-radio-collapse">
                            <i class="fas fa-podcast text-default"></i>
                            <span class="nav-link-text">Radio</span>
                        </a>
                        <div class="collapse" id="navbar-radio-collapse">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('home') }}" class="nav-link">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">Alternative</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-conteudo-collapse" data-toggle="collapse" role="button"
                           aria-expanded="true" aria-controls="navbar-conteudo-collapse">
                            <i class="fas fa-icons"></i>
                            <span class="nav-link-text">Conteudo</span>
                        </a>
                        <div class="collapse" id="navbar-conteudo-collapse">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('home') }}" class="nav-link">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">Alternative</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <!-- Nav items -->
                <div>
                    <!-- Divider -->
                    <hr class="my-3">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="#navbar-dashboards" data-toggle="collapse" role="button"
                               aria-expanded="true" aria-controls="navbar-dashboards">
                                <i class="fas fa-house-damage text-primary"></i>
                                <span class="nav-link-text">Dashboards</span>
                            </a>
                            <div class="collapse show" id="navbar-dashboards">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">Dashboard</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">Alternative</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-examples" data-toggle="collapse" role="button"
                               aria-expanded="false" aria-controls="navbar-examples">
                                <i class="fas fa-magic text-info"></i>
                                <span class="nav-link-text">Examples</span>
                            </a>
                            <div class="collapse" id="navbar-examples">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">Pricing</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">Login</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">Register</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">Lock</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">Timeline</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">Profile</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-components" data-toggle="collapse" role="button"
                               aria-expanded="false" aria-controls="navbar-components">
                                <i class="far fa-object-ungroup text-orange"></i>
                                <span class="nav-link-text">Components</span>
                            </a>
                            <div class="collapse" id="navbar-components">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">Buttons</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">Cards</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">Grid</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">Notifications</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">Icons</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">Typography</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#navbar-multilevel" class="nav-link" data-toggle="collapse"
                                           role="button"
                                           aria-expanded="true" aria-controls="navbar-multilevel">Multi level</a>
                                        <div class="collapse show" id="navbar-multilevel" style="">
                                            <ul class="nav nav-sm flex-column">
                                                <li class="nav-item">
                                                    <a href="#!" class="nav-link ">Third level menu</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#!" class="nav-link ">Just another link</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#!" class="nav-link ">One last link</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-forms" data-toggle="collapse" role="button"
                               aria-expanded="false" aria-controls="navbar-forms">
                                <i class="fab fa-wpforms text-pink"></i>
                                <span class="nav-link-text">Forms</span>
                            </a>
                            <div class="collapse" id="navbar-forms">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">Elements</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">Components</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../../pages/forms/validation.html" class="nav-link">Validation</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-tables" data-toggle="collapse" role="button"
                               aria-expanded="false" aria-controls="navbar-tables">
                                <i class="fas fa-table text-default"></i>
                                <span class="nav-link-text">Tables</span>
                            </a>
                            <div class="collapse" id="navbar-tables">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="../../pages/tables/tables.html" class="nav-link">Tables</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../../pages/tables/sortable.html" class="nav-link">Sortable</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../../pages/tables/datatables.html" class="nav-link">Datatables</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-maps" data-toggle="collapse" role="button"
                               aria-expanded="false" aria-controls="navbar-maps">
                                <i class="fas fa-map-marked-alt text-primary"></i>
                                <span class="nav-link-text">Maps</span>
                            </a>
                            <div class="collapse" id="navbar-maps">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="../../pages/maps/google.html" class="nav-link">Google</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../../pages/maps/vector.html" class="nav-link">Vector</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../pages/widgets.html">
                                <i class="fas fa-boxes text-green"></i>
                                <span class="nav-link-text">Widgets</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../pages/charts.html">
                                <i class="fas fa-chart-pie text-info"></i>
                                <span class="nav-link-text">Charts</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../pages/calendar.html">
                                <i class="far fa-calendar-alt text-red"></i>
                                <span class="nav-link-text">Calendar</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Divider -->
                <hr class="my-3">
                <!-- Heading -->
                <h6 class="navbar-heading p-0 text-muted">Documentation</h6>
                <!-- Navigation -->
                <ul class="navbar-nav mb-md-3">
                    <li class="nav-item">
                        <a class="nav-link" href="../../docs/getting-started/overview.html" target="_blank">
                            <i class="fas fa-rocket"></i>
                            <span class="nav-link-text">Getting started</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../docs/foundation/colors.html" target="_blank">
                            <i class="fas fa-palette"></i>
                            <span class="nav-link-text">Foundation</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../docs/components/alerts.html" target="_blank">
                            <i class="fas fa-wrench"></i>
                            <span class="nav-link-text">Components</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../docs/plugins/charts.html" target="_blank">
                            <i class="fas fa-puzzle-piece"></i>
                            <span class="nav-link-text">Plugins</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- Main content -->
<div class="main-content app">
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom" hidden>
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Search form -->
                <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main" hidden>
                    <div class="form-group mb-0">
                        <div class="input-group input-group-alternative input-group-merge">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input class="form-control" placeholder="Search" type="text">
                        </div>
                    </div>
                    <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main"
                            aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </form>
                <!-- Navbar links -->
                <ul class="navbar-nav align-items-center ml-md-auto">
                    <li class="nav-item d-xl-none">
                        <!-- Sidenav toggler -->
                        <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin"
                             data-target="#sidenav-main">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item d-sm-none" hidden>
                        <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                            <i class="fas fa-search"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">
                            <i class="fas fa-bell"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right py-0 overflow-hidden">
                            <!-- Dropdown header -->
                            <div class="px-3 py-3">
                                <h6 class="text-sm text-muted m-0">You have <strong class="text-primary">13</strong>
                                    notifications.</h6>
                            </div>
                            <!-- List group -->
                            <div class="list-group list-group-flush">
                                <a href="#!" class="list-group-item list-group-item-action">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <!-- Avatar -->
                                            <img alt="Image placeholder" src="../../assets/img/theme/team-1.jpg"
                                                 class="avatar rounded-circle">
                                        </div>
                                        <div class="col ml--2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h4 class="mb-0 text-sm">John Snow</h4>
                                                </div>
                                                <div class="text-right text-muted">
                                                    <small>2 hrs ago</small>
                                                </div>
                                            </div>
                                            <p class="text-sm mb-0">Let's meet at Starbucks at 11:30. Wdyt?</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="#!" class="list-group-item list-group-item-action">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <!-- Avatar -->
                                            <img alt="Image placeholder" src="../../assets/img/theme/team-2.jpg"
                                                 class="avatar rounded-circle">
                                        </div>
                                        <div class="col ml--2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h4 class="mb-0 text-sm">John Snow</h4>
                                                </div>
                                                <div class="text-right text-muted">
                                                    <small>3 hrs ago</small>
                                                </div>
                                            </div>
                                            <p class="text-sm mb-0">A new issue has been reported for Argon.</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="#!" class="list-group-item list-group-item-action">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <!-- Avatar -->
                                            <img alt="Image placeholder" src="../../assets/img/theme/team-3.jpg"
                                                 class="avatar rounded-circle">
                                        </div>
                                        <div class="col ml--2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h4 class="mb-0 text-sm">John Snow</h4>
                                                </div>
                                                <div class="text-right text-muted">
                                                    <small>5 hrs ago</small>
                                                </div>
                                            </div>
                                            <p class="text-sm mb-0">Your posts have been liked a lot.</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="#!" class="list-group-item list-group-item-action">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <!-- Avatar -->
                                            <img alt="Image placeholder" src="../../assets/img/theme/team-4.jpg"
                                                 class="avatar rounded-circle">
                                        </div>
                                        <div class="col ml--2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h4 class="mb-0 text-sm">John Snow</h4>
                                                </div>
                                                <div class="text-right text-muted">
                                                    <small>2 hrs ago</small>
                                                </div>
                                            </div>
                                            <p class="text-sm mb-0">Let's meet at Starbucks at 11:30. Wdyt?</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="#!" class="list-group-item list-group-item-action">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <!-- Avatar -->
                                            <img alt="Image placeholder" src="../../assets/img/theme/team-5.jpg"
                                                 class="avatar rounded-circle">
                                        </div>
                                        <div class="col ml--2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h4 class="mb-0 text-sm">John Snow</h4>
                                                </div>
                                                <div class="text-right text-muted">
                                                    <small>3 hrs ago</small>
                                                </div>
                                            </div>
                                            <p class="text-sm mb-0">A new issue has been reported for Argon.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- View all -->
                            <a href="#!" class="dropdown-item text-center text-primary font-weight-bold py-3">View
                                all</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown" hidden>
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">
                            <i class="fas fa-th-large"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-dark bg-default dropdown-menu-right">
                            <div class="row shortcuts px-4">
                                <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                      <i class="ni ni-calendar-grid-58"></i>
                    </span>
                                    <small>Calendar</small>
                                </a>
                                <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-orange">
                      <i class="ni ni-email-83"></i>
                    </span>
                                    <small>Email</small>
                                </a>
                                <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                      <i class="ni ni-credit-card"></i>
                    </span>
                                    <small>Payments</small>
                                </a>
                                <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-green">
                      <i class="ni ni-books"></i>
                    </span>
                                    <small>Reports</small>
                                </a>
                                <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-purple">
                      <i class="ni ni-pin-3"></i>
                    </span>
                                    <small>Maps</small>
                                </a>
                                <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-yellow">
                      <i class="ni ni-basket"></i>
                    </span>
                                    <small>Shop</small>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav align-items-center ml-auto ml-md-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">
                            <div class="media align-items-center">
                                <span class="avatar avatar-sm rounded-circle">
                                    <img alt="Image placeholder"
                                         src="https://demos.creative-tim.com/argon-dashboard-pro/assets/img/theme/team-1.jpg">
                                </span>
                                <div class="media-body ml-2 d-none d-lg-block">
                                    <span class="mb-0 text-sm  font-weight-bold">John Snow</span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Bem vindo!</h6>
                            </div>
                            <a href="#!" class="dropdown-item">
                                <i class="fas fa-fw fa-user-edit"></i>
                                <span>Meu perfil</span>
                            </a>
                            <a href="#!" class="dropdown-item">
                                <i class="fas fa-fw fa-cogs"></i>
                                <span>Settings</span>
                            </a>
                            <a href="#!" class="dropdown-item">
                                <i class="fas fa-fw fa-history"></i>
                                <span>Activity</span>
                            </a>
                            <a href="#!" class="dropdown-item">
                                <i class="fas fa-fw fa-question-circle"></i>
                                <span>Support</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="">
                                @csrf
                                <button type="submit" class="btn-link dropdown-item">
                                    <i class="fas fa-fw fa-user-lock"></i>
                                    <span>Sair</span>
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Header -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active">Dashboards</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5">
                        <div class="d-flex justify-content-end navbar-dark">
                            <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom py-0 border-0">
                                <ul class="navbar-nav align-items-center ml-auto ml-md-0">
                                    <li class="nav-item d-xl-none">
                                        <!-- Sidenav toggler -->
                                        <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin"
                                             data-target="#sidenav-main">
                                            <div class="sidenav-toggler-inner">
                                                <i class="sidenav-toggler-line"></i>
                                                <i class="sidenav-toggler-line"></i>
                                                <i class="sidenav-toggler-line"></i>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown"
                                           aria-haspopup="true"
                                           aria-expanded="false">
                                            <div class="media align-items-center">
                                <span class="avatar avatar-sm rounded-circle">
                                    <img alt="Image placeholder"
                                         src="https://demos.creative-tim.com/argon-dashboard-pro/assets/img/theme/team-1.jpg">
                                </span>
                                                <div class="media-body ml-2 d-none d-lg-block">
                                                    <span class="mb-0 text-sm  font-weight-bold">John Snow</span>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <div class="dropdown-header noti-title">
                                                <h6 class="text-overflow m-0">Bem vindo!</h6>
                                            </div>
                                            <a href="#!" class="dropdown-item">
                                                <i class="fas fa-fw fa-user-edit"></i>
                                                <span>Meu perfil</span>
                                            </a>
                                            <a href="#!" class="dropdown-item">
                                                <i class="fas fa-fw fa-cogs"></i>
                                                <span>Settings</span>
                                            </a>
                                            <a href="#!" class="dropdown-item">
                                                <i class="fas fa-fw fa-history"></i>
                                                <span>Activity</span>
                                            </a>
                                            <a href="#!" class="dropdown-item">
                                                <i class="fas fa-fw fa-question-circle"></i>
                                                <span>Support</span>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                  style="">
                                                @csrf
                                                <button type="submit" class="btn-link dropdown-item">
                                                    <i class="fas fa-fw fa-user-lock"></i>
                                                    <span>Sair</span>
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                @yield('header-content')
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6 flex-column d-flex flex-grow-1">
    @yield('content')
    <!-- Footer -->
        <footer class="footer pt-0 mt-auto">
            <div class="row align-items-center justify-content-lg-between">
                <div class="col-lg-6">
                    <div class="copyright text-center text-lg-left text-muted">
                        &copy; 2019 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1"
                                       target="_blank">Creative Tim</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                        <li class="nav-item">
                            <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About
                                Us</a>
                        </li>
                        <li class="nav-item">
                            <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.creative-tim.com/license" class="nav-link" target="_blank">License</a>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/vendor.chart.min.js') }}"></script>
<script src="{{ asset('js/vendor.min.js') }}"></script>

</body>

</html>