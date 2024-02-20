@extends('dashboards.users.layouts.user-dash-layout')
@section('title', 'Konular')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

@section('content')

    <section class="content-header">
        <div class="container-fluid content-header-skeleton">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                        <li class="breadcrumb-item active">Konular</li>
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
                                <i class="fas fa-clipboard-list mr-1"></i> Konular Listesi
                            </span>
                            <span>
                                <div class="btn-group dropleft" style="margin-top: 5px">
                                    <a type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('user.deleted.topics') }}"
                                            class="ml-1 back_textColor backbg_fourthly p-1">
                                            <i class="far fa-eye-slash"></i> Silinen Konular
                                        </a>
                                    </div>
                                </div>

                                <a href="{{ route('user.topic_create') }}"
                                    class="backbg_primary back_textColor content-datatable-create-button">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                            </span>
                        </div>
                        <hr style="border:5px solid black;margin-top:-20px">
                        <table id="topics" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: center">#</th>
                                    <th style="text-align: center">Başlık</th>
                                    <th style="text-align: center">Özet</th>
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

<script>
    $(document).ready(function() {
        $.noConflict();
        let topicsDT = $("#topics").DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.3/i18n/tr.json"
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "{{ url('uye/konular_veritablosu') }}",
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
                    data: null,
                    name: '',
                    className: 'text-center',
                    render: function(data) {
                        if (data.summary != null) {
                            return data.summary.length > 40 ?
                                '<span>' + data.summary.substr(0, 38) +
                                '...</span>' :
                                data.summary;
                        } else {
                            return '';
                        }
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
                    data: null,
                    name: '',
                    className: 'text-center',
                    render: function(data) {

                        var html = '';

                        if (data.status == 1) {
                            html +=
                                '<span class="badge_pill color_badge_success">Aktif</span> <br>';
                        } else {
                            html +=
                                '<span class="badge_pill color_badge_fail">Pasif</span> <br>';
                        }
                        return html;
                    }
                },
                {
                    data: null,
                    name: '',
                    className: 'text-center',
                    render: function(data) {
                        var url = '{{ route('user.topic_edit', ':id') }}';
                        url = url.replace(':id', data.id);
                        var html = '';

                        html +=
                            '<a class="btn mr-1 backbg_thirdly back_textColorV1" href="' + url +
                            '"  data-toggle="tooltip" data-placement="top" title="Düzenle"><i class="fas fa-wrench"></i></a>';
                        html +=
                            '<a class="btn backbg_primary back_textColor"    data-toggle="tooltip" data-placement="top" title="Görüntüle"><i class="fas fa-desktop"></i></a>';

                        return html;

                    },
                    searchable: false,
                    orderable: false
                }
            ]
        });


        $.dataTableReload = function() {
            topicsDT.ajax.reload();
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
</script>
