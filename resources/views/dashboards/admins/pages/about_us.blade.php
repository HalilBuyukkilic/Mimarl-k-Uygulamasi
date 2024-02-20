@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'Biz Kimiz')
<style>
    #imgInpPresident {
        display: none;
    }

    #imgInp1 {
        display: none;
    }

    #imgInp2 {
        display: none;
    }

    #imgInp3 {
        display: none;
    }

    #imgInp4 {
        display: none;
    }
</style>
@section('content')
    <section class="content-header">
        <div class="container-fluid content-header-skeleton">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                        <li class="breadcrumb-item">Hakkımızda</li>
                        <li class="breadcrumb-item active">Biz Kimiz</li>
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
                        <i class="fas fa-copy mr-2"></i> Biz Kimiz
                    </span>
                    <span>

                    </span>
                </div>
                <hr>

                <form class="form-horizontal mt-4" enctype="multipart/form-data" onsubmit="aboutUsUpdate();return false;"
                    id="about-us-update-form">
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-center">
                            <div class="form-group col-md-4">
                                <label class="hoverable">
                                    <div class="imageText">Başkanın Fotoğrafı</div>
                                    <input type='file' name="president_image" id="imgInpPresident"
                                        accept="image/png, image/jpeg, image/jpg,image/webp" />
                                    @if (isset($aboutUs->president_image))
                                        <img id="presidentimg"
                                            src="{{ asset('/storage/sayfa') . '/' . $aboutUs->president_image }}"
                                            style="height: 200px;width:250px" />
                                    @else
                                        <img id="presidentimg" src="{{ URL::asset('/img/default/default-image.jpg') }}"
                                            style="height: 200px;width:250px" />
                                    @endif
                                    <br>
                                    <span style="color:goldenrod">yüklemek veya değiştirmek için resmin üzerine
                                        tıklayın.!</span>
                                </label>
                                <script>
                                    imgInpPresident.onchange = evt => {
                                        const [file] = imgInpPresident.files
                                        if (file) {
                                            presidentimg.src = URL.createObjectURL(file)
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row mt-1">
                                <div class="form-group col-md-12">
                                    <label for="title">Başkanın Adı Soyadı <span style="color: red">*</span></label>
                                    <input id="title" type="text" class="form-control" name="president_name"
                                        value="{{ isset($aboutUs->president_name) ? $aboutUs->president_name : '' }}"
                                        required autofocus placeholder="başkanın adı soyadı (ünvanı dahil) giriniz">
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="title">Başkanın CV'si </label>
                        <textarea class="ckeditor form-control" name="president_cv" id="president_cv">
                           {!! isset($aboutUs->president_cv) ? $aboutUs->president_cv : '' !!}
                        </textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="hoverable">
                                    <div class="imageText">Başkan Yardımcısı Fotoğrafı1</div>
                                    <input type='file' name="vice_president1_image" id="imgInp1"
                                        accept="image/png, image/jpeg, image/jpg,image/webp" />
                                    @if (isset($aboutUs->vice_president1_image))
                                        <img id="newsimg1"
                                            src="{{ asset('/storage/sayfa') . '/' . $aboutUs->vice_president1_image }}"
                                            style="height: 100px;width:150px" />
                                    @else
                                        <img id="newsimg1" src="{{ URL::asset('/img/default/default-image.jpg') }}"
                                            style="height: 150px;width:200px" />
                                    @endif
                                    <br>
                                    <span style="color:goldenrod">yüklemek veya değiştirmek için resmin üzerine
                                        tıklayın.!</span>
                                </label>
                                <script>
                                    imgInp1.onchange = evt => {
                                        const [file] = imgInp1.files
                                        if (file) {
                                            newsimg1.src = URL.createObjectURL(file)
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="hoverable">
                                    <div class="imageText">Başkan Yardımcısı Fotoğrafı2</div>
                                    <input type='file' name="vice_president2_image" id="imgInp2"
                                        accept="image/png, image/jpeg, image/jpg,image/webp" />
                                    @if (isset($aboutUs->vice_president2_image))
                                        <img id="newsimg2"
                                            src="{{ asset('/storage/sayfa') . '/' . $aboutUs->vice_president2_image }}"
                                            style="height: 100px;width:150px" />
                                    @else
                                        <img id="newsimg2" src="{{ URL::asset('/img/default/default-image.jpg') }}"
                                            style="height: 150px;width:200px" />
                                    @endif
                                    <br>
                                    <span style="color:goldenrod">yüklemek veya değiştirmek için resmin üzerine
                                        tıklayın.!</span>
                                </label>
                                <script>
                                    imgInp2.onchange = evt => {
                                        const [file] = imgInp2.files
                                        if (file) {
                                            newsimg2.src = URL.createObjectURL(file)
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="hoverable">
                                    <div class="imageText">Başkan Yardımcısı Fotoğrafı3</div>
                                    <input type='file' name="vice_president3_image" id="imgInp3"
                                        accept="image/png, image/jpeg, image/jpg,image/webp" />
                                    @if (isset($aboutUs->vice_president3_image))
                                        <img id="newsimg3"
                                            src="{{ asset('/storage/sayfa') . '/' . $aboutUs->vice_president3_image }}"
                                            style="height: 100px;width:150px" />
                                    @else
                                        <img id="newsimg3" src="{{ URL::asset('/img/default/default-image.jpg') }}"
                                            style="height: 150px;width:200px" />
                                    @endif
                                    <br>
                                    <span style="color:goldenrod">yüklemek veya değiştirmek için resmin üzerine
                                        tıklayın.!</span>
                                </label>
                                <script>
                                    imgInp3.onchange = evt => {
                                        const [file] = imgInp3.files
                                        if (file) {
                                            newsimg3.src = URL.createObjectURL(file)
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="hoverable">
                                    <div class="imageText">Başkan Yardımcısı Fotoğrafı4</div>
                                    <input type='file' name="vice_president4_image" id="imgInp4"
                                        accept="image/png, image/jpeg, image/jpg,image/webp" />
                                    @if (isset($aboutUs->vice_president4_image))
                                        <img id="newsimg4"
                                            src="{{ asset('/storage/sayfa') . '/' . $aboutUs->vice_president4_image }}"
                                            style="height: 100px;width:150px" />
                                    @else
                                        <img id="newsimg4" src="{{ URL::asset('/img/default/default-image.jpg') }}"
                                            style="height: 150px;width:200px" />
                                    @endif
                                    <br>
                                    <span style="color:goldenrod">yüklemek veya değiştirmek için resmin üzerine
                                        tıklayın.!</span>
                                </label>
                                <script>
                                    imgInp4.onchange = evt => {
                                        const [file] = imgInp4.files
                                        if (file) {
                                            newsimg4.src = URL.createObjectURL(file)
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group col-md-12">
                                <label for="title">Başkan Yardımcısı Adı Soyadı 1 <span
                                        style="color: red">*</span></label>
                                <input id="title" type="text" class="form-control" name="vice_president1_name"
                                    value="{{ isset($aboutUs) ? $aboutUs->vice_president1_name : '' }}" required autofocus
                                    placeholder="başkan yardımcıs adı soyadı (ünvanı dahil) giriniz">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group col-md-12">
                                <label for="title">Başkan Yardımcısı Adı Soyadı 2 <span
                                        style="color: red">*</span></label>
                                <input id="title" type="text" class="form-control" name="vice_president2_name"
                                    value="{{ isset($aboutUs) ? $aboutUs->vice_president2_name : '' }}" required autofocus
                                    placeholder="başkan yardımcıs adı soyadı (ünvanı dahil) giriniz">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group col-md-12">
                                <label for="title">Başkan Yardımcısı Adı Soyadı 3<span
                                        style="color: red">*</span></label>
                                <input id="title" type="text" class="form-control" name="vice_president3_name"
                                    value="{{ isset($aboutUs) ? $aboutUs->vice_president3_name : '' }}" required autofocus
                                    placeholder="başkan yardımcıs adı soyadı (ünvanı dahil) giriniz">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group col-md-12">
                                <label for="title">Başkan Yardımcısı Adı Soyadı 4 <span
                                        style="color: red">*</span></label>
                                <input id="title" type="text" class="form-control" name="vice_president4_name"
                                    value="{{ isset($aboutUs) ? $aboutUs->vice_president4_name : '' }}" required autofocus
                                    placeholder="başkan yardımcıs adı soyadı (ünvanı dahil) giriniz">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="title">Mimarlar Ananonim Şirketi Hakkında </label>
                        <textarea class="ckeditor form-control" name="architects_company_content" id="architects_company_content">
                           {!! isset($aboutUs->architects_company_content) ? $aboutUs->architects_company_content : '' !!}
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
                                            value="{{ isset($aboutUs) ? $aboutUs->meta_title : '' }}" autofocus
                                            placeholder="Meta başlık giriniz">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="meta_keys">Meta Anahtar Kelimeler </label>
                                        <input id="meta_keys" type="text" class="form-control" name="meta_keys"
                                            autofocus value="{{ isset($aboutUs) ? $aboutUs->meta_keys : '' }}"
                                            placeholder="Meta anahtar kelime giriniz">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="meta_desc">Meta Açıklama </label>
                                        <input id="meta_desc" type="text" class="form-control" name="meta_desc"
                                            autofocus value="{{ isset($aboutUs) ? $aboutUs->meta_desc : '' }}"
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




    function aboutUsUpdate() {
        $('#president_cv').val(CKEDITOR.instances.president_cv.getData().toString());
        $('#architects_company_content').val(CKEDITOR.instances.architects_company_content.getData().toString());

        axios({
            method: 'post',
            url: '{{ route('admin.about_us.update') }}',
            data: new FormData($('#about-us-update-form')[0])
        }).then(res => {

            $.confirm({
                title: res.data.status == 1 ? 'Tebrikler' : 'Hata !',
                content: res.data.status == 1 ? 'Biz kimiz sayfası güncellendi' :
                    'Biz kimiz sayfası güncellenirken bir hata meydana geldi',
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
