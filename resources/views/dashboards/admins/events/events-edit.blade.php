@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'Etkinlik Düzenle')

@section('content')

    <section class="content-header">
        <div class="container-fluid content-header-skeleton">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                        <li class="breadcrumb-item">Etkinlikler</li>
                        <li class="breadcrumb-item active">Etkinlik Düzenle</li>
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
        <div class="container content-info-skeleton">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <span style="font-size: 22px;">
                        <i class="fas fa-dharmachakra mr-2"></i>Etkinlik Düzenle
                    </span>
                    <span>
                        <a href="{{ route('admin.events') }}"
                            class="backbg_fourthly back_textColor content-newform-right-buttons">
                            <i class="fas fa-list"></i> Liste
                        </a>
                        <a onclick="return_back();return false;"
                            class="backbg_secondary back_textColor  mr-1  content-newform-right-buttons">
                            <i class="fas fa-reply"></i> Geri
                        </a>
                    </span>
                </div>
                <hr class="mt-n3">

                <form class="form-horizontal mt-4" enctype="multipart/form-data"
                    onsubmit="eventUpdate({{ $event->id }});return false;" id="events-update-form">
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    <div class="row">
                        <div class="form-group col-md-10">
                            <label for="title">Başlık <span style="color: red">*</span></label>
                            <input id="title" type="text" class="form-control" name="title"
                                value="{{ $event->title }}" required autofocus placeholder="Başlık giriniz">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="status">Durum</label>
                            <div class="input-group">
                                <select class="custom-select" name="status" id="inputGroupSelect02">
                                    <option value="1" {{ $event->status == 1 ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ $event->status == 0 ? 'selected' : '' }}>Pasif</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="events_images">Etkinlik Resimleri </label>
                            <div class="control-group" id="events_images">
                                <input type="file" name="images[]" class="myfrm form-control" style="height: 45px"
                                    multiple>
                            </div>

                            @if (is_countable($event->media) && count($event->media) > 0)
                                <div class="col-md-12 p-2">
                                    <div
                                        style="background-color:#ddd; padding-left:17px;padding-top:10px;padding-bottom:10px">
                                        @foreach ($event->media as $media)
                                            <span style="border:1px solid #bbb;padding:24px 5px">
                                                <img src="{{ asset('/storage/etkinlik') . '/' . $media->file_name }}"
                                                    style="height: 50px;width:50px;margin:10px" alt="">
                                                <button type="button" class="btn" style="border:1px solid #bbb"
                                                    onclick="mediaDelete({{ $media->id }},{{ $event->id }})"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>


                    <div class="form-group">
                        <textarea class="ckeditor form-control" name="content" id="event_content">
                            {!! isset($event->content) ? $event->content : '' !!}
                        </textarea>
                    </div>

                    <div class="card-header">
                        <div class="panel-heading" role="tab" id="headingSeo">
                            <h6 class="panel-title ml-n3">
                                <i class="fas fa-arrow-alt-circle-down"></i>
                                <a class="accordion-toggle" style="color:black" role="button" data-toggle="collapse"
                                    href="#collapseSeo" aria-expanded="false" aria-controls="collapseSeo">
                                    Seo Girdileri
                                </a>
                            </h6>
                        </div>
                        <div id="collapseSeo" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="headingSeo">
                            <div class="panel-body">
                                <br>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="meta_title">Meta Başlık </label>
                                        <input id="meta_title" type="text" class="form-control" name="meta_title"
                                            value="{{ $event->meta_title }}" autofocus placeholder="Meta başlık giriniz">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="meta_keys">Meta Anahtar Kelimeler </label>
                                        <input id="meta_keys" type="text" class="form-control" name="meta_keys"
                                            value="{{ $event->meta_keys }}" autofocus
                                            placeholder="Meta anahtar kelime giriniz">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="meta_desc">Meta Açıklama </label>
                                        <input id="meta_desc" type="text" class="form-control" name="meta_desc"
                                            value="{{ $event->meta_desc }}" autofocus
                                            placeholder="Meta açıklama giriniz">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-2">
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn backbg_primary back_textColor">
                                <i class="fas fa-sync mr-1"></i>Güncelle</button>
                            <span>
                                <button type="button" class="btn backbg_fifthly back_textColor" style="padding: 9px"
                                    onclick="eventDelete({{ $event->id }})">
                                    <i class="fas fa-trash-alt"></i></button>
                            </span>

                        </div>
                    </div>
                </form>

            </div>
            <!-- /.tab-content -->
        </div><!-- /.card-body -->

        <!-- /.row -->
        <!-- /.container-fluid -->
        </div>
    </section>

    <section style="height: 100px">
    </section>

