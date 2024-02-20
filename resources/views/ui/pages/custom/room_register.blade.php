@extends('layouts.app')
@section('title', 'Mimarlar A.Ş | Oda Kaydı Nasıl Yapılır')
@section('meta_keys', isset($roomRegister->meta_keys) ? $roomRegister->meta_keys : '')
@section('meta_desc', isset($roomRegister->meta_desc) ? $roomRegister->meta_desc : '')

@section('modul_css')
    <link rel="stylesheet" href="{{ asset('css/ui/news/news_page.css') }}">
@endsection

@section('content')
    <div style="margin-top: 60px;min-height:751px;background-color: #ececec;padding:20px;">
        <div class="container mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb newspage-card-section">
                    <li class="breadcrumb-item"><a class="remove_underline" href="/">Anasayfa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Oda Kaydı Nasıl Yapılır</li>
                </ol>
            </nav>
        </div>
        <div class="container">
            <div class="col-md-12  p-2"
                style="background-color: #f5f5f5;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 10px;border-radius: 5px ">
                <div>
                    <div class="row d-flex justify-content-center mt-3">
                        <h3 style="color:red">ODA KAYDI NASIL YAPILIR ? </h3>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="p-5">
                                {!! isset($roomRegister->content)
                                    ? $roomRegister->content
                                    : '<div class="alert alert-warning" role="alert">İçerik girilmedi! </div>' !!}
                            </div>
                        </div>
                    </div>
                    @if (isset($roomRegister->room_register_file))
                        <div class="d-flex justify-content-center">

                            <a href="{{ asset('/storage/sayfa') . '/' . $roomRegister->room_register_file }}"
                                class="btn btn-warning"><i class="fas fa-download"></i>
                                indir
                            </a>
                        </div>
                    @endif

                    <div class="d-flex justify-content-center mt-4">
                        <h5>Mali Müşavir Bilgileri</h5>
                    </div>
                    <div class="row m-3">
                        <div class="col-md-6 p-2" style="padding-right: 10px">
                            <div class="col-md-12 p-2">
                                @if (isset($roomRegister->financial_advisor_image))
                                    <div class="card" style="border-radius:10px;border:2px solid gray">
                                        <img class="card-img-top" style="border-radius:10px;width: 31rem;height:367px"
                                            src="{{ asset('/storage/sayfa') . '/' . $roomRegister->financial_advisor_image }}"
                                            alt="Card image cap">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 p-2" style="margin-top: 8px">
                            @if (isset($roomRegister->financial_advisor_map))
                                <div class="col-md-12 p-2" style="border:1px solid gray;border-radius:10px">
                                    <iframe src="{{ $roomRegister->financial_advisor_map }}" width="500px" height="350px"
                                        style="border:0;" allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY&callback=myMap"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<script>
    function myMap() {
        var mapProp = {
            center: new google.maps.LatLng(51.508742, -0.120850),
            zoom: 5,
        };
        var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
    }
</script>
