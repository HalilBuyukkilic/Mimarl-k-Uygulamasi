@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'İş Akışı Görüntüle')


@section('content')

    <section class="content-header">
        <div class="container-fluid content-header-skeleton">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                        <li class="breadcrumb-item">İş Akışı</li>
                        <li class="breadcrumb-item active">İş Akışı Detayı</li>
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
                        <i class="fas fa-paste mr-2"></i> İş Akışı Detayı
                    </span>
                    <span>
                        <a href="{{ route('admin.workflow') }}"
                            class="backbg_fourthly back_textColor content-newform-right-buttons">
                            <i class="fas fa-list"></i> Liste
                        </a>
                        <a href="{{ route('admin.workflow') }}"
                            class="backbg_secondary back_textColor  mr-1  content-newform-right-buttons">
                            <i class="fas fa-reply"></i> Geri
                        </a>
                    </span>
                </div>
                <hr class="mt-n3">

                <div class="table-responsive-md">
                    <table class="table table-bordered">
                        <thead>

                        </thead>
                        <tbody>
                            <tr>
                                <td width="50%"><b>Gönderen</b></td>
                                <td width="50%">{{ isset($workflow->user) ? $workflow->user->name : '-' }}</td>
                            </tr>
                            <tr>
                                <td width="50%"><b>İş Başlığı</b></td>
                                <td width="50%">{{ isset($workflow->title) ? $workflow->title : '-' }}</td>
                            </tr>
                            <tr>
                                <td width="50%"><b>Müteahhit Adı</b></td>
                                <td width="50%">
                                    {{ isset($workflow->contractor_name) ? $workflow->contractor_name : '-' }}</td>
                            </tr>
                            <tr>
                                <td width="50%"><b>Müteahhit Telefon</b></td>
                                <td width="50%">
                                    {{ isset($workflow->contractor_phone) ? $workflow->contractor_phone : '-' }}</td>
                            </tr>
                            <tr>
                                <td width="50%"><b>İlçe</b></td>
                                <td width="50%">{{ isset($workflow->district) ? $workflow->district : '-' }}</td>
                            </tr>
                            <tr>
                                <td width="50%"><b>Müteahhit Adresi</b></td>
                                <td width="50%">
                                    {{ isset($workflow->contractor_address) ? $workflow->contractor_address : '-' }}
                            </tr>
                            <tr>
                                <td width="50%"><b>İş Metrekaresi</b></td>
                                <td width="50%">
                                    {{ isset($workflow->work_squaremeter) ? $workflow->work_squaremeter : '-' }}</td>
                            </tr>
                            <tr>
                                <td width="50%"><b>Oda Parseli</b></td>
                                <td width="50%">{{ isset($workflow->room_parcel) ? $workflow->room_parcel : '-' }}</td>
                            </tr>
                            <tr>
                                <td width="50%"><b>Yapı Sınıfı</b></td>
                                <td width="50%">
                                    {{ isset($workflow->structure_class) ? $workflow->structure_class : '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="workflow_files">Gelen Dosyalar</label>
                        @if (is_countable($workflow->media) && count($workflow->media) > 0)
                            <div class="row p-2 mt-2" style="background-color:#ddd">
                                @foreach ($workflow->media as $media)
                                    @if ($media->author != Auth::user()->id)
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
                                                            <i class="fas fa-file-pdf" style="font-size:50px;color:red"></i>
                                                        @else
                                                            @if (explode('.', $media->file_name)[1] == 'xlsx')
                                                                <i class="fas fa-file-excel"
                                                                    style="font-size:50px;color:green"></i>
                                                            @else
                                                                @if (explode('.', $media->file_name)[1] == 'doc' || explode('.', $media->file_name)[1] == 'docx')
                                                                    <i class="fas fa-file-word" style="font-size:50px"></i>
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
                                            @endif
                                        </div>
                                    @endif

                                @endforeach
                            </div>
                        @else
                            <div class="d-flex justify-content-center">
                                <span class="alert backbg_fourthly" role="alert">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> Dosya bulunamadı !
                                </span>
                            </div>
                        @endif
                    </div>
                    <br>
                    <div class="form-group col-md-12">
                        @if (is_countable($workflow->media) && count($workflow->media) > 0)
                            <label for="workflow_files">Gönderilen Dosya </label>
                            <div class="row p-2 mt-2" style="background-color:#ddd">
                                @foreach ($workflow->media as $media)
                                    @if ($media->author == Auth::user()->id)
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
                                                            <i class="fas fa-file-pdf" style="font-size:50px;color:red"></i>
                                                        @else
                                                            @if (explode('.', $media->file_name)[1] == 'xlsx')
                                                                <i class="fas fa-file-excel"
                                                                    style="font-size:50px;color:green"></i>
                                                            @else
                                                                @if (explode('.', $media->file_name)[1] == 'doc' || explode('.', $media->file_name)[1] == 'docx')
                                                                    <i class="fas fa-file-word" style="font-size:50px"></i>
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
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>


                <div class="row">

                    <form enctype="multipart/form-data" onsubmit="sendDocs({{ $workflow->id }});return false;"
                        id="send-workDoc-form">
                        <input type="hidden" name="workflow_id" value="{{ $workflow->id }}">
                        <div class="form-group col-md-12">
                            <label for="receipt_money">Dekont Seçiniz </label>
                            <br>
                            <input type="file" name="file">
                        </div>
                        <hr>
                        <div>
                            <button type="submit" class="btn btn-success"
                                {{ count($workflow->media) == 0 ? 'disabled' : '' }}>Gönder</button>
                            <button type="button" class="btn btn-danger"
                                onclick="rejectWorkflow({{ $workflow->id }})">Reddet</button>
                        </div>
                    </form>
                </div>
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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>
<script type="text/javascript">
    function sendDocs(workflow_id) {
        axios({
            method: 'post',
            url: '{{ route('admin.workflow_send_docs') }}',
            data: new FormData($('#send-workDoc-form')[0])
        }).then(res => {
            $.confirm({
                title: res.data.status == 1 ? 'İşlem başarılı' : 'Hata !',
                content: res.data.status == 1 ? 'Dosya gönderildi' :
                    'Dosya gönderilirken bir hata meydana geldi',
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
                window.location.href = '/admin/is_akisi_detayi/' +
                    workflow_id;
            }, 500);
        }).catch(err => {

        })
    }

    function rejectWorkflow(workflow_id) {

        $.confirm({
            title: 'Dikkat, Bu Reddilecek!',
            content: 'Devam etmek istediğinizden emin misiniz?',
            type: 'orange',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Evet, Reddet',
                    btnClass: 'btn-orange',
                    action: function() {
                        axios({
                            method: 'post',
                            url: '{{ route('admin.workflow_reject') }}',
                            data: {
                                workflow_id: workflow_id
                            }
                        }).then(res => {
                            $.confirm({
                                title: res.data.status == 1 ? 'İşlem başarılı' : 'Hata !',
                                content: res.data.status == 1 ? 'iş akışı reddedildi' :
                                    'iş akışı reddedilirken bir hata meydana geldi',
                                type: res.data.status == 1 ? 'green' : 'red',
                                typeAnimated: true,
                                buttons: {
                                    tryAgain: {
                                        text: res.data.status == 1 ? 'Tamam' :
                                            'Tekrar dene',
                                        btnClass: res.data.status == 1 ? 'btn-green' :
                                            'btn-red',
                                        action: function() {}
                                    }
                                }
                            });
                            setTimeout(() => {
                                window.location.href = '/admin/is_akisi_detayi/' +
                                    workflow_id;
                            }, 500);
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
                            url: '{{ route('admin.media.delete') }}',
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
                                    window.location.href = '/admin/is_akisi_detayi/' +
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
</script>
