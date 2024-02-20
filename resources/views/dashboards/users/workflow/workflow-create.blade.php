@extends('dashboards.users.layouts.user-dash-layout')
@section('title', 'Yeni İş Akışı')

@section('content')

    <section class="content-header">
        <div class="container-fluid content-header-skeleton">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                        <li class="breadcrumb-item">İş Akışı</li>
                        <li class="breadcrumb-item active">Yeni İş Akışı</li>
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
                        <i class="fas fa-paste mr-2"></i> Yeni İş Akışı
                    </span>
                    <span>
                        <a href="{{ route('user.workflow') }}"
                            class="backbg_fourthly back_textColor content-newform-right-buttons">
                            <i class="fas fa-list"></i> Liste
                        </a>
                        <a href="{{ route('user.workflow') }}"
                            class="backbg_secondary back_textColor  mr-1  content-newform-right-buttons">
                            <i class="fas fa-reply"></i> Geri
                        </a>
                    </span>
                </div>
                <hr class="mt-n3">

                <form class="form-horizontal mt-4" enctype="multipart/form-data" onsubmit="workflowCreate();return false;"
                    id="workflow-create-form">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="title">Başlık <span style="color: red">*</span></label>
                            <input id="title" type="text" class="form-control" name="title" required autofocus
                                placeholder="Başlık giriniz">
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="work_squaremeter">İş Metrekaresi </label>
                            <input id="work_squaremeter" type="text" class="form-control" name="work_squaremeter"
                                autofocus placeholder="İş metrekaresi giriniz">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="room_area">Ada</label>
                            <input id="room_area" type="text" class="form-control" name="room_area" autofocus
                                placeholder="Ada giriniz">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="room_parcel">Parsel</label>
                            <input id="room_parcel" type="text" class="form-control" name="room_parcel" autofocus
                                placeholder="Parsel giriniz">
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="structure_class">Yapı Sınıfı</label>
                            <input id="structure_class" type="text" class="form-control" name="structure_class" autofocus
                                placeholder="Yapı sınıfı giriniz">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="contractor_name">Müteahhit Adı </label>
                            <input id="contractor_name" type="text" class="form-control" name="contractor_name" autofocus
                                placeholder="müteahhit adı giriniz">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="contractor_phone">Müteahhit Telefonu </label>
                            <input id="contractor_phone" type="text" class="form-control" name="contractor_phone"
                                autofocus placeholder="müteahhit telefonu giriniz">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="district">İlçe</label>
                            <input id="district" type="text" class="form-control" name="district" autofocus
                                placeholder="İlçe giriniz">
                        </div>
                        <div class="form-group col-md-8">
                            <label for="contractor_address">Müteahhit Adresi</label>
                            <input id="contractor_address" type="text" class="form-control" name="contractor_address"
                                autofocus placeholder="Müteahhit adresi giriniz">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="workflow_files">İş Akışı Dosyaları </label>
                        <div class="control-group" id="workflow_files">
                            <input type="file" name="files[]" class="myfrm form-control" style="height: 45px"
                                multiple>
                        </div>
                    </div>

                    <hr>
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
    function workflowCreate() {

        axios({
            method: 'post',
            url: '{{ route('user.workflow_save') }}',
            data: new FormData($('#workflow-create-form')[0])
        }).then(res => {

            $.confirm({
                title: res.data.status == 1 ? 'Tebrikler' : 'Hata !',
                content: res.data.status == 1 ? 'Yeni iş akışı eklendi' :
                    'İş akışı eklerken bir hata meydana geldi',
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
            document.getElementById('workflow-create-form').reset();

        }).catch(err => {

        })
    }
</script>
