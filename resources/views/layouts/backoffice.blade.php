<!DOCTYPE html>

<html lang="ko" class="default-style">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DMP9 BACKOFFICE</title>

    <meta name="theme-color" content="#ffffff">

    <!-- Icons-->
    <link href="{{ asset('css/free.min.css') }}" rel="stylesheet"> <!-- icons -->

    <!-- Main styles for this application-->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pace.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" type="text/css" />
</head>

<body class="c-app">
<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">

    <div class="c-sidebar-brand">

    </div>
    <ul class="c-sidebar-nav">

        <li class="c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-dropdown-toggle" href="#"><i class="cil-address-book c-sidebar-nav-icon"></i>회원관리</a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="/users"><span class="c-sidebar-nav-icon"></span>회원리스트</a>
                </li>
            </ul>
        </li>

        <li class="c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-dropdown-toggle" href="#"><i class="cil-file c-sidebar-nav-icon"></i>게시판관리</a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="/faqs"><span class="c-sidebar-nav-icon"></span>자주 묻는 질문</a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="/questions"><span class="c-sidebar-nav-icon"></span>문의 및 답변</a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="/contactsus"><span class="c-sidebar-nav-icon"></span>Contacts Us</a>
                </li>
            </ul>
        </li>

        <li class="c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-dropdown-toggle" href="#"><i class="cil-cart c-sidebar-nav-icon"></i>주문서 관리</a>
            <ul class="c-sidebar-nav-dropdown-items">

                <li class="c-sidebar-nav-item ">
                    <a class="c-sidebar-nav-link" href="/cart"><span class="c-sidebar-nav-icon"></span>전체</a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="/checking"><span class="c-sidebar-nav-icon"></span>확인중</a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="/payment_waiting"><span class="c-sidebar-nav-icon"></span>결제대기중</a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="/payment_completed"><span class="c-sidebar-nav-icon"></span>결제완료</a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="/data_extraction"><span class="c-sidebar-nav-icon"></span>데이터추출중</a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="/data_completed"><span class="c-sidebar-nav-icon"></span>데이터추출완료</a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="/upload_waiting"><span class="c-sidebar-nav-icon"></span>업로드대기</a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="/upload_request"><span class="c-sidebar-nav-icon"></span>업로드요청</a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="/upload_completed"><span class="c-sidebar-nav-icon"></span>업로드완료</a>
                </li>
            </ul>
        </li>

        <li class="c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-dropdown-toggle" href="#"><i class="cil-barcode c-sidebar-nav-icon"></i>계산서관리</a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="/orders"><span class="c-sidebar-nav-icon"></span>계산서요청리스트</a>
                </li>
            </ul>
        </li>

        <li class="c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-dropdown-toggle" href="#"><i class="cil-audio-spectrum c-sidebar-nav-icon"></i>통계</a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="{{ route("saleschart") }}"><span class="c-sidebar-nav-icon"></span>매출통계</a>
                </li>
            </ul>
        </li>

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
                <li class="breadcrumb-item"><a href="/users">Home</a></li>
                @if (class_basename(Route::current()->controller) === "UserController")
                    <li class="breadcrumb-item ">회원관리</li>
                    <li class="breadcrumb-item active">회원리스트</li>
                @elseif (class_basename(Route::current()->controller) === "FaqController")
                    <li class="breadcrumb-item ">게시판관리</li>
                    <li class="breadcrumb-item active">자주 묻는 질문</li>
                @elseif (class_basename(Route::current()->controller) === "QuestionController")
                    <li class="breadcrumb-item ">게시판관리</li>
                    <li class="breadcrumb-item active">문의 및 답변</li>
                @elseif (class_basename(Route::current()->controller) === "ContactsusController")
                    <li class="breadcrumb-item ">게시판관리</li>
                    <li class="breadcrumb-item active">Contacts Us</li>
                @elseif (class_basename(Route::current()->controller) === "CartController")

                    <li class="breadcrumb-item ">주문서 관리</li>
                    @if (Route::current()->getActionMethod() === "index")
                        <li class="breadcrumb-item active">전체</li>
                    @elseif (Route::current()->getActionMethod() === "cart_state_1")
                        <li class="breadcrumb-item active">결제대기중</li>
                    @elseif (Route::current()->getActionMethod() === "cart_state_2")
                        <li class="breadcrumb-item active">결제완료</li>
                    @elseif (Route::current()->getActionMethod() === "cart_state_3")
                        <li class="breadcrumb-item active">데이터추출중</li>
                    @elseif (Route::current()->getActionMethod() === "cart_state_4")
                        <li class="breadcrumb-item active">데이터추출완료</li>
                    @elseif (Route::current()->getActionMethod() === "option_state_1")
                        <li class="breadcrumb-item active">업로드대기</li>
                    @elseif (Route::current()->getActionMethod() === "option_state_2")
                        <li class="breadcrumb-item active">업로드요청</li>
                    @elseif (Route::current()->getActionMethod() === "option_state_3")
                        <li class="breadcrumb-item active">업로드완료</li>
                    @endif
                @elseif (class_basename(Route::current()->controller) === "OrderController")
                    <li class="breadcrumb-item ">계산서 관리</li>
                    <li class="breadcrumb-item active">계산서요청리스트</li>
                @elseif (class_basename(Route::current()->controller) === "StatisticsController")
                    <li class="breadcrumb-item ">통계</li>
                    <li class="breadcrumb-item active">매출통계</li>
                @endif
            </ol>
        </div>
    </header>
    <div class="c-body">
        <main class="c-main">
            @yield('content')
        </main>
    </div>
    <footer class="c-footer">

    </footer>
</div>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
<!-- CoreUI and necessary plugins-->
<script src="{{ asset('js/coreui.bundle.min.js') }}"></script>

@stack('scripts')

</body>

</html>
