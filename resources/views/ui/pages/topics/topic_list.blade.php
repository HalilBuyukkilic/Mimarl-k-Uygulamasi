@extends('layouts.app')
@section('title', 'Mimarlar A.Ş | Konular')
@section('meta_keys', 'Mimarlar A.Ş | Konular')
@section('meta_desc', 'Mimarlar A.Ş | Konular')
@section('modul_css')
    <link rel="stylesheet" href="css/ui/news/news_list.css">
    <link rel="stylesheet" href="{{ asset('css/ui/news/news_page.css') }}">
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
</style>
@section('content')
    <div style="margin-top: 70px;min-height:741px;background-color: #ececec;padding:20px;">
        <div class="container mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb newspage-card-section">
                    <li class="breadcrumb-item"><a class="remove_underline" href="/">Anasayfa</a></li>
                    <li class="breadcrumb-item"><a class="remove_underline">Konular</a>
                    </li>
                </ol>
            </nav>

            <div class="row">

                <div class="col-md-6 p-1">
                    <div class="p-2" style="background-color: #fff; border-radius:10px">
                        <div class="d-flex justfiy-content-center">
                            <h5 style="border-bottom:2px solid tomato;padding:5px;">Seçilmiş Konular</h5>
                        </div>
                        <div class="row p-2">
                            @if (count($topics_checked_list) > 0)
                                @foreach ($topics_checked_list as $item)
                                    <div class="col-md-6 p-3">
                                        <div class="card" style="border:1px solid #4dd0e1;background-color:#e0f2f1">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    @if (count($item->media) > 0)
                                                        <img src="{{ asset('/storage/konu/' . $item->media[0]->file_name) }}"
                                                            alt="Third slide" height="90px" width="100px">
                                                    @endif
                                                </div>
                                                <div class="col-md-8 kart">
                                                    <h6 class="m-3">
                                                        <a class="remove_underline"
                                                            href="{{ route('ui.topic.page', $item->slug) }}">{{ $item->title }}</a>
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
                            @else
                                <div class="col-md-12 p-2 d-flex justify-content-center">
                                    <div class="alert alert-warning" role="alert">
                                        Henüz Konu Eklenmemiştir !
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6 p-1">
                    <div class="p-2" style="background-color: #fff; border-radius:10px">
                        <div class="d-flex justfiy-content-center">
                            <h5 style="border-bottom:2px solid tomato;padding:5px;">Diğer Konular</h5>
                        </div>
                        <div class="row p-3">
                            @if (count($topics_list) > 0)
                                @foreach ($topics_list as $item)
                                    <div class="col-md-6 p-2">
                                        <div class="card" style="border:1px solid #4dd0e1;background-color:#e0f2f1">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    @if (count($item->media) > 0)
                                                        <img src="{{ asset('/storage/konu/' . $item->media[0]->file_name) }}"
                                                            alt="Third slide" height="90px" width="100px">
                                                    @endif
                                                </div>
                                                <div class="col-md-8 kart">
                                                    <h6 class="m-3">
                                                        <a class="remove_underline"
                                                            href="{{ route('ui.topic.page', $item->slug) }}">{{ $item->title }}</a>
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
                            @else
                                <div class="col-md-12 p-2 d-flex justify-content-center">
                                    <div class="alert alert-warning" role="alert">
                                        Henüz Konu Eklenmemiştir !
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
@endsection
