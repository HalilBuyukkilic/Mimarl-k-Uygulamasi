@extends('layouts.app')
@section('title', 'Mimarlar A.Ş | Etkinlikler')
@section('meta_keys', 'Mimarlar A.Ş | Etkinlikler')
@section('meta_desc', 'Mimarlar A.Ş | Etkinlikler')
@section('modul_css')
    <link rel="stylesheet" href="css/ui/news/news_list.css">
    <link rel="stylesheet" href="{{ asset('css/ui/news/news_page.css') }}">
@endsection
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<style>
    .kart {
        position: relative;
    }

    .kosede-span {
        position: absolute;
        /* Mutlaka kartın içinde pozisyon almalı */
        bottom: 0;
        /* Kartın üst köşesine sabitlemek için */
        right: 15;
        /* Kartın sağ köşesine sabitlemek için */
        background-color: #b0bec5;
        /* Span rengi */
        color: #fff;
        /* Yazı rengi */
        padding: 7px;
        /* İçerik aralığı eklemek için */
    }
</style>
@section('content')
    <div style="margin-top: 70px;min-height:741px;background-color: #ececec;padding:20px;">
        <div class="container-fluid mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb newspage-card-section">
                    <li class="breadcrumb-item"><a class="remove_underline" href="/">Anasayfa</a></li>
                    <li class="breadcrumb-item"><a class="remove_underline">Etkinlikler</a>
                    </li>
                </ol>
            </nav>

            <div class="row">
                @if (count($event_list) > 0)
                    <div id="carouselExampleControls" class="carousel carousel-dark slide" style="background-color: white"
                        data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="container">
                                <div class="carousel-item active">
                                    <div class="row">
                                        @foreach ($event_active8_list as $item)
                                            <div class="col-md-3 p-2">
                                                <div class="card m-2" style="width: 16rem;border-radius:10px">
                                                    <img class="card-img-top" height="170px"
                                                        @if (isset($item->mediaOne->file_name)) src="{{ asset('/storage/etkinlik/' . $item->mediaOne->file_name) }}"
                                      @else  
                                      src="{{ URL::asset('/img/default/default-event.jpg') }}" @endif
                                                        alt="Card image cap">
                                                    <div class="card-body">
                                                        <h6 class="card-title d-flex justify-content-center mb-2">
                                                            <b style="border-bottom:2px solid red">{{ $item->title }}</b>
                                                        </h6>
                                                        <a href="{{ route('ui.event.page', $item->slug) }}"
                                                            class="d-flex justify-content-center"
                                                            style="color:red"><b>Etkinliğe
                                                                Git <i class="fas fa-arrow-right"></i></b></a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @if (count($event_active16_list) > 0)
                                    <div class="carousel-item ">
                                        <div class="row">
                                            @foreach ($event_active16_list as $item)
                                                <div class="col-md-3 p-2">
                                                    <div class="card m-2" style="width: 16rem;border-radius:10px">
                                                        <img class="card-img-top" height="170px"
                                                            @if (isset($item->mediaOne->file_name)) src="{{ asset('/storage/etkinlik/' . $item->mediaOne->file_name) }}"
                                          @else  
                                          src="{{ URL::asset('/img/default/default-event.jpg') }}" @endif
                                                            alt="Card image cap">
                                                        <div class="card-body">
                                                            <h6 class="card-title d-flex justify-content-center mb-2">
                                                                <b
                                                                    style="border-bottom:2px solid red">{{ $item->title }}</b>
                                                            </h6>
                                                            <a href="{{ route('ui.event.page', $item->slug) }}"
                                                                class="d-flex justify-content-center"
                                                                style="color:red"><b>Etkinliğe
                                                                    Git <i class="fas fa-arrow-right"></i></b></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif



                                @if (count($event_active24_list) > 0)
                                    <div class="carousel-item ">
                                        <div class="row">
                                            @foreach ($event_active24_list as $item)
                                                <div class="col-md-3 p-2">
                                                    <div class="card m-2" style="width: 16rem;border-radius:10px">
                                                        <img class="card-img-top" height="170px"
                                                            @if (isset($item->mediaOne->file_name)) src="{{ asset('/storage/etkinlik/' . $item->mediaOne->file_name) }}"
                                          @else  
                                          src="{{ URL::asset('/img/default/default-event.jpg') }}" @endif
                                                            alt="Card image cap">
                                                        <div class="card-body">
                                                            <h6 class="card-title d-flex justify-content-center mb-2">
                                                                <b
                                                                    style="border-bottom:2px solid red">{{ $item->title }}</b>
                                                            </h6>
                                                            <a href="{{ route('ui.event.page', $item->slug) }}"
                                                                class="d-flex justify-content-center"
                                                                style="color:red"><b>Etkinliğe
                                                                    Git <i class="fas fa-arrow-right"></i></b></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif



                                @if (count($event_active32_list) > 0)
                                    <div class="carousel-item ">
                                        <div class="row">
                                            @foreach ($event_active32_list as $item)
                                                <div class="col-md-3 p-2">
                                                    <div class="card m-2" style="width: 16rem;border-radius:10px">
                                                        <img class="card-img-top" height="170px"
                                                            @if (isset($item->mediaOne->file_name)) src="{{ asset('/storage/etkinlik/' . $item->mediaOne->file_name) }}"
                                          @else  
                                          src="{{ URL::asset('/img/default/default-event.jpg') }}" @endif
                                                            alt="Card image cap">
                                                        <div class="card-body">
                                                            <h6 class="card-title d-flex justify-content-center mb-2">
                                                                <b
                                                                    style="border-bottom:2px solid red">{{ $item->title }}</b>
                                                            </h6>
                                                            <a href="{{ route('ui.event.page', $item->slug) }}"
                                                                class="d-flex justify-content-center"
                                                                style="color:red"><b>Etkinliğe
                                                                    Git <i class="fas fa-arrow-right"></i></b></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif


                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                @else
                    <div class="col-md-12 p-2 d-flex justify-content-center">
                        <div class="alert alert-warning" role="alert">
                            Henüz Etkinlik Eklenmemiştir !
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
</script>
