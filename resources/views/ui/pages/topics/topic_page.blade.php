@extends('layouts.app')
@section('title', 'Mimarlar A.Ş | Konular')
@section('meta_keys', isset($topic_page->meta_keys) ? $topic_page->meta_keys : '')
@section('meta_desc', isset($topic_page->meta_desc) ? $topic_page->meta_desc : '')
@section('modul_css')
    <link rel="stylesheet" href="{{ asset('css/ui/news/news_page.css') }}">
@endsection
@section('content')
    <div style="margin-top: 60px;min-height:751px;background-color: #ececec;padding:20px;">
        <div class="container mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb newspage-card-section">
                    <li class="breadcrumb-item"><a class="remove_underline" href="/">Anasayfa</a></li>
                    <li class="breadcrumb-item"><a class="remove_underline" href="{{ route('ui.topic.list') }}">Konular</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $topic_page->title }}</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-md-9">
                    <div class="p-2 newspage-card-section">
                        @if (count($topic_page->media) > 0)
                            <div class="row ml-2">
                                @foreach ($topic_page->media as $media)
                                    @if ($media->media_type == 'image')
                                        <div class="col-md-3 p-2">
                                            <img class="d-block w-10"
                                                src="{{ asset('/storage/konu/' . $media->file_name) }}" alt="First slide"
                                                height="120px" width="170px">
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif


                        <div class="p-2 mt-2">
                            <span style="border-bottom:2px solid #ccc;padding:5px;margin-left:10px">
                                <i class="fas fa-calendar-day" style="font-size: 18px"></i>
                                {{ date('d-m-Y', strtotime($topic_page->created_at)) }}
                            </span>
                        </div>
                        <h5 style="text-align: center;margin-top:15px;"><span
                                style="border-bottom:2px solid gold;padding:4px">{{ $topic_page->title }}</span>
                        </h5>
                        <br>
                        {!! isset($topic_page->content) ? $topic_page->content : '' !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="newspage-card-section p-3">
                        <ul class="li_inline" style="margin-left: -30px;">
                            <div class="newspage-notice-card-title">
                                DİĞER KONULAR
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
                    <br>
                    <div class="newspage-card-section p-3">
                        <ul class="li_inline" style="margin-left: -30px;">
                            <div class="newspage-notice-card-title">
                                HABERLER
                            </div>
                            <hr class="my_hr mb-3" style="border:1px solid red">
                            @if (count($news_list) > 0)
                                @foreach ($news_list as $item)
                                    <li>
                                        <a class="remove_underline" style="font-size:14px"
                                            href="{{ route('ui.news.page', $item->slug) }}">{{ $item->title }}</a>
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
