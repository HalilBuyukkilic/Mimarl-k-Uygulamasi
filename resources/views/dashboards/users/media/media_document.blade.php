@extends('dashboards.users.layouts.user-dash-layout')
@section('title', 'Medya/Dosyalar')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<style>
    .tabs_color.active {
        background-color: #f9b115 !important;
    }
</style>
@section('content')

    <section class="content-header">
        <div class="container-fluid content-header-skeleton">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                        <li class="breadcrumb-item">Medya</li>
                        <li class="breadcrumb-item ">Dosyalar</li>
                        <li class="breadcrumb-item active">{{ $modul_type }}</li>
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
        <div class="container-fluid p-2" style="background-color: #fff ">
            <div class="d-flex justify-content-center">
                <a onclick="return_back();return false;"
                    class="backbg_secondary back_textColor  mr-1 mt-2 mb-n1  content-newform-right-buttons">
                    <i class="fas fa-reply"></i> Geri
                </a>
                <a data-toggle="modal" data-target="#exampleModalCenter"
                    class="backbg_primary back_textColor mr-1 mt-2 mb-n1 content-newform-right-buttons">
                    <i class="fas fa-plus-circle mt-1"></i>
                </a>
            </div>
            <hr style="border-color:#f9b115">
            <div class="row p-2">
                @if (!is_countable($docsMedia) || count($docsMedia) == 0)
                    <div class="d-flex justify-content-center">
                        <span class="alert backbg_fourthly" role="alert">
                            <i class="fas fa-exclamation-triangle mr-1"></i> Klasör boş !
                        </span>
                    </div>
                @else
                    @foreach ($docsMedia as $media)
                        @if ($media->author == Auth::user()->id)
                            <div class="col-md-1 m-2"
                                style="border: 1px solid #bbb;padding:7px;border-radius:5px;background-color:#fff">
                                <a href="{{ asset('/storage/') . '/' . $modul_type . '/' . $media->file_name }}"
                                    style="height: 50px;width:70px;margin:10px" alt="">
                                    @if (explode('.', $media->file_name)[1] == 'pdf')
                                        <i class="fas fa-file-pdf" style="font-size:50px;color:red"></i>
                                    @else
                                        @if (explode('.', $media->file_name)[1] == 'xlsx')
                                            <i class="fas fa-file-excel" style="font-size:50px;color:green"></i>
                                        @else
                                            @if (explode('.', $media->file_name)[1] == 'doc' || explode('.', $media->file_name)[1] == 'docx')
                                                <i class="fas fa-file-word" style="font-size:50px"></i>
                                            @else
                                                @if (explode('.', $media->file_name)[1] == 'txt')
                                                    <i class="fas fa-file-alt" style="font-size:50px;color:#80deea"></i>
                                                @else
                                                    <i class="fas fa-file-archive" style="font-size:50px;color:#ffd180"></i>
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                </a>
                                <button type="button" class="btn mt-1" style="border:1px solid #bbb;margin-left:8px"
                                    onclick="mediaDelete({{ $media->id }})"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </section>



    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <form id="file-save-form" onsubmit="documentSave();return false">
                    <div class="modal-body">
                        <div class="col-md-12 mt-3">
                            <input type="hidden" name="modul_type" value="{{ $modul_type }}">
                            <div class="form-group col-md-8 offset-md-1">
                                <div class="form-group col-md-12">
                                    <label for="receipt_money">Dekont Seçiniz </label>
                                    <br>
                                    <input type="file" name="file" accept=".pdf, .doc, .txt">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                        <button type="submit" class="btn btn-success">Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <section style="height: 100px">
    </section>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>
<script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
<script>
    function return_back() {
        window.history.back();
    };





    function mediaDelete(id) {

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
                                media_id: id
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


    function documentSave() {
        axios({
            method: 'post',
            url: '{{ route('user.media_save') }}',
            data: new FormData($('#file-save-form')[0])
        }).then(res => {
            if (res.data.status == 1) {
                $.dialog({
                    title: 'İşlem başarılı!',
                    content: 'Yeni dosya eklendi',
                    type: 'green'
                });
                document.getElementById('file-save-form').reset();
                setTimeout(() => {
                    window.location.reload();
                }, 500);
                $('#exampleModalCenter').modal('hide');
            } else {
                $.dialog({
                    title: 'hata!',
                    content: 'beklenmeyen bir sorun oluştu',
                    type: 'red'
                });
            }
        }).catch(err => {

        })
    }
</script>
