@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'Medya')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<style>
    .tabs_color.active {
        background-color: #f9b115 !important;
    }
</style>
@section('content')

    <section class="content-header">
        <div class="container-fluid content-header-skeleton">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                        <li class="breadcrumb-item active">Medya</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php
                        $zamancek = date('d-m-Y');
                        setlocale(LC_TIME, 'turkish');
                        setlocale(LC_ALL, 'turkish');
                        echo iconv('latin5', 'utf-8', strftime(' %d %B %Y ', strtotime($zamancek)));
                        ?>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid p-2 " style="background-color: #cfd8dc ">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link  tabs_color active" id="pills-home-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                        aria-selected="true">Resimler</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link tabs_color " id="pills-profile-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                        aria-selected="false">Dökümanlar</button>
                </li>
                {{-- <li class="nav-item" role="presentation">
                    <button class="nav-link tabs_color" id="pills-contact-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
                        aria-selected="false">Videolar</button>
                </li> --}}
            </ul>
            <hr style="border-color:#f9b115">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane  fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-2 p-3">
                                <div class="card" style="width: 9rem;background-color:#eee">
                                    <div class="card-body">
                                        <h5 class="card-title mb-2">İş Akışı</h5>
                                        <a href="{{ route('admin.media.images', 'is_akisi') }}" class="card-link"><i
                                                class="fas fa-file-image" style="color:#90caf9;font-size:120px"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-3">
                                <div class="card" style="width: 9rem;background-color:#eee">
                                    <div class="card-body">
                                        <h5 class="card-title mb-2">Haberler</h5>
                                        <a href="{{ route('admin.media.images', 'haber') }}" class="card-link"><i
                                                class="fas fa-file-image" style="color:#90caf9;font-size:120px"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-3">
                                <div class="card" style="width: 9rem;background-color:#eee">
                                    <div class="card-body">
                                        <h5 class="card-title mb-2">Konular</h5>
                                        <a href="{{ route('admin.media.images', 'konu') }}" class="card-link"><i
                                                class="fas fa-file-image" style="color:#90caf9;font-size:120px"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-3">
                                <div class="card" style="width: 9rem;background-color:#eee">
                                    <div class="card-body">
                                        <h5 class="card-title mb-2">Etkinlik</h5>
                                        <a href="{{ route('admin.media.images', 'etkinlik') }}" class="card-link"><i
                                                class="fas fa-file-image" style="color:#90caf9;font-size:120px"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-3">
                                <div class="card" style="width: 9rem;background-color:#eee">
                                    <div class="card-body">
                                        <h5 class="card-title mb-2">Yarışma</h5>
                                        <a href="{{ route('admin.media.images', 'yarisma') }}" class="card-link"><i
                                                class="fas fa-file-image" style="color:#90caf9;font-size:120px"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-3">
                                <div class="card" style="width: 9rem;background-color:#eee">
                                    <div class="card-body">
                                        <h5 class="card-title mb-2">Yedek</h5>
                                        <a href="#" class="card-link"><i class="fas fa-file-image"
                                                style="color:#90caf9;font-size:120px"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-2 p-3">
                                <div class="card" style="width: 10rem;background-color:#eee">
                                    <div class="card-body">
                                        <h5 class="card-title">İş Akışı</h5>
                                        <a href="{{ route('admin.media.docs', 'is_akisi') }}" class="card-link"><i
                                                class="fas fa-folder-open" style="color:#e7c77a;font-size:120px"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-3">
                                <div class="card" style="width: 10rem;background-color:#eee">
                                    <div class="card-body">
                                        <h5 class="card-title">Yarışma</h5>
                                        <a href="{{ route('admin.media.docs', 'yarisma') }}" class="card-link"><i
                                                class="fas fa-folder-open" style="color:#e7c77a;font-size:120px"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-3">
                                <div class="card" style="width: 10rem;background-color:#eee">
                                    <div class="card-body">
                                        <h5 class="card-title">Dekontlar</h5>
                                        <a href="{{ route('admin.media.docs', 'dekont') }}" class="card-link"><i
                                                class="fas fa-folder-open" style="color:#e7c77a;font-size:120px"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-2 p-3">
                                <div class="card" style="width: 9rem;background-color:#eee">
                                    <div class="card-body">
                                        <h5 class="card-title mb-2">İş Akışı</h5>
                                        <a href="#" class="card-link"><i class="fas fa-file-video"
                                                style="color:#ffab91;font-size:120px"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-3">
                                <div class="card" style="width: 9rem;background-color:#eee">
                                    <div class="card-body">
                                        <h5 class="card-title mb-2">Haberler</h5>
                                        <a href="#" class="card-link"><i class="fas fa-file-video"
                                                style="color:#ffab91;font-size:120px"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-3">
                                <div class="card" style="width: 9rem;background-color:#eee">
                                    <div class="card-body">
                                        <h5 class="card-title mb-2">Etkinlik</h5>
                                        <a href="#" class="card-link"><i class="fas fa-file-video"
                                                style="color:#ffab91;font-size:120px"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-3">
                                <div class="card" style="width: 9rem;background-color:#eee">
                                    <div class="card-body">
                                        <h5 class="card-title mb-2">Yarışma</h5>
                                        <a href="#" class="card-link"><i class="fas fa-file-video"
                                                style="color:#ffab91;font-size:120px"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>
    <section style="height: 100px">
    </section>
@endsection
