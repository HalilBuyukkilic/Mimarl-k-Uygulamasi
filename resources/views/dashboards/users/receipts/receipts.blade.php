@extends('dashboards.users.layouts.user-dash-layout')
@section('title', 'Dekontlar')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<style>
    .hoverbg:hover {
        background-color: #e55353 !important;
    }
</style>
@section('content')

    <section class="content-header">
        <div class="container-fluid content-header-skeleton">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                        <li class="breadcrumb-item active">Dekontlar</li>
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card p-5 mt-3" style="background-color: white">
                        <div class="d-flex justify-content-between">
                            <span style="font-size: 22px;">
                                <i class="fas fa-receipt mr-1"></i> Dekontlar Listesi
                            </span>
                            <span>
                                {{-- <div class="btn-group dropleft" style="margin-top: 5px">
                                    <a type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('user.deleted.receipts') }}"
                                            class="ml-1 back_textColor backbg_fourthly p-1">
                                            <i class="far fa-eye-slash"></i> Silinen Dekontlar
                                        </a>
                                    </div>
                                </div> --}}

                                <a type="button" class="backbg_primary back_textColor content-datatable-create-button"
                                    data-bs-toggle="modal" data-bs-target="#receiptAddModal">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                            </span>
                        </div>
                        <hr style="border:5px solid black;margin-top:-20px">
                        <table id="receipts" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: center">#</th>
                                    <th style="text-align: center">Dekont</th>
                                    <th style="text-align: center">Tarih</th>
                                    <th style="text-align: center">Açıklama</th>
                                    <th style="text-align: center">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>
    </section>





    <!--add Modal -->
    <div class="modal fade" id="receiptAddModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addModalLabel">Dekont Ekle</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="receipt-save-form" onsubmit="receiptSave();return false">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="receipt_money">Dekont Seçiniz </label>
                                <br>
                                <input type="file" name="file">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="receipt_desc">Açıklama </label>
                                <input id="receipt_desc" type="text" class="form-control" name="desc" autofocus
                                    placeholder="Açıklama giriniz">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                        <button type="submit" class="btn backbg_primary back_textColor"><i
                                class="fas fa-save mr-1"></i>Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!--edit Modal -->
    <div class="modal fade" id="receiptEditModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Dekont Güncelle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="showEdit-modal">

                </div>
            </div>
        </div>
    </div>



    <section style="height: 100px">
    </section>


