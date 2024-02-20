@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'Veri Tablosu')


<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css"
    href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap-extended.min.css">
<link rel="stylesheet" type="text/css"
    href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/fonts/simple-line-icons/style.min.css">
<link rel="stylesheet" type="text/css"
    href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/colors.min.css">
<link rel="stylesheet" type="text/css"
    href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">


@section('content')

    <section class="content-header">
        <div class="container-fluid content-header-skeleton">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                        <li class="breadcrumb-item active">Veri Tablosu</li>
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
        <div class="container-fluid content-info-skeleton" style="background-color: #f5f5f5">
            <div class="row">

                {{-- <div class="col-md-4">
                    <div style="border:1px solid gray;padding:10px;margin:30px;border-radius:10px">
                        <canvas id="bar-chart" style="max-height:400px;max-width:400px"></canvas>
                    </div>
                </div> --}}
                <div class="col-md-4">
                    <div style="border:1px solid gray;padding:10px;margin:30px;border-radius:10px; background-color:#fff">
                        <canvas id="line-chart" style="max-height:400px;max-width:400px"></canvas>
                    </div>
                </div>
                <div class="col-md-4">
                    <div style="border:1px solid gray;padding:10px;margin:30px;border-radius:10px;background-color:#fff">
                        <canvas id="bar-chart-grouped" style="max-height:400px;max-width:400px"></canvas>
                    </div>
                </div>
                <div class="col-md-4">
                    <div style="border:1px solid gray;padding:10px;margin:30px;border-radius:10px;background-color:#fff">
                        <canvas id="pie-chart" style="max-height:220px;max-width:300px"></canvas>
                    </div>
                </div>
            </div>

            <div class="grey-bg container-fluid">
                <section id="minimal-statistics">
                    <div class="row">
                        <div class="col-12 mt-3 mb-1">
                            <h4 class="text-uppercase">Modüllerin Istatıstıklerı</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="success">{{ $dataUser }}</h3>
                                                <span>Kullanıcılar</span>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="icon-user success font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="align-self-center">
                                                <i class="icon-pencil primary font-large-2 float-left"></i>
                                            </div>
                                            <div class="media-body text-right">
                                                <h3>{{ $dataWorkflow }}</h3>
                                                <span>İş Akışı</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="primary">{{ $dataNews }}</h3>
                                                <span>Haberler</span>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="icon-book-open primary font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="align-self-center">
                                                <i class="icon-speech warning font-large-2 float-left"></i>
                                            </div>
                                            <div class="media-body text-right">
                                                <h3>{{ $dataTopics }}</h3>
                                                <span>Konular</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="primary">{{ $dataEvents }}</h3>
                                                <span>Etkinlik</span>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="icon-support primary font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="danger">{{ $dataCompetition }}</h3>
                                                <span>Yarışmalar</span>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="icon-rocket danger font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="align-self-center">
                                                <i class="icon-graph success font-large-2 float-left"></i>
                                            </div>
                                            <div class="media-body text-right">
                                                <h3>{{ $dataReceipts }}</h3>
                                                <span>Dekontlar</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        {{-- <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="warning">156</h3>
                                                <span>New Comments</span>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="icon-bubbles warning font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                        <div class="progress mt-1 mb-0" style="height: 7px;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 35%"
                                                aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="success">64</h3>
                                                <span>Dekontlar</span>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="icon-cup success font-large-2 float-right"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h3 class="warning">64.89 %</h3>
                                                <span>Conversion Rate</span>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="icon-pie-chart warning font-large-2 float-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                    </div>
                </section>

            </div>



        </div>
    </section>



@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>


<script>
    $(document).ready(function() {
        $.noConflict();
        // new Chart(document.getElementById("bar-chart"), {
        //     type: 'bar',
        //     data: {
        //         labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
        //         datasets: [{
        //             label: "Population (millions)",
        //             backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
        //             data: [2478, 5267, 734, 784, 433]
        //         }]
        //     },
        //     options: {
        //         legend: {
        //             display: false
        //         },
        //         title: {
        //             display: true,
        //             text: 'Predicted world population (millions) in 2050'
        //         }
        //     }
        // });






        axios({
            method: 'get',
            url: '{{ route('admin.get_statics') }}',
        }).then(res => {
            console.log(res.data.minusArrays);
            // console.log(res.data.dataResult);
            new Chart(document.getElementById("pie-chart"), {
                type: 'pie',
                data: {
                    labels: ["Giren Para", "Çıkan Para"],
                    datasets: [{
                        label: "Toplam para",
                        backgroundColor: ["#3e95cd", "#8e5ea2"],
                        data: [res.data.dataPlus, res.data.dataMinus]
                    }]
                },
                options: {
                    title: {
                        display: false,
                        text: 'Çıkan toplam para'
                    }
                }
            });

            new Chart(document.getElementById("bar-chart-grouped"), {
                type: 'bar',
                data: {
                    labels: ["-", "-", "-", "-", "-"],
                    datasets: [{
                        label: "Giren Para",
                        backgroundColor: "#3e95cd",
                        data: res.data.plusArray
                    }, {
                        label: "Çıkan Para",
                        backgroundColor: "#8e5ea2",
                        data: res.data.minusArray
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Population growth (millions)'
                    }
                }
            });

            new Chart(document.getElementById("line-chart"), {
                type: 'line',
                data: {
                    labels: ["-", "-", "-", "-", "-"],
                    datasets: [{
                        data: res.data.plusArray,
                        label: "Giren Para",
                        borderColor: "#3e95cd",
                        fill: false
                    }, {
                        data: res.data.minusArray,
                        label: "Çıkan Para",
                        borderColor: "#8e5ea2",
                        fill: false
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'World population per region (in millions)'
                    }
                }
            });
        }).catch(err => {

        })

    });
</script>
