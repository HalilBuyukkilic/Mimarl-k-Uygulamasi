@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'Yeni Konu')

@section('content')
    <section class="content-header">
        <div class="container-fluid content-header-skeleton">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                        <li class="breadcrumb-item">Konular</li>
                        <li class="breadcrumb-item active">Konu Düzenle</li>
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
                        <i class="fas fa-clipboard-list mr-2"></i>Konu Düzenle
                    </span>
                    <span>
                        <a href="{{ route('admin.topics') }}"
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

                <form class="form-horizontal mt-4" enctype="multipart/form-data" onsubmit="topicUpdate();return false;"
                    id="topic-update-form">
                    <input type="hidden" name="topic_id" value="{{ $topic->id }}">


                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mt-4">
                                <div class="form-group col-md-10">
                                    <label for="title">Başlık <span style="color: red">*</span></label>
                                    <input id="title" type="text" class="form-control" name="title"
                                        value="{{ $topic->title }}" required autofocus placeholder="Başlık giriniz">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="status">Durum</label>
                                    <div class="input-group">
                                        <select class="custom-select" name="status" id="inputGroupSelect02">
                                            <option value="1" {{ $topic->status == 1 ? 'selected' : '' }}>Aktif
                                            </option>
                                            <option value="0" {{ $topic->status == 0 ? 'selected' : '' }}>Pasif
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 mt-3">
                                    <label for="summary">Özet </label>
                                    <input id="summary" type="text" class="form-control" name="summary" autofocus
                                        value="{{ $topic->summary }}" placeholder="Özet giriniz">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="topic_images">Konu Resimleri </label>
                                <div class="control-group" id="topic_images">
                                    <input type="file" name="images[]" accept="image/*" class="myfrm form-control"
                                        style="height: 45px" multiple>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="topic_file">Konu Dosyası </label>
                                <div class="control-group" id="topic_file">
                                    <input type="file" name="file" class="myfrm form-control" style="height: 45px"
                                        accept=".pdf, .doc, .txt" {{ $topic_file['id'] != 0 ? 'disabled' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        @if (is_countable($topic->media) && count($topic->media) > 0)
                            <label for="topic_files">Gönderilen Dosya </label>
                            <div class="row p-2 mt-2" style="background-color:#ddd">
                                @foreach ($topic->media as $media)
                                    @if ($media->author == Auth::user()->id)
                                        <div class="col-md-1 "
                                            style="border: 1px solid #bbb;padding:7px;border-radius:5px;background-color:#fff">
                                            @if ($media->media_type == 'image')
                                                <img src="{{ asset('/storage/konu') . '/' . $media->file_name }}"
                                                    style="height: 50px;width:60px" alt="">
                                                <button type="button" class="btn mt-1"
                                                    style="border:1px solid #bbb;margin-left:10px"
                                                    onclick="mediaDelete({{ $media->id }})"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            @else
                                                @if ($media->media_type == 'doc')
                                                    <a href="{{ asset('/storage/konu') . '/' . $media->file_name }}"
                                                        style="height: 50px;width:70px;margin:10px" alt="">
                                                        @if (explode('.', $media->file_name)[1] == 'pdf')
                                                            <i class="fas fa-file-pdf" style="font-size:50px;color:red"></i>
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
                                                    onclick="mediaDelete({{ $media->id }})"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <textarea class="ckeditor form-control" name="content" id="topic_content">
                        {!! isset($topic->content) ? $topic->content : '' !!}
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
                                            value="{{ $topic->meta_title }}" autofocus placeholder="Meta başlık giriniz">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="meta_keys">Meta Anahtar Kelimeler </label>
                                        <input id="meta_keys" type="text" class="form-control" name="meta_keys"
                                            value="{{ $topic->meta_keys }}" autofocus
                                            placeholder="Meta anahtar kelime giriniz">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="meta_desc">Meta Açıklama </label>
                                        <input id="meta_desc" type="text" class="form-control" name="meta_desc"
                                            value="{{ $topic->meta_desc }}" autofocus
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
                                    onclick="topicDelete({{ $topic->id }})">
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


    function topicUpdate() {
        $('#topic_content').val(CKEDITOR.instances.topic_content.getData().toString());
        axios({
            method: 'post',
            url: '{{ route('admin.topic_update') }}',
            data: new FormData($('#topic-update-form')[0])
        }).then(res => {

            $.confirm({
                title: res.data.status == 1 ? 'İşlem başarılı' : 'Hata !',
                content: res.data.status == 1 ? 'Konu güncellendi' :
                    'Konu güncellerken bir hata meydana geldi',
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
                window.location.reload();
            }, 500);

        }).catch(err => {

        })
    }



    function topicDelete(topic_id) {
        $.confirm({
            title: 'Dikkat, Bu konu silenecek!',
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
                            url: '{{ route('admin.topic.delete') }}',
                            data: {
                                topic_id: topic_id
                            }
                        }).then(res => {
                            if (res.data.status == 1) {
                                $.dialog({
                                    title: 'İşlem başarılı',
                                    content: 'Konu silindi',
                                    type: 'green',
                                });
                                setTimeout(() => {
                                    window.location.href = '{{ route('admin.topics') }}';
                                }, 500);
                            } else {
                                $.dialog({
                                    title: 'Hata',
                                    content: 'Konu silinirken hata meydana geldi!',
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


    function mediaDelete(media_id) {

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
                                    window.location.reload();
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
