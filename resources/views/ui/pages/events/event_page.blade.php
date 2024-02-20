@extends('layouts.app')
@section('title', 'Mimarlar A.Ş | Etkinlikler')
@section('meta_keys', isset($event_page->meta_keys) ? $event_page->meta_keys : '')
@section('meta_desc', isset($event_page->meta_desc) ? $event_page->meta_desc : '')
@section('modul_css')
    <link rel="stylesheet" href="{{ asset('css/ui/news/news_page.css') }}">
@endsection

@section('content')
    <div style="margin-top: 60px;min-height:751px;background-color: #ececec;padding:20px;">
        <div class="container mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb newspage-card-section">
                    <li class="breadcrumb-item"><a class="remove_underline" href="/">Anasayfa</a></li>
                    <li class="breadcrumb-item"><a class="remove_underline"
                            href="{{ route('ui.event.list') }}">Etkinlikler</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $event_page->title }}</li>
                </ol>
            </nav>

            <div class="row">

                <div class="col-md-12" style="background-color: #fff">
                    <div class="row">
                        @if (count($event_page->media) > 0)
                            @foreach ($event_page->media as $media)
                                <div class="col-md-2 mt-2">
                                    <div style="width: 10rem;">
                                        <a data-fslightbox="gallery"
                                            href="{{ asset('/storage/etkinlik/' . $media->file_name) }}">
                                            <img class="card-img-top"
                                                src="{{ asset('/storage/etkinlik/' . $media->file_name) }}"
                                                alt="Card image cap" style="height:150px;border-radius:10px;">
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-md-2 mt-2">
                                <div style="width: 10rem;">
                                    <img class="card-img-top" src="{{ URL::asset('/img/default/default-event.jpg') }}"
                                        alt="Card image cap" style="height:150px;border-radius:10px;">
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="pl-2 mt-5">
                        <div class="d-flex justify-content-center mb-3">
                            <h5 style="border-bottom:2px solid gray;padding:5px">{{ $event_page->title }}</h5>
                        </div>

                        <br>
                        @if (isset($event_page->summary))
                            <div class="p-3">
                                <div style="background-color: #ececec;padding:10px;border-radius:10px">
                                    <b>Etkinlik Özeti</b>
                                    <div>
                                        {{ $event_page->summary }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="p-3">
                            <b>Etkinlik Detayı</b>
                            <p>
                                {!! isset($event_page->content)
                                    ? $event_page->content
                                    : '<div class="alert alert-warning" role="alert">İçerik girilmedi! </div>' !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/fslightbox.js') }}"></script>
@endsection
