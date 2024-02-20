@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'Oda kaydı')

@section('content')
    <section class="content-header">
        <div class="container-fluid content-header-skeleton">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                        <li class="breadcrumb-item">Hakkımızda</li>
                        <li class="breadcrumb-item active">Oda Kaydı Nasıl Yapılır</li>
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
                        <i class="fas fa-copy mr-2"></i> Oda Kaydı Nasıl Yapılır
                    </span>
                    <span>

                    </span>
                </div>
                <hr>

                <form class="form-horizontal mt-4" enctype="multipart/form-data"
                    onsubmit="roomRegisterUpdate();return false;" id="room-register-update-form">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group col-md-4">
                                <label class="hoverable">
                                    <div class="imageText">Mali Müşavir Resim Alanı</div>
                                    <input type='file' name="financial_advisor_image" id="imgInp"
                                        accept="image/png, image/jpeg, image/jpg,image/webp" />
                                    @if (isset($roomRegister->financial_advisor_image))
                                        <img id="newsimg"
                                            src="{{ asset('/storage/sayfa') . '/' . $roomRegister->financial_advisor_image }}"
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
                                <div class="form-group col-md-12">
                                    <label for="title">Mali Müşavir Harita Uzantısı <span
                                            style="color: red">*</span></label>
                                    <input id="title" type="text" class="form-control" name="financial_advisor_map"
                                        value="{{ isset($roomRegister) ? $roomRegister->financial_advisor_map : '' }}"
                                        required autofocus placeholder="harita uzantısı giriniz">
                                </div>

                                @if (isset($roomRegister->room_register_file))
                                    <div class="mt-3 ml-3" style="border:1px solid #ddd;padding:5px 2px;border-radius:5px">
                                        <a href="{{ asset('/storage/sayfa') . '/' . $roomRegister->room_register_file }}"
                                            style="height: 50px;width:70px;margin:10px" alt="">
                                            @if (explode('.', $roomRegister->room_register_file)[1] == 'pdf')
                                                <i class="fas fa-file-pdf" style="font-size:50px;color:red"></i>
                                            @else
                                                @if (explode('.', $roomRegister->room_register_file)[1] == 'xlsx')
                                                    <i class="fas fa-file-excel" style="font-size:50px;color:green"></i>
                                                @else
                                                    @if (explode('.', $roomRegister->room_register_file)[1] == 'doc' ||
                                                            explode('.', $roomRegister->room_register_file)[1] == 'docx')
                                                        <i class="fas fa-file-word" style="font-size:50px"></i>
                                                    @else
                                                        @if (explode('.', $roomRegister->room_register_file)[1] == 'txt')
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
                                    <button class="btn mt-3" type="button" onclick="mediaDelete()">
                                        <i class="fas fa-trash-alt"
                                            style="border: 1px solid #ddd;padding:5px; margin-left:-13px; color:gold"></i>
                                    </button>
                                @else
                                    <div class="form-group col-md-12 mt-3">
                                        <div class="form-group">
                                            <label for="file">Oda Kaydı Dosyası </label>
                                            <div class="control-group" id="file">
                                                <input type="file" name="room_register_file" class="myfrm form-control"
                                                    style="height: 45px" accept=".pdf, .doc, .txt">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <textarea class="ckeditor form-control" name="content" id="room_register">
                            {!! isset($roomRegister->content) ? $roomRegister->content : '' !!}
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
                                            value="{{ isset($roomRegister) ? $roomRegister->meta_title : '' }}" autofocus
                                            placeholder="Meta başlık giriniz">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="meta_keys">Meta Anahtar Kelimeler </label>
                                        <input id="meta_keys" type="text" class="form-control" name="meta_keys"
                                            autofocus value="{{ isset($roomRegister) ? $roomRegister->meta_keys : '' }}"
                                            placeholder="Meta anahtar kelime giriniz">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="meta_desc">Meta Açıklama </label>
                                        <input id="meta_desc" type="text" class="form-control" name="meta_desc"
                                            autofocus value="{{ isset($roomRegister) ? $roomRegister->meta_desc : '' }}"
                                            placeholder="Meta açıklama giriniz">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mt-2">
                        <div class="col-sm-3">
                            <button type="submit" class="btn backbg_primary back_textColor"><i
                                    class="fas fa-save mr-1"></i>Kaydet</button>
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
<script src=" {{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.ckeditor').ckeditor();
    });


    function roomRegisterUpdate() {
        $('#room_register').val(CKEDITOR.instances.room_register.getData().toString());

        axios({
            method: 'post',
            url: '{{ route('admin.room_register.update') }}',
            data: new FormData($('#room-register-update-form')[0])
        }).then(res => {

            $.confirm({
                title: res.data.status == 1 ? 'Tebrikler' : 'Hata !',
                content: res.data.status == 1 ? 'Oda sayfası güncellendi' :
                    'Oda sayfası güncellenirken bir hata meydana geldi',
                type: res.data.status == 1 ? 'green' : 'red',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: 'Tamam',
                        btnClass: 'btn-green',
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


    function mediaDelete() {

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
                            url: '{{ route('admin.room_register.file_delete') }}',
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
</script>
