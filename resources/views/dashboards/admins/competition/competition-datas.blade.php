@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'Yarışma Katılım')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<style>
    .rating {
        display: flex;
        flex-direction: row-reverse;
        width: 320px;
        padding-bottom: 1rem;
    }

    .rating>input {
        flex: 1 1 0%;
        display: grid;
        place-content: center;
        cursor: pointer;
    }

    .rating>input::before {
        content: '⭐';
        filter: grayscale(100%) contrast(200%);
        font-size: 200%;
    }

    .rating>input:checked::before,
    .rating>input:checked~input::before {
        filter: unset;
    }
</style>
@section('content')

    <section class="content-header">
        <div class="container-fluid content-header-skeleton">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                        <li class="breadcrumb-item">Yarışmalar</li>
                        <li class="breadcrumb-item">Yarışma Katılım</li>
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
                                <i class="fas fa-shapes mr-1"></i> <b
                                    style="text-transform: uppercase">{{ $competition->title }}</b> Yarışma Katılım Listesi
                            </span>
                            <span>
                                <a onclick="return_back();return false;"
                                    class="backbg_secondary back_textColor  mr-1  content-newform-right-buttons">
                                    <i class="fas fa-reply"></i> Geri
                                </a>
                            </span>
                        </div>
                        <hr style="border:5px solid black;margin-top:-20px">
                        <table id="competition_datas" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: center">#</th>
                                    <th style="text-align: center">Açıklama</th>
                                    <th style="text-align: center">Tarih</th>
                                    <th style="text-align: center">Puan</th>
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
    <!-- Modal -->
    <div class="modal fade" id="showCompetitionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yarışma Katılım Detayı</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="showcompetition-datas">

                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="ratingStarCompetitionModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yarışmacıyı Puanla</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="ratingcompetition-datas">

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
        let competitionDatasDT = $("#competition_datas").DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.3/i18n/tr.json"
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "{{ url('admin/yarisma_katilim_veritablosu') }}?competition_datas_id={{ $competition->id }}",
                type: 'GET'
            },
            columns: [{
                    data: 'id',
                    className: 'text-center'
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
                        return formatDate(data.created_at);
                    }
                },
                {
                    data: 'point',
                    className: 'text-center'
                },
                {
                    data: null,
                    name: '',
                    className: 'text-center',
                    render: function(data) {
                        var html = '';

                        html +=
                            '<a class="btn mr-1 backbg_primary  back_textColor" onclick="showCompetitionDatas(' +
                            data.id +
                            ')"  data-toggle="tooltip" data-placement="top" title="Görüntüle"><i class="far fa-eye back_textColorV1"></i></a>';

                        html +=
                            '<a class="btn mr-1 backbg_primary  back_textColor" onclick="ratingCompetitionDatas(' +
                            data.id +
                            ')"  data-toggle="tooltip" data-placement="top" title="Görüntüle"><i class="far fa-hand-pointer"></i></a>';
                        return html;

                    },
                    searchable: false,
                    orderable: false
                }
            ]
        });


        $.dataTableReload = function() {
            competitionDatasDT.ajax.reload();
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


        $("#competition_datas").on("click", 'a.restored-competition', function() {

            var competition_id = $(this).data('id');

            $.ajax({
                url: "{{ route('admin.competition_restored') }}",
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: {
                    competition_id: competition_id
                },
                success: function(response) {
                    if (response.status == 1) {
                        $.dataTableReload();
                    }
                }
            });

        });

    });



    function showCompetitionDatas(competitiondatas_id) {

        $.get("{{ route('admin.competition_datas_details.show') }}", {
                competition_datas_id: competitiondatas_id,
            },
            function(ret) {
                if (ret.status == true) {
                    var data = ret.data;
                    $('#showcompetition-datas').empty();
                    $('#imageUsers').empty();


                    var dynamicData =
                        `<div class="modal-body">
                                <div class="form-group" id="imageUsers">
                                
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                                <button type="button" class="btn btn-warning" onclick="ratingCompetitionDatas(` +
                        competitiondatas_id + `)" ><i class="fas fa-star mr-1" style="color:white"></i> Oyla</button>
                            </div>`;


                    setTimeout(() => {
                        var tablebody = '';

                        if (typeof data.media_user !== "undefined") {
                            data.media_user.forEach(element => {
                                if (element.media_type == 'image') {
                                    tablebody +=
                                        `<img class="ml-2" src="{{ asset('storage/yarisma_katilim/') }}/${element.file_name}" alt="" width="350" height="250">`;
                                }
                            })
                            tablebody +=
                                `<div class="row p-2 m-2"><div class="d-flex justify-content-center" style="font-size:15px"><b class="mr-1">ADI SOYADI : </b>${data.user_data.name}</div>`;
                            tablebody +=
                                `<div class="d-flex justify-content-center" style="font-size:15px"><b class="mr-1">EMAİL     : </b>${data.user_data.email}</div>`;
                            tablebody +=
                                `<div class="d-flex justify-content-center" style="font-size:15px"><b class="mr-1">TELEFON   : </b> ${data.user_data.phone}</div></div>`;
                        } else {
                            data.media_contestant.forEach(element => {
                                if (element.media_type == 'image') {
                                    tablebody +=
                                        `<img class="ml-2" src="{{ asset('storage/yarisma_katilim/') }}/${element.file_name}" alt="" width="350" height="250">`;
                                }
                            })
                            tablebody +=
                                `<div class="row  p-2 m-2"><div class="d-flex justify-content-center" style="font-size:15px"><b class="mr-1">ADI SOYADI : </b>${data.contestant_data.name}</div>`;
                            tablebody +=
                                `<div class="d-flex justify-content-center" style="font-size:15px"><b class="mr-1">EMAİL     : </b>${data.contestant_data.email}</div>`;
                            tablebody +=
                                `<div class="d-flex justify-content-center" style="font-size:15px"><b class="mr-1">TELEFON   : </b> ${data.contestant_data.phone}</div></div>`;
                        }



                        $('#imageUsers').append(tablebody);
                    }, 10);
                    $('#showcompetition-datas').append(dynamicData);
                    $('#showCompetitionModal').modal('show');

                } else {

                }
            }, "json");
    };


    function ratingCompetitionDatas(competitiondatas_id) {

        $.get("{{ route('admin.competition_datas_details.show') }}", {
                competition_datas_id: competitiondatas_id
            },
            function(ret) {
                if (ret.status == true) {
                    var data = ret.data;
                    $('#ratingcompetition-datas').empty();

                    var user_name = '';
                    if (data.user_id != 0) {
                        user_name = data['user_data'].name;
                    } else {
                        user_name = data['contestant_data'].name;
                    }
                    var dynamicData =
                        `<div class="d-flex justify-content-center mt-2"> <h5 style="border:1px solid #ddd;padding:5px;border-radius:5px"> ${user_name}</h5></div>
                        <form id="competition-change-point" onsubmit="ratingChangePoint();return false">
                            <input type="hidden" name="competition_datas_id" value="` + competitiondatas_id + `">
                                <div class="modal-body d-flex justify-content-center">
                                    <fieldset class="rating">
                                        <input type="radio" name="rating" title="star5" value="5" ${ data.point == 5 ? 'checked' : '' }
                                         />
                                        <input type="radio" name="rating" title="star4" value="4" ${ data.point == 4 ? 'checked' : '' }
                                         />
                                        <input type="radio" name="rating" title="star3" value="3" ${ data.point == 3 ? 'checked' : '' }
                                        />
                                        <input type="radio" name="rating" title="star2" value="2" ${ data.point == 2 ? 'checked' : '' }
                                        />
                                        <input type="radio" name="rating" title="star1" value="1" ${ data.point == 1 ? 'checked' : '' }
                                         />
                                    </fieldset>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                                    <button type="submit" class="btn btn-success" >Oyla</button>
                                </div>
                            </form>`;
                    $('#ratingcompetition-datas').append(dynamicData);
                    $('#ratingStarCompetitionModal').modal('show');

                } else {

                }
            }, "json");


    };


    function ratingChangePoint() {
        axios({
            method: 'post',
            url: '{{ route('admin.competition_datas_point') }}',
            data: $('#competition-change-point').serialize()
        }).then(res => {
            $.confirm({
                title: res.data.status == 1 ? 'Tebrikler' : 'Hata !',
                content: res.data.status == 1 ? 'Yarışmacı oylandı' :
                    'Yarışmacı oylanırken bir hata meydana geldi',
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
            $('#ratingStarCompetitionModal').modal('hide');
            $.dataTableReload();
        }).catch(err => {

        })
    }


    function return_back() {
        window.history.back();
    };
</script>
