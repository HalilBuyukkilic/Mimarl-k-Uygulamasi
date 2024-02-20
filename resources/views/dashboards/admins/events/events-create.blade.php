@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'Yeni Etkinlik')

@section('content')

    <section class="content-header">
        <div class="container-fluid content-header-skeleton">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                        <li class="breadcrumb-item">Etkinlikler</li>
                        <li class="breadcrumb-item active">Yeni Etkinlik</li>
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
                        <i class="fas fa-dharmachakra mr-2"></i> Yeni Etkinlik
                    </span>
                    <span>
                        <a href="{{ route('admin.events') }}"
                            class="backbg_fourthly back_textColor content-newform-right-buttons">
                            <i class="fas fa-list"></i> Liste
                        </a>
                        <a href="{{ route('admin.events') }}"
                            class="backbg_secondary back_textColor  mr-1  content-newform-right-buttons">
                            <i class="fas fa-reply"></i> Geri
                        </a>
                    </span>
                </div>
                <hr class="mt-n3">

                <form class="form-horizontal mt-4" enctype="multipart/form-data" onsubmit="eventsCreate();return false;"
                    id="events-create-form">
                    <div class="row">
                        <div class="form-group col-md-10">
                            <label for="title">Başlık <span style="color: red">*</span></label>
                            <input id="title" type="text" class="form-control" name="title" required autofocus
                                placeholder="Başlık giriniz">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="status">Durum</label>
                            <div class="input-group">
                                <select class="custom-select" name="status" id="inputGroupSelect02">
                                    <option value="1">Aktif</option>
                                    <option value="0">Pasif</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="events_images">Etkinlik Resimleri </label>
                        <div class="control-group" id="events_images">
                            <input type="file" name="images[]" class="myfrm form-control" style="height: 45px" multiple>
                        </div>
                    </div>




                    <div class="form-group">
                        <textarea class="ckeditor form-control" name="content" id="events_content"></textarea>
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
                                        <label for="summary">Meta Başlık </label>
                                        <input id="summary" type="text" class="form-control" name="meta_title"
                                            autofocus placeholder="Meta başlık giriniz">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="summary">Meta Anahtar Kelimeler </label>
                                        <input id="summary" type="text" class="form-control" name="meta_keys" autofocus
                                            placeholder="Meta anahtar kelime giriniz">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="summary">Meta Açıklama </label>
                                        <input id="summary" type="text" class="form-control" name="meta_desc" autofocus
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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.ckeditor').ckeditor();
    });


    function eventsCreate() {
        $('#events_content').val(CKEDITOR.instances.events_content.getData().toString());

        axios({
            method: 'post',
            url: '{{ route('admin.events_save') }}',
            data: new FormData($('#events-create-form')[0])
        }).then(res => {

            $.confirm({
                title: res.data.status == 1 ? 'Tebrikler' : 'Hata !',
                content: res.data.status == 1 ? 'Yeni Etkinlik eklendi' :
                    'Etkinlik eklerken bir hata meydana geldi',
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
            document.getElementById('events-create-form').reset();
            CKEDITOR.instances.events_content.setData('');


        }).catch(err => {

        })
    }
</script>
