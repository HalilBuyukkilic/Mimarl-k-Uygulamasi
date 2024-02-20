@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'Yarışma Düzenle')

@section('content')

    <section class="content-header">
        <div class="container-fluid content-header-skeleton">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                        <li class="breadcrumb-item">Yarışmalar</li>
                        <li class="breadcrumb-item active">Yarışma Düzenle</li>
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
                        <i class="fas fa-shapes mr-2"></i>Yarışma Düzenle
                    </span>
                    <span>
                        <a href="{{ route('admin.competition') }}"
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
                    onsubmit="competitionUpdate();return false;" id="competition-update-form">
                    <input type="hidden" name="competition_id" value="{{ $competition->id }}">

                    <div class="row">
                        <div class="form-group col-md-3">
                            <div class="form-group col-md-4">
                                <label class="hoverable">
                                    <div class="imageText">Yarışma Afişi <span style="color: red">*</span></div>
                                    <input type='file' name="competition_image" id="imgInp"
                                        accept="image/png, image/jpeg, image/jpg,image/webp" />
                                    @if (is_countable($competition->media) && count($competition->media) > 0)
                                        @foreach ($competition->media as $media)
                                            @if ($media->media_type == 'image')
                                                <img id="competitionimg"
                                                    src="{{ asset('/storage/yarisma') . '/' . $media->file_name }}"
                                                    style="height: 200px;width:250px" />
                                                <input type="hidden" name="media_id" value="{{ $media->id }}">
                                            @endif
                                        @endforeach
                                    @else
                                        <img id="competitionimg" src="{{ URL::asset('/img/default/default-image.jpg') }}"
                                            style="height: 200px;width:250px" />
                                    @endif
                                    <span style="color:goldenrod">yüklemek veya değiştirmek için resmin üzerine
                                        tıklayın.!</span>
                                </label>
                                <script>
                                    imgInp.onchange = evt => {
                                        const [file] = imgInp.files
                                        if (file) {
                                            competitionimg.src = URL.createObjectURL(file)
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                        <div class="form-group col-md-9">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="title">Başlık <span style="color: red">*</span></label>
                                    <input id="title" type="text" class="form-control" name="title"
                                        value="{{ $competition->title }}" required autofocus placeholder="Başlık giriniz">
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="row pl-3">
                                        @if ($competition_file['id'] != 0)
                                            <div class="mt-3"
                                                style="border:1px solid #ddd;padding:5px 2px;border-radius:5px">
                                                <a href="{{ asset('/storage/yarisma') . '/' . $competition_file->file_name }}"
                                                    style="height: 50px;width:70px;margin:10px" alt="">
                                                    @if (explode('.', $competition_file->file_name)[1] == 'pdf')
                                                        <i class="fas fa-file-pdf" style="font-size:50px;color:red"></i>
                                                    @else
                                                        @if (explode('.', $competition_file->file_name)[1] == 'xlsx')
                                                            <i class="fas fa-file-excel"
                                                                style="font-size:50px;color:green"></i>
                                                        @else
                                                            @if (explode('.', $competition_file->file_name)[1] == 'doc' || explode('.', $competition_file->file_name)[1] == 'docx')
                                                                <i class="fas fa-file-word" style="font-size:50px"></i>
                                                            @else
                                                                @if (explode('.', $competition_file->file_name)[1] == 'txt')
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
                                            </div>
                                            <button class="btn mt-3" type="button"
                                                onclick="mediaDelete({{ $competition_file->id }},{{ $competition->id }})">
                                                <i class="fas fa-trash-alt"
                                                    style="border: 1px solid #ddd;padding:5px; margin-left:-13px; color:gold"></i>
                                            </button>
                                        @else
                                            <div class="form-group">
                                                <label for="competition_file">Yarışma Dosyası </label>
                                                <div class="control-group" id="competition_file">
                                                    <input type="file" name="file" class="myfrm form-control"
                                                        style="height: 45px" accept=".pdf, .doc, .txt">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="countImages">Resim Sayısı <span style="color: red">*</span></label>
                                    <div class="input-group">
                                        <select class="custom-select" name="countImage" id="countImages"
                                            style="height: 45px">
                                            <option value="1" {{ $competition->countImage == 1 ? 'selected' : '' }}>1
                                                Resim
                                            </option>
                                            <option value="2" {{ $competition->countImage == 2 ? 'selected' : '' }}>2
                                                Resim
                                            </option>
                                            <option value="3" {{ $competition->countImage == 3 ? 'selected' : '' }}>3
                                                Resim
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="row mb-2 mt-n2">
                        <div class="form-group col-md-6">
                            <label for="type">Başlangıç Tarihi <span style="color: red">*</span></label>
                            <input type="datetime-local" class="form-control" name="start_date"
                                value="{{ $competition->start_date }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="type">Bitiş Tarihi <span style="color: red">*</span></label>
                            <input type="datetime-local" class="form-control" name="end_date"
                                value="{{ $competition->end_date }}" required>
                        </div>
                    </div>


                    <div class="form-group">
                        <textarea class="ckeditor form-control" name="content" id="competition_content">
                            {!! isset($competition->content) ? $competition->content : '' !!}
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
                                            value="{{ $competition->meta_title }}" autofocus
                                            placeholder="Meta başlık giriniz">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="meta_keys">Meta Anahtar Kelimeler </label>
                                        <input id="meta_keys" type="text" class="form-control" name="meta_keys"
                                            value="{{ $competition->meta_keys }}" autofocus
                                            placeholder="Meta anahtar kelime giriniz">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="meta_desc">Meta Açıklama </label>
                                        <input id="meta_desc" type="text" class="form-control" name="meta_desc"
                                            value="{{ $competition->meta_desc }}" autofocus
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
                                    onclick="competitionDelete({{ $competition->id }})">
                                    <i class="fas fa-trash-alt"></i></button>
                                @if ($competition->status)
                                    <button type="button" class="btn backbg_fifthly back_textColor"
                                        onclick="publishCompetition(0,{{ $competition->id }})">
                                        <i class="fas fa-hand-paper"></i> Bitir
                                    </button>
                                @else
                                    <button type="button" class="btn backbg_secondary back_textColor"
                                        onclick="publishCompetition(1,{{ $competition->id }})">
                                        <i class="far fa-paper-plane mr-1"></i>
                                        Başlat!
                                    </button>
                                @endif

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


    function competitionUpdate() {
        $('#competition_content').val(CKEDITOR.instances.competition_content.getData().toString());

        axios({
            method: 'post',
            url: '{{ route('admin.competition_update') }}',
            data: new FormData($('#competition-update-form')[0])
        }).then(res => {

            $.confirm({
                title: res.data.status == 1 ? 'İşlem başarılı' : 'Hata !',
                content: res.data.status == 1 ? 'Yarışma güncellendi' :
                    'Yarışma güncellerken bir hata meydana geldi',
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

    function competitionDelete(competition_id) {
        $.confirm({
            title: 'Dikkat, Bu yarışma silenecek!',
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
                            url: '{{ route('admin.competition.delete') }}',
                            data: {
                                competition_id: competition_id
                            }
                        }).then(res => {
                            if (res.data.status == 1) {
                                $.dialog({
                                    title: 'İşlem başarılı',
                                    content: 'Yarışma silindi',
                                    type: 'green',
                                });
                                setTimeout(() => {
                                    window.location.href = '/admin/yarismalar';
                                }, 500);
                            } else {
                                $.dialog({
                                    title: 'Hata',
                                    content: 'Yarışma silinirken hata meydana geldi!',
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

    function publishCompetition(status, competition_id) {
        $.confirm({
            title: 'Dikkat, Bu Yarışma başlatılacak',
            content: 'Devam etmek istediğinizden emin misiniz?',
            type: 'blue',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: status ? 'Evet, Başlat' : 'Evet, Durdur',
                    btnClass: 'btn-blue',
                    action: function() {
                        axios({
                            method: 'post',
                            url: '{{ route('admin.competition_publish') }}',
                            data: {
                                competition_id: competition_id,
                                status: status
                            }
                        }).then(res => {
                            if (res.data.status == 1) {
                                $.dialog({
                                    title: 'İşlem başarılı',
                                    content: status ? 'Yarışma başladı' : 'Yarışma bitti',
                                    type: 'green',
                                });
                                setTimeout(() => {
                                    window.location.reload();
                                }, 500);
                            } else {
                                $.dialog({
                                    title: 'Hata',
                                    content: status ?
                                        'Yarışma başlatılırken hata meydana geldi!' :
                                        'Yarışma bitirilirken hata meydana geldi!',
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


    function mediaDelete(media_id, competition_id) {

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
                                    window.location.href = '/admin/yarisma_duzenle/' +
                                        competition_id;
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
