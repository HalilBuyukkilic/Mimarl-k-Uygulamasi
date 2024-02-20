@extends('dashboards.users.layouts.user-dash-layout')
@section('title', 'İş Akışı Düzenle')

@section('content')

    <section class="content-header">
        <div class="container-fluid content-header-skeleton">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                        <li class="breadcrumb-item">İş Akışı</li>
                        <li class="breadcrumb-item active">İş Akışı Düzenle</li>
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
                        <i class="fas fa-paste mr-2"></i>İş Akışı Düzenle
                    </span>
                    <span>
                        <a href="{{ route('user.workflow') }}"
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
                    onsubmit="workflowUpdate({{ $workflow->id }});return false;" id="workflow-update-form">
                    <input type="hidden" name="workflow_id" value="{{ $workflow->id }}">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="title">Başlık <span style="color: red">*</span></label>
                            <input id="title" type="text" class="form-control" name="title"
                                value="{{ $workflow->title }}" required autofocus placeholder="Başlık giriniz">
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="work_squaremeter">İş Metrekaresi </label>
                            <input id="work_squaremeter" type="text" class="form-control" name="work_squaremeter"
                                value="{{ $workflow->work_squaremeter }}" autofocus placeholder="İş metrekaresi giriniz">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="room_area">Ada</label>
                            <input id="room_area" type="text" class="form-control" name="room_area" autofocus
                                value="{{ $workflow->room_area }}" placeholder="Ada giriniz">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="room_parcel">Parsel</label>
                            <input id="room_parcel" type="text" class="form-control" name="room_parcel" autofocus
                                value="{{ $workflow->room_parcel }}" placeholder="Parsel giriniz">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="structure_class">Yapı Sınıfı</label>
                            <input id="structure_class" type="text" class="form-control" name="structure_class" autofocus
                                value="{{ $workflow->structure_class }}" placeholder="Yapı sınıfı giriniz">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="contractor_name">Müteahhit Adı </label>
                            <input id="contractor_name" type="text" class="form-control" name="contractor_name" autofocus
                                value="{{ $workflow->contractor_name }}" placeholder="müteahhit adı giriniz">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="contractor_phone">Müteahhit Telefonu </label>
                            <input id="contractor_phone" type="text" class="form-control" name="contractor_phone"
                                value="{{ $workflow->contractor_phone }}" autofocus
                                placeholder="müteahhit telefonu giriniz">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="district">İlçe</label>
                            <input id="district" type="text" class="form-control" name="district" autofocus
                                value="{{ $workflow->district }}" placeholder="İlçe giriniz">
                        </div>
                        <div class="form-group col-md-8">
                            <label for="contractor_address">Müteahhit Adresi</label>
                            <input id="contractor_address" type="text" class="form-control" name="contractor_address"
                                value="{{ $workflow->contractor_address }}" autofocus
                                placeholder="Müteahhit adresi giriniz">
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="workflow_files">İş Akışı Dosyaları </label>
                            <div class="control-group" id="workflow_files">
                                <input type="file" name="files[]" class="myfrm form-control" style="height: 45px"
                                    multiple>
                            </div>

                            @if (is_countable($workflow->media) && count($workflow->media) > 0)
                                <div class="row p-2 mt-2" style="background-color:#ddd">
                                    @foreach ($workflow->media as $media)
                                        <div class="col-md-1 "
                                            style="border: 1px solid #bbb;padding:7px;border-radius:5px;background-color:#fff">
                                            @if ($media->media_type == 'image')
                                                <img src="{{ asset('/storage/is_akisi') . '/' . $media->file_name }}"
                                                    style="height: 50px;width:60px" alt="">
                                                <button type="button" class="btn mt-1"
                                                    style="border:1px solid #bbb;margin-left:10px"
                                                    onclick="mediaDelete({{ $media->id }},{{ $workflow->id }})"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            @else
                                                @if ($media->media_type == 'doc')
                                                    <a href="{{ asset('/storage/is_akisi') . '/' . $media->file_name }}"
                                                        style="height: 50px;width:70px;margin:10px" alt="">
                                                        @if (explode('.', $media->file_name)[1] == 'pdf')
                                                            <i class="fas fa-file-pdf"
                                                                style="font-size:50px;color:red"></i>
                                                        @else
                                                            @if (explode('.', $media->file_name)[1] == 'xlsx')
                                                                <i class="fas fa-file-excel"
                                                                    style="font-size:50px;color:green"></i>
                                                            @else
                                                                @if (explode('.', $media->file_name)[1] == 'doc' || explode('.', $media->file_name)[1] == 'docx')
                                                                    <i class="fas fa-file-word"
                                                                        style="font-size:50px"></i>
                                                                @else
                                                                    @if (explode('.', $media->file_name)[1] == 'txt')
                                                                        <i class="fas fa-file-alt"
                                                                            style="font-size:50px;color:#80deea"></i>
                                                                    @else
                                                                        <i class="fas fa-file-archive"
                                                                            style="font-size:50px;color:#ffd180"></i>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </a>
                                                @endif
                                                <button type="button" class="btn mt-1"
                                                    style="border:1px solid #bbb;margin-left:8px"
                                                    onclick="mediaDelete({{ $media->id }},{{ $workflow->id }})"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            @endif


                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>




                    <div class="form-group mt-2">
                        <div class="d-flex justify-content-between">
                            <span>
                                <button type="submit" class="btn backbg_primary back_textColor">
                                    <i class="fas fa-sync mr-1"></i>Güncelle</button>
                                @if ($workflow->send == 1)
                                    <button type="button" class="btn ml-1  backbg_primary back_textColorV1"
                                        style="padding: 9px" onclick="workflowSend(0,{{ $workflow->id }})"
                                        data-toggle="tooltip" data-placement="top" title="Geri al"><i
                                            class="fas fa-undo"></i></button>
                                @else
                                    <button type="button" class="btn ml-1  backbg_fourthly back_textColorV1"
                                        style="padding: 9px" onclick="workflowSend(1,{{ $workflow->id }})"
                                        data-toggle="tooltip" data-placement="top" title="Gönder"><i
                                            class="fas fa-paper-plane"></i></button>
                                @endif
                            </span>

                            <span>
                                <button type="button" class="btn backbg_fifthly back_textColor" style="padding: 9px"
                                    onclick="workflowDelete({{ $workflow->id }})">
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
    function workflowUpdate(workflow_id) {
        axios({
            method: 'post',
            url: '{{ route('user.workflow_update') }}',
            data: new FormData($('#workflow-update-form')[0])
        }).then(res => {

            $.confirm({
                title: res.data.status == 1 ? 'İşlem başarılı' : 'Hata !',
                content: res.data.status == 1 ? 'İş Akışı güncellendi' :
                    'İş Akışı güncellerken bir hata meydana geldi',
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
                window.location.href = '/uye/is_akisi_duzenle/' +
                    workflow_id;
            }, 500);

        }).catch(err => {

        })
    }

    function workflowDelete(workflow_id) {
        $.confirm({
            title: 'Dikkat, Bu iş akışı silenecek!',
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
                            url: '{{ route('user.workflow.delete') }}',
                            data: {
                                workflow_id: workflow_id
                            }
                        }).then(res => {
                            if (res.data.status == 1) {
                                $.dialog({
                                    title: 'İşlem başarılı',
                                    content: 'iş akışı silindi',
                                    type: 'green',
                                });
                                setTimeout(() => {
                                    window.location.href = '/uye/is_akisi';
                                }, 500);
                            } else {
                                $.dialog({
                                    title: 'Hata',
                                    content: 'İş akışı silinirken hata meydana geldi!',
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


    function workflowSend(status, workflow_id) {
        $.confirm({
            title: status ? 'Dikkat, Bu iş akışı gönderilecek!' : 'İş akışı geri alınacak',
            content: 'Devam etmek istediğinizden emin misiniz?',
            type: 'orange',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: status ? 'Evet, Gönder' : 'Evet, Geri al',
                    btnClass: 'btn-orange',
                    action: function() {
                        axios({
                            method: 'post',
                            url: '{{ route('user.workflow_send') }}',
                            data: {
                                workflow_id: workflow_id,
                                status: status,
                            }
                        }).then(res => {
                            if (res.data.status == 1) {
                                $.dialog({
                                    title: 'İşlem başarılı',
                                    content: res.data.reply ?
                                        'İş akışı yöneticeye gönderildi' :
                                        'İş akışı geri alındı',
                                    type: 'green',
                                });
                                setTimeout(() => {
                                    window.location.href = '/uye/is_akisi_duzenle/' +
                                        workflow_id;
                                }, 500);
                            } else {
                                $.dialog({
                                    title: 'Hata',
                                    content: res.data.reply ?
                                        'İş akışı geri alınırken hata meydana geldi' :
                                        'İş akışı gönderilirken hata meydana geldi!',
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


    function mediaDelete(media_id, workflow_id) {

        $.confirm({
            title: 'Dikkat, Bu dosya silenecek!',
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
                            url: '{{ route('user.media.delete') }}',
                            data: {
                                media_id: media_id
                            }
                        }).then(res => {
                            if (res.data.status == 1) {
                                $.dialog({
                                    title: 'İşlem başarılı',
                                    content: 'Dosya silindi',
                                    type: 'green',
                                });
                                setTimeout(() => {
                                    window.location.href = '/uye/is_akisi_duzenle/' +
                                        workflow_id;
                                }, 500);
                            } else {
                                $.dialog({
                                    title: 'Hata',
                                    content: 'Dosya silinirken hata meydana geldi!',
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
