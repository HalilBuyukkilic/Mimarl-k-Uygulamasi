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
    <link rel="stylesheet" href=" {{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/ijaboCropTool/ijaboCropTool.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href=" {{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href=" {{ asset('css/moduls/admin_content_skeleton.css') }}">
    <link rel="stylesheet" href=" {{ asset('css/moduls/admin_core.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css">

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
            <div class="user-panel d-flex">
                <div class="image">
                    <img src="{{ Auth::user()->picture }}" class="img-circle elevation-2 admin_picture"
                        alt="User Image">
                </div>
                <div class="info">
                    <a href="{{ route('admin.profile') }}" class="d-block admin_name">{{ Auth::user()->name }}</a>
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
                            <a href="{{ route('admin.dashboard') }}"
                                class="nav-link {{ request()->is('admin/veri_tablosu*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                    Veri Tablosu
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users') }}"
                                class="nav-link {{ request()->is('admin/kullanicilar*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Kullanıcılar
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.workflow') }}"
                                class="nav-link {{ request()->is('admin/is_akisi*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-paste"></i>
                                <p>
                                    İş Akışı
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.news') }}"
                                class="nav-link {{ request()->is('admin/haberler*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-newspaper"></i>
                                <p>
                                    Haberler
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.topics') }}"
                                class="nav-link {{ request()->is('admin/konular*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>
                                    Konular
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.events') }}"
                                class="nav-link {{ request()->is('admin/etkinlik*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-dharmachakra"></i>
                                <p>
                                    Etkinlik
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.competition') }}"
                                class="nav-link {{ request()->is('admin/yarismalar*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-shapes"></i>
                                <p>
                                    Yarışma
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.receipts') }}"
                                class="nav-link {{ request()->is('admin/dekontlar*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-receipt"></i>
                                <p>
                                    Dekontlar
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.calculate') }}"
                                class="nav-link {{ request()->is('admin/girdi_ciktilar*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-calculator"></i>
                                <p>
                                    Girdi/Çıktılar
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#submenu1" data-bs-toggle="collapse" class="nav-link">
                                <i class="nav-icon fas fa-copy"></i> <span
                                    class="ms-1 d-none d-sm-inline">Sayfalar</span> </a>
                            <ul class="collapse {{ request()->is('admin/biz_kimiz*') ? 'show' : '' }} {{ request()->is('admin/oda_kaydi*') ? 'show' : '' }}"
                                style="list-style-type: none;" id="submenu1" data-bs-parent="#menu">
                                <li>
                                    <a href="{{ route('admin.about_us') }}"
                                        class="nav-link {{ request()->is('admin/biz_kimiz*') ? 'active' : '' }}">
                                        <span class="d-none d-sm-inline">Biz
                                            kimiz</span></a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.room_register') }}"
                                        class="nav-link {{ request()->is('admin/oda_kaydi*') ? 'active' : '' }}">
                                        <span class="d-none d-sm-inline">Oda
                                            Kaydı</span> </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.media') }}"
                                class="nav-link {{ request()->is('admin/medya*') ? 'active' : '' }}">
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
                        {{-- <li class="nav-item">
                            <a href="{{ route('admin.settings') }}"
                                class="nav-link {{ request()->is('admin/ayarlar*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>
                                    Ayarlar
                                </p>
                            </a>
                        </li> --}}
                    </ul>
                </nav>

                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="background-color: #eceff1;">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        {{-- <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                Başka bir arzunuz
            </div>
            <span>
                <strong>Copyright &copy; 2021-2023 <a href="https://adminlte.io">ICED Company</a>.</strong> tüm
                hakları
                saklıdır.
            </span>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
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

            $('#AdminInfoForm').on('submit', function(e) {
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
                            $('.admin_name').each(function() {
                                $(this).html($('#AdminInfoForm').find($(
                                    'input[name="name"]')).val());
                            });
                            alert(data.msg);
                        }
                    }
                });
            });



            $(document).on('click', '#change_picture_btn', function() {
                $('#admin_image').click();
            });


            $('#admin_image').ijaboCropTool({
                preview: '.admin_picture',
                setRatio: 1,
                allowedExtensions: ['jpg', 'jpeg', 'png'],
                buttonsText: ['KIRP', 'ÇIKIŞ'],
                buttonsColor: ['#30bf7d', '#ee5155', -15],
                processUrl: '{{ route('adminPictureUpdate') }}',
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


            $('#changePasswordAdminForm').on('submit', function(e) {
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
                            $('#changePasswordAdminForm')[0].reset();
                            alert(data.msg);
                        }
                    }
                });
            });


        });



        $.ajax({
            url: '{{ route('admin.get_notification') }}',
            method: 'get',
            async: false,
            success: function(data) {
                if (data.is_akisi != 0) {
                    $.toast({
                        position: 'top-right',
                        heading: 'Bildirim',
                        text: data.is_akisi + ' tane yeni iş akışı var',
                        icon: 'info',
                        loader: true,
                        loaderBg: '#76ff03'
                    });
                }
                if (data.konu != 0) {
                    $.toast({
                        position: 'top-right',
                        heading: 'Bildirim',
                        text: data.konu + ' tane yeni konu var',
                        icon: 'info',
                        loader: true,
                        loaderBg: '#ffeb3b'
                    });
                }
                if (data.dekont != 0) {
                    $.toast({
                        position: 'top-right',
                        heading: 'Bildirim',
                        text: data.dekont + ' tane yeni dekont var',
                        icon: 'info',
                        loader: true,
                        loaderBg: '#ff7043'
                    });
                }

                $.ajax({
                    url: '{{ route('admin.refresh_notification') }}',
                    method: 'get',
                    async: false,
                    success: function(data) {}
                });

            }
        });
    </script>
</body>

</html>