@endsection
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.ckeditor').ckeditor();
    });


    function eventUpdate(event_id) {
        $('#event_content').val(CKEDITOR.instances.event_content.getData().toString());

        axios({
            method: 'post',
            url: '{{ route('admin.events_update') }}',
            data: new FormData($('#events-update-form')[0])
        }).then(res => {

            $.confirm({
                title: res.data.status == 1 ? 'İşlem başarılı' : 'Hata !',
                content: res.data.status == 1 ? 'Etkinlik güncellendi' :
                    'Etkinlik güncellerken bir hata meydana geldi',
                type: res.data.status == 1 ? 'green' : 'red',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: res.data.status == 1 ? 'Tamam' : 'Tekrar dene',
                        btnClass: res.data.status == 1 ? 'btn-green' : 'btn-red',
                        action: function() {}
                    }
                }
            });

            setTimeout(() => {
                window.location.href = '/admin/etkinlik_duzenle/' +
                    event_id;
            }, 500);

        }).catch(err => {

        })
    }

    function eventDelete(event_id) {
        $.confirm({
            title: 'Dikkat, Bu etkinlik silenecek!',
            content: 'Devam etmek istediğinizden emin misiniz?',
            type: 'orange',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Evet, Sil',
                    btnClass: 'btn-orange',
                    action: function() {
                        axios({
                            method: 'post',
                            url: '{{ route('admin.events.delete') }}',
                            data: {
                                event_id: event_id
                            }
                        }).then(res => {
                            if (res.data.status == 1) {
                                $.dialog({
                                    title: 'İşlem başarılı',
                                    content: 'Etkinlik silindi',
                                    type: 'green',
                                });
                                setTimeout(() => {
                                    window.location.href = '/admin/etkinlikler';
                                }, 500);
                            } else {
                                $.dialog({
                                    title: 'Hata',
                                    content: 'Etkinlik silinirken hata meydana geldi!',
                                    type: 'red',
                                });
                            }
                        }).catch(err => {

                        })
                    }
                },
                close: {
                    text: 'İptal'
                }
            }
        });
    }





    function mediaDelete(media_id, event_id) {

        $.confirm({
            title: 'Dikkat, Bu resim silenecek!',
            content: 'Devam etmek istediğinizden emin misiniz?',
            type: 'orange',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Evet, Sil',
                    btnClass: 'btn-orange',
                    action: function() {
                        axios({
                            method: 'post',
                            url: '{{ route('admin.media.delete') }}',
                            data: {
                                media_id: media_id
                            }
                        }).then(res => {
                            if (res.data.status == 1) {
                                $.dialog({
                                    title: 'İşlem başarılı',
                                    content: 'Resim silindi',
                                    type: 'green',
                                });
                                setTimeout(() => {
                                    window.location.href = '/admin/etkinlik_duzenle/' +
                                        event_id;
                                }, 500);
                            } else {
                                $.dialog({
                                    title: 'Hata',
                                    content: 'Resim silinirken hata meydana geldi!',
                                    type: 'red',
                                });
                            }
                        }).catch(err => {

                        })
                    }
                },
                close: {
                    text: 'İptal'
                }
            }
        });
    }


    function return_back() {
        window.history.back();
    };
</script>
