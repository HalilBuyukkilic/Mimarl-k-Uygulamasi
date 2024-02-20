@extends('layouts.app')
@section('title', 'Mimarlar A.Ş | Haberler')
@section('meta_keys', 'Mimarlar A.Ş | Haberler')
@section('meta_desc', 'Mimarlar A.Ş | Haberler')
@section('modul_css')
    <link rel="stylesheet" href="css/ui/news/news_list.css">
@endsection
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

    .slide_title {
        background-color: rgb(0, 0, 0, 0.5);
        position: absolute;
        bottom: 0;
        color: white;

        font-size: 15px;
        padding: 15px 0;
        opacity: 1;
        transition: 0.6s;
    }
</style>
@section('content')
    <div style="margin-top: 70px;min-height:741px;background-color: #ececec;padding:20px;">
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-9">
                    <div class="newslist-card-section p-2">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                            </ol>
                            <div class="carousel-inner">
                                @if (isset($news_slide_active->media))
                                    <div class="carousel-item active">
                                        <a href="{{ route('ui.news.page', $news_slide_active->slug) }}">
                                            <img class="d-block w-100"
                                                src="{{ asset('/storage/haber/' . $news_slide_active->media->file_name) }}"
                                                alt="First slide" height="450px">
                                            <div class="carousel-caption d-none d-md-block slide_title">
                                                <h5>
                                                    {{ $news_slide_active->title }}
                                                    </span>
                                                    <p>
                                                        {{ $news_slide_active->summary }}
                                                    </p>
                                            </div>
                                        </a>
                                    </div>
                                @else
                                    <div class="col-md-12 p-2 d-flex justify-content-center">
                                        <div class="alert alert-warning" role="alert">
                                            Henüz Haber Eklenmemiştir !
                                        </div>
                                    </div>
                                @endif

                                @if (count($news_slide) > 0)
                                    @foreach ($news_slide as $item)
                                        <div class="carousel-item">
                                            <a href="{{ route('ui.news.page', $item->slug) }}">
                                                <img class="d-block w-100"
                                                    src="{{ asset('/storage/haber/' . $item->media->file_name) }}"
                                                    alt="First slide" height="450px">
                                                <div class="carousel-caption d-none d-md-block slide_title">
                                                    <h5>
                                                        {{ $item->title }}
                                                    </h5>
                                                    <p>
                                                        {{ $item->summary }}
                                                    </p>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>


                    <div class="row p-2">
                        @if (count($news_list) > 0)
                            @foreach ($news_list as $item)
                                <div class="col-md-6 p-2">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <img class="d-block w-100"
                                                    src="{{ asset('/storage/haber/' . $item->media->file_name) }}"
                                                    alt="Third slide" height="90px">
                                            </div>
                                            <div class="col-md-8 kart">
                                                <h6 class="m-3">
                                                    <a class="remove_underline"
                                                        href="{{ route('ui.news.page', $item->slug) }}">{{ $item->title }}</a>
                                                </h6>
                                                <span class="kosede-span"
                                                    style="border-bottom:2px solid #ccc;padding:2px; font-size: 10px;float: right;">
                                                    <i class="fas fa-calendar-day"></i>
                                                    {{ date('d-m-Y', strtotime($item->created_at)) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>

                </div>
                <div class="col-md-3">
                    <div class="newslist-card-section p-3">
                        <ul class="li_inline" style="margin-left: -30px;">
                            <div class="newslist-notice-card-title">
                                KONULAR
                            </div>
                            <hr class="my_hr mb-3" style="border:1px solid red">
                            @if (count($topics_list) > 0)
                                @foreach ($topics_list as $item)
                                    <li>
                                        <a class="remove_underline" style="font-size:14px"
                                            href="{{ route('ui.topic.page', $item->slug) }}">{{ $item->title }}</a>
                                    </li>
                                    <hr class="my_hr">
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