@endsection

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src=" {{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script>
    $(document).ready(function() {
        $.noConflict();
        let receiptsDT = $("#receipts").DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.3/i18n/tr.json"
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "{{ url('uye/dekontlar_veritablosu') }}",
                type: 'GET'
            },
            columns: [{
                    data: 'id',
                    className: 'text-center'
                },
                {
                    data: null,
                    name: '',
                    className: 'text-center',
                    render: function(data) {
                        return data.media.file_name;
                    }
                },
                {
                    data: null,
                    name: '',
                    className: 'text-center',
                    render: function(data) {
                        return formatDate(data.created_at);
                    }
                },
                {
                    data: 'desc',
                    className: 'text-center'
                },
                {
                    data: null,
                    name: '',
                    className: 'text-center',
                    render: function(data) {
                        var html = '';
                        html +=
                            '<a class="btn mr-1 backbg_thirdly back_textColorV1 receipt-edit" data-id=' +
                            data.id +
                            '   data-toggle="tooltip" data-placement="top" title="Düzenle"><i class="fas fa-wrench"></i></a>';
                        html +=
                            `<a class="btn backbg_primary back_textColor" href ="{{ asset('/storage/' . '`+ data.media.modul_type+`/`+ data.media.file_name +`') }}"  data-toggle="tooltip" data-placement="top" title="Görüntüle"><i class="fas fa-desktop"></i></a>`;

                        if (data.okay == 0) {
                            if (data.send == 1) {
                                html +=
                                    '<a class="btn ml-1  backbg_primary back_textColorV1 " onclick="receiptSend(' +
                                    0 + ',' +
                                    data.id +
                                    ' )"  data-toggle="tooltip" data-placement="top" title="Geri al"><i class="fas fa-undo"></i></a>';
                            } else {
                                html +=
                                    '<a class="btn ml-1  backbg_fourthly back_textColorV1 " onclick="receiptSend(' +
                                    1 + ',' + data
                                    .id +
                                    ' )"  data-toggle="tooltip" data-placement="top" title="Gönder"><i class="fas fa-paper-plane"></i></a>';
                            }
                        }

                        html +=
                            '<a class="btn ml-1 backbg_fourthly back_textColorV1 hoverbg"  onclick="receiptDelete(' +
                            data.id +
                            ' )"   data-toggle="tooltip" data-placement="top" title="Sil"><i class="fas fa-trash-alt"></i></a>';


                        return html;

                    },
                    searchable: false,
                    orderable: false
                }
            ],
            "createdRow": function(row, data, index) {

                if (data.okay == 1) {
                    $('td', row).css('background-color', '#a5d6a7');
                }
                if (data.okay == 2) {
                    $('td', row).css('background-color', '#ffcdd2');
                }

            }
        });


        $.dataTableReload = function() {
            receiptsDT.ajax.reload();
        }

        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [day, month, year].join('.');
        }


        $('#receipts').on("click", 'a.receipt-edit', function() {
            var id = $(this).data('id');
            $.get("{{ route('user.receipt_edit') }}", {
                    // _token: "{{ csrf_token() }}",
                    receipt_id: id,
                },
                function(ret) {
                    if (ret.status == true) {
                        var data = ret.data;
                        $('#showEdit-modal').empty();
                        var dynamicData =
                            `<form id="receipt-update-form" onsubmit="receiptUpdate();return false">
                            <div class="row p-3">
                                   <input class="input-group p-1" type="hidden" name="receipt_id" value="` + data.id + `" ">
                                   <input class="input-group p-1" type="hidden" name="media_id" value="` + data.media
                            .id + `" ">
                                    <div class="form-group col-md-12">
                                        <label for="receipt_filename">Mevcut Dosya </label>
                                        <br>
                                        <input class="input-group p-1" type="text"  value="` + data.media
                            .file_name +
                            `" disabled>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="receipt_money">Dekont Seçiniz </label>
                                        <br>
                                        <input type="file" name="file">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="receipt_desc">Açıklama </label>
                                        <input id="receipt_desc" type="text" class="form-control" name="desc" value="` +
                            data
                            .desc + `"
                                            placeholder="Açıklama giriniz">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                                <button type="submit" class="btn backbg_primary back_textColor"><i
                                        class="fas fa-sync mr-1"></i>Güncelle</button>
                            </div>
                            </form>
                            `;
                        $('#showEdit-modal').append(dynamicData);
                        $('#receiptEditModal').modal('show');

                    } else {

                    }
                }, "json");
        });


    });




    function receiptSave() {

        axios({
            method: 'post',
            url: '{{ route('user.receipt_save') }}',
            data: new FormData($('#receipt-save-form')[0])
        }).then(res => {
            if (res.data.status == 1) {
                $.dialog({
                    title: 'İşlem başarılı!',
                    content: 'Yeni dekont eklendi',
                    type: 'green'
                });
                document.getElementById('receipt-save-form').reset();
                $.dataTableReload();
                $('#receiptAddModal').modal('hide');
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




    function receiptUpdate() {
        axios({
            method: 'post',
            url: '{{ route('user.receipt_update') }}',
            data: new FormData($('#receipt-update-form')[0])
        }).then(res => {
            if (res.data.status == 1) {
                $.dialog({
                    title: 'İşlem başarılı!',
                    content: 'Yeni dekont güncellendi',
                    type: 'green'
                });
                document.getElementById('receipt-update-form').reset();
                $.dataTableReload();
                $('#receiptEditModal').modal('hide');
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


    function receiptSend(status, receipt_id) {
        $.confirm({
            title: status ? 'Dikkat, Bu dekont gönderilecek!' : 'Dekont geri alınacak',
            content: 'Devam etmek istediğinizden emin misiniz?',
            type: 'orange',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: status ? 'Evet, Gönder' : 'Evet, Geri al',
                    btnClass: 'btn-orange',
                    action: function() {
                        axios({
                            method: 'post',
                            url: '{{ route('user.receipt_send') }}',
                            data: {
                                receipt_id: receipt_id,
                                status: status,
                            }
                        }).then(res => {
                            if (res.data.status == 1) {
                                $.dialog({
                                    title: 'İşlem başarılı',
                                    content: res.data.reply ?
                                        'Dekont yöneticeye gönderildi' :
                                        'Dekont geri alındı',
                                    type: 'green',
                                });
                                $.dataTableReload();
                                notification();
                            } else {
                                $.dialog({
                                    title: 'Hata',
                                    content: res.data.reply ?
                                        'Dekont geri alınırken hata meydana geldi' :
                                        'Dekont gönderilirken hata meydana geldi!',
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



    function receiptDelete(receipt_id) {
        $.confirm({
            title: 'Dikkat, Bu Dekont silenecek!',
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
                            url: '{{ route('user.receipt.delete') }}',
                            data: {
                                receipt_id: receipt_id
                            }
                        }).then(res => {
                            if (res.data.status == 1) {
                                $.dialog({
                                    title: 'İşlem başarılı',
                                    content: 'Dekont silindi',
                                    type: 'green',
                                });
                                $.dataTableReload();
                            } else {
                                $.dialog({
                                    title: 'Hata',
                                    content: 'Dekont silinirken hata meydana geldi!',
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


    function notification() {
        axios({
            method: 'get',
            url: '{{ route('user.dekont_add_notification') }}',
        }).then(res => {}).catch(err => {

        });
    }
</script>
