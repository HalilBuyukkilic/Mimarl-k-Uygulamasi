@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'Kullanıcılar')
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
                        <li class="breadcrumb-item active">Kullanıcılar</li>
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
        <div class="container-fluid content-info-skeleton">
            <div class="row">
                <div class="col-md-12">
                    <div class="card p-5 mt-3" style="background-color: white">


                        <table id="users" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: center">#</th>
                                    <th style="text-align: center">Ad Soyad</th>
                                    <th style="text-align: center">Email</th>
                                    <th style="text-align: center">Kayıt Tarihi</th>
                                    <th style="text-align: center">Role</th>
                                    <th style="text-align: center">Durum</th>
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


    <!--edit Modal -->
    <div class="modal fade" id="userEditModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Kullanıcı Detayi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="showEdit-modal">

                </div>
            </div>
        </div>
    </div>

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
        let usersDT = $("#users").DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.3/i18n/tr.json"
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "{{ url('admin/kullanicilar_veritablosu') }}",
                type: 'GET'
            },
            columns: [{
                    data: 'id',
                    className: 'text-center'
                },
                {
                    data: 'name',
                    className: 'text-center'
                },
                {
                    data: 'email',
                    className: 'text-center'
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
                    data: null,
                    name: '',
                    className: 'text-center',
                    render: function(data) {

                        if (data.role == 1) {
                            var html = 'Admin';
                        } else {
                            var html = 'Üye';
                        }
                        return html;
                    }
                },
                {
                    data: null,
                    name: '',
                    className: 'text-center',
                    render: function(data) {

                        if (data.status == 1) {
                            var html = 'Aktif';
                        } else {
                            var html = 'Pasif';
                        }
                        return html;
                    }
                },
                {
                    data: null,
                    name: '',
                    className: 'text-center',
                    render: function(data) {

                        var html = '';
                        if (data.role == 2) {
                            if (data.status == 1) {
                                html +=
                                    '<a class="btn mr-1 backbg_primary back_textColorV1"  onclick="checkedUser(' +
                                    0 + ',' + data
                                    .id +
                                    ' )"  data-toggle="tooltip" data-placement="top" title="üye pasif et"><i class="fas fa-undo"></i></a>';
                            } else {
                                html +=
                                    '<a class="btn mr-1 backbg_fourthly back_textColorV1"  onclick="checkedUser(' +
                                    1 + ',' + data
                                    .id +
                                    ' )"   data-toggle="tooltip" data-placement="top" title="üye aktif et"><i class="fas fa-thumbs-up"></i></a>';
                            }
                        }

                        html +=
                            '<a class="btn backbg_primary back_textColor user-edit" data-id=' +
                            data.id +
                            '  data-toggle="tooltip" data-placement="top" title="Görüntüle"><i class="far fa-eye back_textColorV1" ></i></a>';

                        html +=
                            '<a class="btn ml-1 backbg_fourthly back_textColorV1 hoverbg"  onclick="userDelete(' +
                            data.id +
                            ' )"   data-toggle="tooltip" data-placement="top" title="Sil"><i class="fas fa-trash-alt"></i></a>';
                        return html;
                    }
                }
            ],
            "createdRow": function(row, data, index) {
                if (data.status == 0) {
                    $('td', row).css('background-color', '#ffcdd2');
                }

                if (data.role == 1) {
                    $('td', row).css('background-color', '#d1c4e9 ');
                }
            }
        });


        $.dataTableReload = function() {
            usersDT.ajax.reload();
        }



        $('#users').on("click", 'a.user-edit', function() {
            var id = $(this).data('id');
            $.get("{{ route('admin.user_detail') }}", {
                    // _token: "{{ csrf_token() }}",
                    user_id: id,
                },
                function(ret) {
                    if (ret.status == true) {
                        var data = ret.data;
                        $('#showEdit-modal').empty();
                        var dynamicData =
                            `<div class="table-responsive-md p-2">
                                <table class="table table-bordered">
                                    <thead>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="50%"><b>Profil Resmi</b></td>
                                            <td width="50%"><img src="` + data.picture + `" alt="" height="50"></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><b>Adı Soyadı</b></td>
                                            <td width="50%">` + data.name + `</td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><b>Email</b></td>
                                            <td width="50%">` + data.email + `</td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><b>Rumuz</b></td>
                                            <td width="50%">` + data.username + `</td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><b>İban No</b></td>
                                            <td width="50%">` + data.iban_no + `</td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><b>TC No</b></td>
                                            <td width="50%">` + data.identity_no + `</td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><b>Vergi No</b></td>
                                            <td width="50%">` + data.tax_no + `</td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><b>Kayıt Tarihi</b></td>
                                            <td width="50%">` + formatDate(data.created_at) + `</td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><b>Rolu</b></td>
                                            <td width="50%">${data.role == 1 ? 'Admin' : 'Üye'} </td>
                                        </tr>
                                        <tr>
                                            <td width="50%"><b>Durum</b></td>
                                            <td width="50%">${data.status == 1 ? 'Aktif' : 'Pasif'}</td>
                                        </tr>
                                      
                                    </tbody>
                                </table>
                            </div>`;

                        if (data.role == 1) {
                            dynamicData += `<div class="modal-footer">
                               <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                           </div>`;
                        } else {
                            dynamicData += `<div class="modal-footer">
                               <button type="button" class="btn btn-warning"  onclick="permissionUser(` + data.id + `)" ><i class="fas fa-user-cog mr-1"></i>Yetki</button>
                               <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                           </div>`;
                        }

                        $('#showEdit-modal').append(dynamicData);
                        $('#userEditModal').modal('show');

                    } else {

                    }
                }, "json");
        });







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


    function checkedUser(status, user_id) {
        $.confirm({
            title: status ? 'Dikkat, Bu üye aktif olacak!' : 'Bu üye pasif yapılacak',
            content: 'Devam etmek istediğinizden emin misiniz?',
            type: 'orange',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Evet, Yap',
                    btnClass: 'btn-orange',
                    action: function() {
                        axios({
                            method: 'post',
                            url: '{{ route('admin.user_checked') }}',
                            data: {
                                user_id: user_id,
                                status: status,
                            }
                        }).then(res => {
                            if (res.data.status == 1) {
                                $.dialog({
                                    title: 'İşlem başarılı',
                                    content: res.data.reply ?
                                        'Üye aktif edildi' : 'Üye pasif edildi',
                                    type: 'green',
                                });
                                $.dataTableReload();
                            } else {
                                $.dialog({
                                    title: 'Hata',
                                    content: res.data.reply ?
                                        'Üye aktif yapılırken hata meydana geldi' :
                                        'Üye pasif yapılırken hata meydana geldi!',
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




    function permissionUser(user_id) {

        $.confirm({
            title: 'Dikkat, Bu üye`ye admin yetkisi atanacak ve bu geri döndürülemez!',
            content: 'Devam etmek istediğinizden emin misiniz?',
            type: 'orange',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Evet, Yap',
                    btnClass: 'btn-orange',
                    action: function() {
                        axios({
                            method: 'post',
                            url: '{{ route('admin.user_permission') }}',
                            data: {
                                user_id: user_id
                            }
                        }).then(res => {
                            if (res.data.status == 1) {
                                $.dialog({
                                    title: 'İşlem başarılı',
                                    content: 'Üye admin oldu',
                                    type: 'green',
                                });
                                $.dataTableReload();
                            } else {
                                $.dialog({
                                    title: 'Hata',
                                    content: 'Üye admin yapılırken hata meydana geldi!',
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


    function userDelete(user_id) {
        $.confirm({
            title: 'Dikkat, Bu Kullanıcı silenecek!',
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
                            url: '{{ route('admin.user_delete') }}',
                            data: {
                                user_id: user_id
                            }
                        }).then(res => {
                            if (res.data.status == 1) {
                                $.dialog({
                                    title: 'İşlem başarılı',
                                    content: 'Kullanıcı silindi',
                                    type: 'green',
                                });
                                $.dataTableReload();
                            } else {
                                $.dialog({
                                    title: 'Hata',
                                    content: 'Kullanıcı silinirken hata meydana geldi!',
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
