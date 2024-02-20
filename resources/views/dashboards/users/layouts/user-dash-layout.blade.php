<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <base href="{{ \URL::to('/') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('plugins/ijaboCropTool/ijaboCropTool.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="css/moduls/admin_content_skeleton.css">
    <link rel="stylesheet" href=" {{ asset('css/moduls/admin_core.css') }}">

</head>

<body class="sidebar-mini layout-fixed text-sm" style="background-color: #eceff1">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel  d-flex">
                <div class="image">
                    <img src="{{ Auth::user()->picture }}" class="img-circle elevation-2 user_picture" alt="User Image">
                </div>
                <div class="info">
                    <a href="{{ route('user.profile') }}" class="d-block">{{ Auth::user()->name }}</a>
                </div>
            </div>

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ \URL::to('/') }}" class="brand-link">
                <img src="{{ asset('/img/site/logo.png') }}" alt="User Image" class="ml-3" width="150"
                    height="40">
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-compact nav-child-indent nav-collapse-hide-child nav-flat"
                        data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="{{ route('user.dashboard') }}"
                                class="nav-link {{ request()->is('uye/veri_tablosu*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                    Veri Tablosu
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.workflow') }}"
                                class="nav-link {{ request()->is('uye/is_akisi*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-paste"></i>
                                <p>
                                    İş Akışı
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.topics') }}"
                                class="nav-link {{ request()->is('uye/konular*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>
                                    Konular
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.receipts') }}"
                                class="nav-link {{ request()->is('uye/dekontlar*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-receipt"></i>
                                <p>
                                    Dekontlar
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.media') }}"
                                class="nav-link {{ request()->is('uye/medya*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-photo-video"></i>
                                <p>
                                    Media
                                </p>
                            </a>
                        </li>
                        <li class="nav-item d-none d-sm-inline-block">
                            <a class="nav-link" href="{{ route('logout') }}" style="color:gold"
                                onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas fa-sign-out-alt"></i> Çıkış
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="background-color: #eceff1">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->


        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        {{-- <footer class="main-footer">
           
            <div class="float-right d-none d-sm-inline">
                Başka bir arzunuz
            </div>
          
            <strong>Copyright &copy; 2021-2023 <a href="https://adminlte.io">ICED Company</a>.</strong> tüm hakları
            saklıdır.
        </footer> --}}
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src=" {{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src=" {{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/ijaboCropTool/ijaboCropTool.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src=" {{ asset('dist/js/adminlte.min.js') }}"></script>

    {{-- CUSTOM JS CODES --}}
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function() {

            /* UPDATE ADMIN PERSONAL INFO */

            $('#UserInfoForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(data) {
                        if (data.status == 0) {
                            $.each(data.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {
                            $('.user_name').each(function() {
                                $(this).html($('#UserInfoForm').find($(
                                    'input[name="name"]')).val());
                            });
                            alert(data.msg);
                        }
                    }
                });
            });



            $(document).on('click', '#change_picture_btn', function() {
                $('#user_image').click();
            });


            $('#user_image').ijaboCropTool({
                preview: '.user_picture',
                setRatio: 1,
                allowedExtensions: ['jpg', 'jpeg', 'png'],
                buttonsText: ['KIRP', 'ÇIKIŞ'],
                buttonsColor: ['#30bf7d', '#ee5155', -15],
                processUrl: '{{ route('userPictureUpdate') }}',
                withCSRF: ['_token', '{{ csrf_token() }}'],
                onSuccess: function(message, element, status) {
                    $.dialog({
                        title: 'İşlem başarılı!',
                        content: 'Profil resmi güncellendi',
                        type: 'green'
                    });
                },
                onError: function(message, element, status) {
                    $.dialog({
                        title: 'Hata !',
                        content: 'Profil resmi güncellenirken bir sorun meydana geldi',
                        type: 'red'
                    });
                }
            });


            $('#changePasswordUserForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(data) {
                        if (data.status == 0) {
                            $.each(data.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {
                            $('#changePasswordUserForm')[0].reset();
                            alert(data.msg);
                        }
                    }
                });
            });
        });
    </script>

</body>

</html>
