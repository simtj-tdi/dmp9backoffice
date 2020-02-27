<!DOCTYPE html>

<html lang="ko" class="default-style">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta name="theme-color" content="#ffffff">

    <!-- Icons-->
    <link href="{{ asset('css/free.min.css') }}" rel="stylesheet"> <!-- icons -->

    <!-- Main styles for this application-->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pace.min.css') }}" rel="stylesheet">

</head>

<body class="c-app">
<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">

    <div class="c-sidebar-brand">
        <img class="c-sidebar-brand-full" src="http://coreui.test/assets/brand/coreui-base-white.svg" width="118" height="46" alt="CoreUI Logo">
        <img class="c-sidebar-brand-minimized" src="assets/brand/coreui-signet-white.svg" width="118" height="46" alt="CoreUI Logo">
    </div>
    <ul class="c-sidebar-nav">

        <li class="c-sidebar-nav-title">
            회원
        </li>

        <li class="c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-dropdown-toggle" href="#"><i class="cil-cursor c-sidebar-nav-icon"></i>회원관리</a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="/users"><span class="c-sidebar-nav-icon"></span>회원리스트</a>
                </li>

            </ul>
        </li>
        <!--
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="http://coreui.test/charts">
                <i class="cil-chart-pie c-sidebar-nav-icon"></i>
                Charts
            </a>
        </li>
        -->
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>
<div class="c-wrapper">
    <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
        <button class="c-header-toggler c-class-toggler d-lg-none mr-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show"><span class="c-header-toggler-icon"></span></button><a class="c-header-brand d-sm-none" href="#"><img class="c-header-brand" src="http://coreui.test/assets/brand/coreui-base.svg" width="97" height="46" alt="CoreUI Logo"></a>
        <button class="c-header-toggler c-class-toggler ml-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true"><span class="c-header-toggler-icon"></span></button>

        <ul class="c-header-nav ml-auto mr-4">
            <li class="c-header-nav-item dropdown">
                <a class="c-header-nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" href="#">{{ Auth::user()->name }}</a>
                <div class="dropdown-menu dropdown-menu-right pt-0">
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Lock Account</a>
                    <a class="dropdown-item" href="#">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-ghost-dark btn-block">Logout</button>
                        </form>
                    </a>
                </div>
            </li>
        </ul>
        <div class="c-subheader px-3">
            <ol class="breadcrumb border-0 m-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active"></li>
            </ol>
        </div>
    </header>
    <div class="c-body">
        <main class="c-main">
            @yield('content')
        </main>
    </div>
    <footer class="c-footer">
        <div><a href="https://coreui.io">CoreUI</a> &copy; 2019 creativeLabs.</div>
        <div class="ml-auto">Powered by&nbsp;<a href="https://coreui.io/">CoreUI</a></div>
    </footer>
</div>

<!-- CoreUI and necessary plugins-->
<script src="{{ asset('js/pace.min.js') }}"></script>
<script src="{{ asset('js/coreui.bundle.min.js') }}"></script>

</body>

</html>
