@extends('dashboards.users.layouts.user-dash-layout')
@section('title', 'Profil')


@section('content')


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid content-header-skeleton">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                        <li class="breadcrumb-item active">Kullanıcı Profili</li>
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

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle user_picture"
                                    src="{{ Auth::user()->picture }}" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center user_name">{{ Auth::user()->name }}</h3>

                            <p class="text-muted text-center">Üye</p>

                            <input type="file" name="user_image" id="user_image"
                                style="opacity: 0;height:1px;display:none">
                            <a href="javascript:void(0)" class="btn btn-primary btn-block" id="change_picture_btn"><b>Resmi
                                    Değiştir</b></a>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->


                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#personal_info" data-toggle="tab">Üye
                                        Bilgi</a></li>
                                <li class="nav-item"><a class="nav-link" href="#change_password" data-toggle="tab">Şifre
                                        Değiştir</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="personal_info">
                                    <form class="form-horizontal" method="POST" action="{{ route('userUpdateInfo') }}"
                                        id="UserInfoForm">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">İsim Soyisim</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputName" placeholder="Name"
                                                    required value="{{ Auth::user()->name }}" name="name">

                                                <span class="text-danger error-text name_error"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputEmail"
                                                    placeholder="Email" value="{{ Auth::user()->email }}" name="email"
                                                    required>
                                                <span class="text-danger error-text email_error"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="username" class="col-sm-2 col-form-label">Rumuz</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="username" minlength="4"
                                                    maxlength="12" placeholder="Rumuz giriniz"
                                                    value="{{ Auth::user()->username }}" required name="username">
                                                <span class="text-danger error-text username_error"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tc_no" class="col-sm-2 col-form-label">TC No</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="tc_no" minlength="11"
                                                    maxlength="11" placeholder="Tc no giriniz"
                                                    value="{{ Auth::user()->identity_no }}" required name="identity_no">
                                                <span class="text-danger error-text identity_no_error"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="iban" class="col-sm-2 col-form-label">İban No </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="iban"
                                                    placeholder="İban giriniz" value="{{ Auth::user()->iban_no }}"
                                                    required name="iban_no">
                                                <span class="text-danger error-text iban_no_error"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tax_no" class="col-sm-2 col-form-label">Vergi No</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="tax_no"
                                                    placeholder="Vergi no giriniz" value="{{ Auth::user()->tax_no }}"
                                                    required name="tax_no">
                                                <span class="text-danger error-text tax_no_error"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Değişiklikleri
                                                    Kaydet</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="change_password">
                                    <form class="form-horizontal" action="{{ route('userChangePassword') }}"
                                        method="POST" id="changePasswordUserForm">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Eski Şifre</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="inputName"
                                                    placeholder="Geçerli şifrenizi giriniz" name="oldpassword">
                                                <span class="text-danger error-text oldpassword_error"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputName2" class="col-sm-2 col-form-label">Yeni Şifre</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="newpassword"
                                                    placeholder="Yeni şifrenizi giriniz" name="newpassword">
                                                <span class="text-danger error-text newpassword_error"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputName2" class="col-sm-2 col-form-label">Yeni Şifre
                                                Tekrar</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="cnewpassword"
                                                    placeholder="Yeni şifrenizi tekrar giriniz" name="cnewpassword">
                                                <span class="text-danger error-text cnewpassword_error"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Şifre Güncelle</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('plugins/ijaboCropTool/ijaboCropTool.min.js') }}"></script>
    <script src="{{ asset('js/jquery.mask.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.noConflict();
            $('#iban').mask('AA00 0000 0000 0000 0000 0000 00');
            $('#tc_no').mask('00000000000');
            $('#tax_no').mask('0##############', {
                translation: {
                    '#': {
                        pattern: /[0-9]/
                    }
                }
            });
        });
    </script>

@endsection
