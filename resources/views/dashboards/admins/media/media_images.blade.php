@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'Medya/Resimler')

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
                        <li class="breadcrumb-item ">Resimler</li>
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
            <div class="row">
                @if (!is_countable($mediaImages) || count($mediaImages) == 0)
                    <div class="d-flex justify-content-center">
                        <span class="alert backbg_fourthly" role="alert">
                            <i class="fas fa-exclamation-triangle mr-1"></i> Klasör boş !
                        </span>
                    </div>
                @else
                    @foreach ($mediaImages as $item)
                        <div
                            class="col-xl-auto col-lg-auto col-md-auto col-sm-auto col-xs-auto p-2 d-flex justify-content-center">
                            <div style="background-color: #cfd8dc">
                                <img src="{{ asset('/storage/' . $item->modul_type . '/' . $item->file_name) }}"
                                    alt="" height="100" width="120">
                                <hr>
                                <div class="d-flex justify-content-center">
                                    <button class="btn backbg_secondary mb-2" onclick='showImages({{ $item->id }})'><i
                                            class="far fa-eye"></i></button>
                                    <button class="btn backbg_fifthly ml-1 mb-2"
                                        onclick='mediaDelete("{{ $item->modul_type }}",{{ $item->id }})'><i
                                            class="fas fa-trash-alt"></i></button>
                                </div>
                            </div>
                        </div>
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

                <form id="image-save-form" onsubmit="imageSave();return false">
                    <div class="modal-body">
                        <div class="col-md-12 mt-3">
                            <input type="hidden" name="modul_type" value="{{ $modul_type }}">
                            <div class="form-group col-md-8 offset-md-1">
                                <label class="hoverable">
                                    <div class="imageText">Resim</div>
                                    <input type='file' name="media_image" id="imgInp"
                                        accept="image/png, image/jpeg, image/jpg,image/webp" />
                                    <img id="newsimg" src="{{ URL::asset('/img/default/default-image.jpg') }}"
                                        style="height: 250px;width:350px" />
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                        <button type="submit" class="btn btn-success">Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Resim Detayı</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="showImage-modal">

                </div>
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


    function showImages(id) {
        elem = $(this);
        $.get("{{ route('admin.media.image.show') }}", {
                // _token: "{{ csrf_token() }}",
                media_id: id,
            },
            function(ret) {
                if (ret.status == true) {
                    var data = ret.data;
                    $('#showImage-modal').empty();
                    var dynamicData =
                        `<div class="modal-body">
                                <div class="form-group">
                                    <div class="d-flex justify-content-center">
                                        <img src="{{ asset('/storage/' . '`+ data.modul_type+`/`+ data.file_name +`') }}"
                                    alt="" height="250" width="450px">
                                    </div>
                                    <div>
                                        <ul style="list-style-type: none;margin-top:20px">
                                            <li><b>ADI : </b>` + data.file_name + `</li>    
                                            <li><b>MODÜLÜ : </b>` + data.modul_type + `</li>    
                                            <li><b>TÜRÜ : </b>` + data.media_type + `</li>    
                                            <li><b>EKLENME TARİHİ : </b>` + data.created_at + `</li>    
                                            <li><input disabled type="text" style="width:100%" value="{{ asset('/storage/' . '`+ data.modul_type+`/`+ data.file_name +`') }}" id="myInput"><button class="btn btn-info mt-1" onclick="copyUrl()">Uzantıyı kopyala</button></li>    
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                            </div>`;
                    $('#showImage-modal').append(dynamicData);
                    $('#imageModal').modal('show');


                } else {

                }
            }, "json");
    };

    function copyUrl() {
        // Get the text field
        var copyText = document.getElementById("myInput");

        // Select the text field
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.value);

        // Alert the copied text

        $.dialog({
            title: 'Resim URL`i kopyalandı!',
            content: copyText.value,
            type: 'green'
        });
    }


    function mediaDelete(modul_type, id) {

        $.confirm({
            title: 'Dikkat, Bu resim silenecek!',
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
                                media_id: id
                            }
                        }).then(res => {
                            if (res.data.status == 1) {
                                $.dialog({
                                    title: 'İşlem başarılı',
                                    content: 'Resim silindi',
                                    type: 'green',
                                });
                                setTimeout(() => {
                                    window.location.href = '/admin/medya/resimler/' +
                                        modul_type;
                                }, 500);
                            } else {
                                $.dialog({
                                    title: 'Hata',
                                    content: 'Resim silinirken hata meydana geldi!',
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


    function imageSave() {
        axios({
            method: 'post',
            url: '{{ route('admin.media_save') }}',
            data: new FormData($('#image-save-form')[0])
        }).then(res => {
            if (res.data.status == 1) {
                $.dialog({
                    title: 'İşlem başarılı!',
                    content: 'Yeni resim eklendi',
                    type: 'green'
                });
                document.getElementById('image-save-form').reset();
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
