@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'Girdi Çıktılar')
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
                        <li class="breadcrumb-item active">Girdi Çıktılar</li>
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
                                <i class="fas fa-calculator mr-1"></i> Girdi Çıktılar Listesi
                            </span>
                            <span>
                                <a type="button" class="backbg_primary back_textColor content-datatable-create-button"
                                    style="margin-top: 5px" data-bs-toggle="modal" data-bs-target="#priceAddModal">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                            </span>
                        </div>
                        <hr style="border:5px solid black;margin-top:-20px">
                        <table id="calculate" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center">#</th>
                                    <th style="text-align: center">Fiyat</th>
                                    <th style="text-align: center">Tipi</th>
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
    <div class="modal fade" id="priceAddModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addModalLabel">Para Hesabı</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="price-save-form" onsubmit="priceSave();return false">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label for="price_money">Fiyat </label>
                                <input id="price_money" type="number" class="form-control money-type" name="price"
                                    required autofocus placeholder="Fiyat giriniz">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="type">Tipi</label>
                                <div class="input-group">
                                    <select class="custom-select" name="type" id="inputGroupSelect02" required>
                                        <option value="1">Girdi</option>
                                        <option value="0">Çıktı</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="type">Tarih</label>
                                <input type="date" class="form-control" name="date" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="price_desc">Açıklama </label>
                                <input id="price_desc" type="text" class="form-control" name="desc" autofocus
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
    <div class="modal fade" id="priceEditModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Para Hesabı Düzenle</h5>
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
<script src=" {{ asset('js/jquery.mask.js') }}"></script>
<script>
    $(document).ready(function() {

        $.noConflict();
        // $('#price_money').mask('000.000.000,00', {
        //     reverse: true
        // });


        let calculateDT = $("#calculate").DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.3/i18n/tr.json"
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "{{ url('admin/girdi_ciktilar_veritablosu') }}",
                type: 'GET'
            },
            columns: [{
                    data: 'id',
                    className: 'text-center'
                },
                {
                    data: 'price',
                    className: 'text-center'
                },
                {
                    data: null,
                    name: '',
                    className: 'text-center',
                    render: function(data) {

                        if (data.type == 1) {
                            return 'Girdi';
                        } else {
                            return 'Çıktı';
                        }
                    }
                },
                {
                    data: null,
                    name: '',
                    className: 'text-center',
                    render: function(data) {
                        return formatDate(data.date);
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
                            '<button type="button" class="btn mr-1 backbg_thirdly back_textColorV1"  onclick="showCalculate(' +
                            data.id +
                            ')"  data-toggle="tooltip" data-placement="top" title="Düzenle"><i class="fas fa-wrench"></i></button>';

                        html +=
                            '<a class="btn ml-1 backbg_fourthly back_textColorV1 hoverbg"  onclick="calculateDelete(' +
                            data.id +
                            ' )"   data-toggle="tooltip" data-placement="top" title="Sil"><i class="fas fa-trash-alt"></i></a>';
                        return html;

                    },
                    searchable: false,
                    orderable: false
                }
            ],
            "createdRow": function(row, data, index) {

                if (data.type == 0) {
                    $('td', row).css('background-color', '#ffcdd2');
                }
                if (data.type == 1) {
                    $('td', row).css('background-color', '#c8e6c9');
                }

            }
        });


        $.dataTableReload = function() {
            calculateDT.ajax.reload();
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



    });

    function showCalculate(id) {

        elem = $(this);
        $.get("{{ route('admin.calculate_edit') }}", {
                // _token: "{{ csrf_token() }}",
                calculate_id: id,
            },
            function(ret) {
                if (ret.status == true) {
                    var data = ret.data;
                    $('#showEdit-modal').empty();

                    var dynamicData =
                        `<form id="price-update-form" onsubmit="priceUpdate();return false">
                            <input type="hidden" name="calculate_id" value="` + data.id + `">
                            <div class="row p-3">
                                <div class="form-group col-md-8">
                                    <label for="price_money">Fiyat </label>
                                    <input id="price_money" value="` + data.price + `" type="number" class="form-control" name="price"
                                        required autofocus placeholder="Fiyat giriniz">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="type">Tipi</label>
                                    <div class="input-group">
                                        <select class="custom-select" name="type" id="inputGroupSelect02" required>
                                            <option value="1" ${data.type == 1 ? 'selected':''}>Girdi</option>
                                            <option value="0" ${data.type == 0 ? 'selected':''}>Çıktı</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="type">Tarih</label>
                                    <input type="date" class="form-control" value="${data.date }" name="date" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="price_desc">Açıklama </label>
                                    <input id="price_desc" type="text" class="form-control" name="desc" value="` + data
                        .desc + `"
                                        placeholder="Açıklama giriniz">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                            <button type="submit" class="btn backbg_primary back_textColor"><i
                                    class="fas fa-save mr-1"></i>Kaydet</button>
                        </div>
                        </form>`;

                    $('#showEdit-modal').append(dynamicData);
                    $('#priceEditModal').modal('show');

                } else {

                }
            }, "json");
    }



    function priceSave() {

        axios({
            method: 'post',
            url: '{{ route('admin.calculate_save') }}',
            data: $('#price-save-form').serialize()
        }).then(res => {
            if (res.data.status == 1) {
                $.dialog({
                    title: 'İşlem başarılı!',
                    content: 'Yeni fiyat eklendi',
                    type: 'green'
                });
                document.getElementById('price-save-form').reset();
                $.dataTableReload();
                $('#priceAddModal').modal('hide');
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



    function priceUpdate() {

        axios({
            method: 'post',
            url: '{{ route('admin.calculate_update') }}',
            data: $('#price-update-form').serialize()
        }).then(res => {
            if (res.data.status == 1) {
                $.dialog({
                    title: 'İşlem başarılı!',
                    content: 'Hesap güncellendi',
                    type: 'green'
                });
                $.dataTableReload();
                $('#priceEditModal').modal('hide');
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

    function calculateDelete(calculate_id) {
        $.confirm({
            title: 'Dikkat, Bu Hesap silenecek!',
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
                            url: '{{ route('admin.calculate.delete') }}',
                            data: {
                                calculate_id: calculate_id
                            }
                        }).then(res => {
                            if (res.data.status == 1) {
                                $.dialog({
                                    title: 'İşlem başarılı',
                                    content: 'Hesap silindi',
                                    type: 'green',
                                });
                                $.dataTableReload();
                            } else {
                                $.dialog({
                                    title: 'Hata',
                                    content: 'Hesap silinirken hata meydana geldi!',
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
