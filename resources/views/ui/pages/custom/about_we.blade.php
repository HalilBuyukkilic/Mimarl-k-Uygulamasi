@extends('layouts.app')
@section('title', 'Mimarlar A.Ş | Biz Kimiz')
@section('meta_keys', isset($aboutUs->meta_keys) ? $aboutUs->meta_keys : '')
@section('meta_desc', isset($aboutUs->meta_desc) ? $aboutUs->meta_desc : '')
@section('modul_css')
    <link rel="stylesheet" href="{{ asset('css/ui/news/news_page.css') }}">
@endsection

@section('content')
    <div style="margin-top: 60px;min-height:751px;background-color: #ccc;padding:20px;">
        <div class="container mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb newspage-card-section">
                    <li class="breadcrumb-item"><a class="remove_underline" href="/">Anasayfa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Biz Kimiz</li>
                </ol>
            </nav>
        </div>
        <div class="container">
            <div class="col-md-12  p-2"
                style="background-color: #f5f5f5;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 10px;border-radius: 5px ">
                <div>
                    <div class="row d-flex justify-content-center mt-3">
                        <h3 style="color:red">BİZ KİMİZ ?</h3>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class=" d-flex justify-content-center mt-4">
                                <h5>Başkan</h5>
                            </div>
                            <div class=" d-flex justify-content-center">
                                <div class="card" style="width: 30rem;border-radius:10px;border:2px solid gray">
                                    @if (isset($aboutUs->president_image))
                                        <img class="card-img-top" style="border-radius:10px"
                                            src="{{ asset('/storage/sayfa') . '/' . $aboutUs->president_image }}"
                                            alt="Mimarlar odası başkanı">
                                    @endif

                                    <div class="card-body">
                                        <b class="card-text d-flex justify-content-center">
                                            {{ isset($aboutUs->president_name) ? $aboutUs->president_name : '' }}
                                        </b>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="p-3 mt-2">
                                {!! isset($aboutUs->president_cv)
                                    ? $aboutUs->president_cv
                                    : '<div class="alert alert-warning" role="alert">İçerik girilmedi! </div>' !!}
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 p-3">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-center mt-4 mb-4">
                                <h5>Başkan Yardımcıları</h5>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="width: 14rem;border-radius:10px;">
                                @if (isset($aboutUs->vice_president1_image))
                                    <img class="card-img-top" style="border-radius:10px;height:10rem"
                                        src="{{ asset('/storage/sayfa') . '/' . $aboutUs->vice_president1_image }}"
                                        alt="Card image cap">
                                @endif

                                <div class="card-body">
                                    <b class="card-text d-flex justify-content-center" style="font-size: 14px">
                                        {{ isset($aboutUs->vice_president1_name) ? $aboutUs->vice_president1_name : '' }}
                                    </b>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="width: 14rem;border-radius:10px;">
                                @if (isset($aboutUs->vice_president2_image))
                                    <img class="card-img-top" style="border-radius:10px;height:10rem"
                                        src="{{ asset('/storage/sayfa') . '/' . $aboutUs->vice_president2_image }}"
                                        alt="Card image cap">
                                @endif
                                <div class="card-body">
                                    <b class="card-text d-flex justify-content-center" style="font-size: 14px">
                                        {{ isset($aboutUs->vice_president2_name) ? $aboutUs->vice_president2_name : '' }}
                                    </b>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="width: 14rem;border-radius:10px;">

                                @if (isset($aboutUs->vice_president3_image))
                                    <img class="card-img-top" style="border-radius:10px;height:10rem"
                                        src="{{ asset('/storage/sayfa') . '/' . $aboutUs->vice_president3_image }}"
                                        alt="Card image cap">
                                @endif
                                <div class="card-body">
                                    <b class="card-text d-flex justify-content-center" style="font-size: 14px">
                                        {{ isset($aboutUs->vice_president3_name) ? $aboutUs->vice_president3_name : '' }}
                                    </b>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="width: 14rem;border-radius:10px;">
                                @if (isset($aboutUs->vice_president4_image))
                                    <img class="card-img-top" style="border-radius:10px;height:10rem"
                                        src="{{ asset('/storage/sayfa') . '/' . $aboutUs->vice_president4_image }}"
                                        alt="Card image cap">
                                @endif
                                <div class="card-body">
                                    <b class="card-text d-flex justify-content-center" style="font-size: 14px">
                                        {{ isset($aboutUs->vice_president4_name) ? $aboutUs->vice_president4_name : '' }}
                                    </b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-center mt-4 mb-4">
                                <h5>Mimarlar Ananonim Şirketi Hakkında</h5>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="p-3">
                                {!! isset($aboutUs->architects_company_content)
                                    ? $aboutUs->architects_company_content
                                    : '<div class="alert alert-warning" role="alert">İçerik girilmedi! </div>' !!}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
