@extends('layouts.app')
@section('title', 'Mimarlar A.Ş | Haberler')
@section('meta_keys', isset($news_page->meta_keys) ? $news_page->meta_keys : '')
@section('meta_desc', isset($news_page->meta_desc) ? $news_page->meta_desc : '')
@section('modul_css')
    <link rel="stylesheet" href="{{ asset('css/ui/news/news_page.css') }}">
@endsection
@section('content')
    <div style="margin-top: 60px;min-height:751px;background-color: #ececec;padding:20px;">
        <div class="container mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb newspage-card-section">
                    <li class="breadcrumb-item"><a class="remove_underline" href="/">Anasayfa</a></li>
                    <li class="breadcrumb-item"><a class="remove_underline" href="{{ route('ui.news.list') }}">Haberler</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $news_page->title }}</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-md-9">
                    <div class="p-2 newspage-card-section">
                        <img class="d-block w-100" src="{{ asset('/storage/haber/' . $news_page->media->file_name) }}"
                            alt="First slide" height="420px">

                        <div class="p-2 mt-2">
                            <span style="border-bottom:2px solid #ccc;padding:5px;">
                                <i class="fas fa-eye" style="font-size: 18px"></i> {{ $news_page->viewing }}
                            </span>
                            <span style="border-bottom:2px solid #ccc;padding:5px;margin-left:10px">
                                <i class="fas fa-calendar-day" style="font-size: 18px"></i>
                                {{ date('d-m-Y', strtotime($news_page->created_at)) }}
                            </span>
                        </div>
                        <h5 style="text-align: center;margin-top:15px;"><span
                                style="border-bottom:2px solid gold;padding:4px">{{ $news_page->title }}</span>
                        </h5>
                        <br>
                        {!! isset($news_page->content) ? $news_page->content : '' !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="newspage-card-section p-3">
                        <ul class="li_inline" style="margin-left: -30px;">
                            <div class="newspage-notice-card-title">
                                DİĞER HABERLER
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
                    <br>
                    <div class="newspage-card-section p-3">
                        <ul class="li_inline" style="margin-left: -30px;">
                            <div class="newspage-notice-card-title">
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let news_id = "{{ $news_page->id }}";
        axios({
            method: 'post',
            url: '{{ route('ui.news.viewing') }}',
            data: {
                news_id: news_id
            }
        }).then(res => {

        }).catch(err => {

        })


    });
</script>
