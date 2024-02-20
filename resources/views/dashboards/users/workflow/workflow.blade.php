@extends('dashboards.users.layouts.user-dash-layout')
@section('title', 'İş Akışı')
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
                        <li class="breadcrumb-item active">İş Akışı</li>
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
                                <i class="fas fa-paste mr-1"></i> İş Akışı Listesi
                            </span>
                            <span>
                                {{-- <div class="btn-group dropleft" style="margin-top: 5px">
                                    <a type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('user.deleted.workflow') }}"
                                            class="ml-1 back_textColor backbg_fourthly p-1">
                                            <i class="far fa-eye-slash"></i> Silinen İş Akışı
                                        </a>
                                    </div>
                                </div> --}}

                                <a href="{{ route('user.workflow_create') }}"
                                    class="backbg_primary back_textColor content-datatable-create-button">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                            </span>
                        </div>
                        <hr style="border:5px solid black;margin-top:-20px">
                        <table id="workflow" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: center">#</th>
                                    <th style="text-align: center">Başlık</th>
                                    <th style="text-align: center">Müteahhit</th>
                                    <th style="text-align: center">Tarih</th>
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
    <section style="height: 100px">
    </section>
@endsection
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script>
    $(document).ready(function() {
        $.noConflict();
        let workflowDT = $("#workflow").DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.3/i18n/tr.json"
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "{{ url('uye/is_akisi_veritablosu') }}",
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
                        if (data.title != null) {
                            return data.title.length > 40 ?
                                '<span>' + data.title.substr(0, 38) +
                                '...</span>' :
                                data.title;
                        } else {
                            return '';
                        }
                    }
                },
                {
                    data: 'contractor_name',
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

                        var html = '';

                        if (data.send == 1) {
                            html +=
                                '<span class="badge_pill color_badge_success">Gönderildi</span> <br>';
                        } else {
                            html +=
                                '<span class="badge_pill color_badge_fail">Gönderilmedi</span> <br>';
                        }
                        return html;
                    }
                },
                {
                    data: null,
                    name: '',
                    className: 'text-center',
                    render: function(data) {
                        var url = '{{ route('user.workflow_edit', ':id') }}';
                        url = url.replace(':id', data.id);


                        var html = '';

                        html +=
                            '<a class="btn mr-1 backbg_thirdly back_textColorV1" href="' + url +
                            '"  data-toggle="tooltip" data-placement="top" title="Düzenle"><i class="fas fa-wrench"></i></a>';
                        if (data.okay == 1) {
                            var okayUrl = data.media.filter(res => res.author != data.author)[
                                0];
                            html +=
                                `<a class="btn ml-1 backbg_secondary back_textColor" href ="{{ asset('/storage/' . '`+ okayUrl.modul_type+`/`+ okayUrl.file_name +`') }}"  data-toggle="tooltip" data-placement="top" title="Görüntüle"><i class="fas fa-desktop"></i></a>`;
                        } else {
                            if (data.okay == 0) {
                                if (data.send == 1) {
                                    html +=
                                        '<a class="btn ml-1  backbg_primary back_textColorV1 " onclick="workflowSend(' +
                                        0 + ',' +
                                        data.id +
                                        ' )"  data-toggle="tooltip" data-placement="top" title="Geri al"><i class="fas fa-undo"></i></a>';
                                } else {
                                    html +=
                                        '<a class="btn ml-1  backbg_fourthly back_textColorV1 " onclick="workflowSend(' +
                                        1 + ',' + data
                                        .id +
                                        ' )"  data-toggle="tooltip" data-placement="top" title="Gönder"><i class="fas fa-paper-plane"></i></a>';
                                }
                            }

                        }

                        html +=
                            '<a class="btn ml-1 backbg_fourthly back_textColorV1 hoverbg"  onclick="workflowDelete(' +
                            data.id +
                            ' )"   data-toggle="tooltip" data-placement="top" title="Sil"><i class="fas fa-trash-alt"></i></a>';

                        return html;

                    },
                    searchable: false,
                    orderable: false
                }
            ],
            "createdRow": function(row, data, index) {

                if (data.send == 1) {
                    $('td', row).css('background-color', '#fff176');
                }
                if (data.okay == 1) {
                    $('td', row).css('background-color', '#a5d6a7');
                }
                if (data.okay == 2) {
                    $('td', row).css('background-color', '#ffcdd2');
                }

            }
        });


        $.dataTableReload = function() {
            workflowDT.ajax.reload();
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



    function workflowSend(status, workflow_id) {
        $.confirm({
            title: status ? 'Dikkat, Bu iş akışı gönderilecek!' : 'İş akışı geri alınacak',
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
                            url: '{{ route('user.workflow_send') }}',
                            data: {
                                workflow_id: workflow_id,
                                status: status,
                            }
                        }).then(res => {
                            if (res.data.status == 1) {
                                $.dialog({
                                    title: 'İşlem başarılı',
                                    content: res.data.reply ?
                                        'İş akışı yöneticeye gönderildi' :
                                        'İş akışı geri alındı',
                                    type: 'green',
                                });
                                $.dataTableReload();
                                notification();
                            } else {
                                $.dialog({
                                    title: 'Hata',
                                    content: res.data.reply ?
                                        'İş akışı geri alınırken hata meydana geldi' :
                                        'İş akışı gönderilirken hata meydana geldi!',
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


    function workflowDelete(workflow_id) {
        $.confirm({
            title: 'Dikkat, Bu İş akışı silenecek!',
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
                            url: '{{ route('user.workflow.delete') }}',
                            data: {
                                workflow_id: workflow_id
                            }
                        }).then(res => {
                            if (res.data.status == 1) {
                                $.dialog({
                                    title: 'İşlem başarılı',
                                    content: 'İş akışı silindi',
                                    type: 'green',
                                });
                                $.dataTableReload();
                            } else {
                                $.dialog({
                                    title: 'Hata',
                                    content: 'İş akışı silinirken hata meydana geldi!',
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
            url: '{{ route('user.is_akisi_add_notification') }}',
        }).then(res => {}).catch(err => {

        });
    }
</script>
