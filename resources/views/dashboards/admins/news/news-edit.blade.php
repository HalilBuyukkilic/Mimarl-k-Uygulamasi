@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'Haber Düzenle')

@section('content')

    <section class="content-header">
        <div class="container-fluid content-header-skeleton">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                        <li class="breadcrumb-item">Haberler</li>
                        <li class="breadcrumb-item active">Haber Düzenle</li>
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
                        <i class="fas fa-newspaper mr-2"></i>Haber Düzenle
                    </span>
                    <span>
                        <a href="{{ route('admin.news') }}"
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

                <form class="form-horizontal mt-4" enctype="multipart/form-data" onsubmit="newsUpdate();return false;"
                    id="news-update-form">
                    <input type="hidden" name="news_id" value="{{ $news->id }}">
                    <input type="hidden" name="media_id" value="{{ isset($news->media) ? $news->media->id : 0 }}">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group col-md-4">
                                <label class="hoverable">
                                    <div class="imageText">Haber Resmi</div>
                                    <input type='file' name="news_image" id="imgInp"
                                        accept="image/png, image/jpeg, image/jpg,image/webp" />
                                    @if (isset($news->media->file_name))
                                        <img id="newsimg"
                                            src="{{ asset('/storage/haber') . '/' . $news->media->file_name }}"
                                            style="height: 200px;width:250px" />
                                    @else
                                        <img id="newsimg" src="{{ URL::asset('/img/default/default-image.jpg') }}"
                                            style="height: 200px;width:250px" />
                                    @endif

                                    <span style="color:goldenrod">yüklemek veya değiştirmek için resmin üzerine
                                        tıklayın.!</span>
                                </label>
                                <script>
                                    imgInp.onchange = evt => {
                                        const [file] = imgInp.files
                                        if (file) {
                                            newsimg.src = URL.createObjectURL(file)
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row mt-4">
                                <div class="form-group col-md-10">
                                    <label for="title">Başlık <span style="color: red">*</span></label>
                                    <input id="title" type="text" class="form-control" name="title"
                                        value="{{ $news->title }}" required autofocus placeholder="Başlık giriniz">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="status">Durum</label>
                                    <div class="input-group">
                                        <select class="custom-select" name="status" id="inputGroupSelect02">
                                            <option value="1" {{ $news->status == 1 ? 'selected' : '' }}>Aktif</option>
                                            <option value="0" {{ $news->status == 0 ? 'selected' : '' }}>Pasif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 mt-3">
                                    <label for="summary">Özet </label>
                                    <input id="summary" type="text" class="form-control" name="summary" autofocus
                                        value="{{ $news->summary }}" placeholder="Özet giriniz">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <textarea class="ckeditor form-control" name="content" id="news_content">
                            {!! isset($news->content) ? $news->content : '' !!}
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
                                            value="{{ $news->meta_title }}" autofocus placeholder="Meta başlık giriniz">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="meta_keys">Meta Anahtar Kelimeler </label>
                                        <input id="meta_keys" type="text" class="form-control" name="meta_keys"
                                            value="{{ $news->meta_keys }}" autofocus
                                            placeholder="Meta anahtar kelime giriniz">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="meta_desc">Meta Açıklama </label>
                                        <input id="meta_desc" type="text" class="form-control" name="meta_desc"
                                            value="{{ $news->meta_desc }}" autofocus placeholder="Meta açıklama giriniz">
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
                                    onclick="newsDelete({{ $news->id }})">
                                    <i class="fas fa-trash-alt"></i></button>
                                <button type="button" {{ $news->showing_modal ? 'disabled' : '' }}
                                    class="btn backbg_fourthly back_textColor"
                                    onclick="showingModal({{ $news->id }})">
                                    <i
                                        class="{{ $news->showing_modal ? 'far fa-calendar-check' : 'far fa-paper-plane' }}  mr-1"></i>
                                    {{ $news->showing_modal ? 'Yayında' : ' Duyur!' }}
                                </button>
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


    function newsUpdate() {
        $('#news_content').val(CKEDITOR.instances.news_content.getData().toString());
        axios({
            method: 'post',
            url: '{{ route('admin.news_update') }}',
            data: new FormData($('#news-update-form')[0])
        }).then(res => {
            $.confirm({
                title: res.data.status == 1 ? 'İşlem başarılı' : 'Hata !',
                content: res.data.status == 1 ? 'Haber güncellendi' :
                    'Haber güncellerken bir hata meydana geldi',
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
        }).catch(err => {

        })
    }


    function newsDelete(news_id) {
        $.confirm({
            title: 'Dikkat, Bu haber silenecek!',
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
                            url: '{{ route('admin.news.delete') }}',
                            data: {
                                news_id: news_id
                            }
                        }).then(res => {
                            if (res.data.status == 1) {
                                $.dialog({
                                    title: 'İşlem başarılı',
                                    content: 'Haber silindi',
                                    type: 'green',
                                });
                                setTimeout(() => {
                                    window.location.href = '/admin/haberler';
                                }, 500);
                            } else {
                                $.dialog({
                                    title: 'Hata',
                                    content: 'Haber silinirken hata meydana geldi!',
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



    function showingModal(news_id) {
        $.confirm({
            title: 'Dikkat, Bu haber duyuru ekranına aktarılacak',
            content: 'Devam etmek istediğinizden emin misiniz?',
            type: 'blue',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Evet, Duyur !',
                    btnClass: 'btn-blue',
                    action: function() {
                        axios({
                            method: 'post',
                            url: '{{ route('admin.news_showing_modal') }}',
                            data: {
                                news_id: news_id
                            }
                        }).then(res => {
                            if (res.data.status == 1) {
                                $.dialog({
                                    title: 'İşlem başarılı',
                                    content: 'Haber duyuru paneline aktarıldı',
                                    type: 'green',
                                });
                                setTimeout(() => {
                                    window.location.reload();
                                }, 500);
                            } else {
                                $.dialog({
                                    title: 'Hata',
                                    content: 'Haber duyuru ekranına aktrılırken hata meydana geldi!',
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
