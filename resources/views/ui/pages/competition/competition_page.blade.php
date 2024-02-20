@extends('layouts.app')
@section('title', 'Mimarlar A.Ş | Yarışma')
@section('meta_keys', isset($competition_page->meta_keys) ? $competition_page->meta_keys : '')
@section('meta_desc', isset($competition_page->meta_desc) ? $competition_page->meta_desc : '')
@section('modul_css')
    <link rel="stylesheet" href="{{ asset('css/ui/news/news_page.css') }}">
@endsection
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
<style>
    .imageText {
        font-weight: 500;
    }

    .imageText .editimageText {
        display: block;
    }

    .hoverable,
    .hoverables {
        cursor: pointer;
    }

    #imgInp {
        display: none;
    }

    #imgInp1 {
        display: none;
    }

    #imgInp2 {
        display: none;
    }
</style>
@section('content')
    @php
        $active_competition_page = \App\Models\Competition::where('status', 1)->exists();
    @endphp
    @if ($active_competition_page)
        <div style="margin-top: 60px;min-height:751px;background-color: #ececec;padding:20px;">
            <div class="container mt-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb newspage-card-section">
                        <li class="breadcrumb-item"><a class="remove_underline" href="/">Anasayfa</a></li>
                        <li class="breadcrumb-item"><a class="remove_underline">Yarışma</a></li>
                    </ol>
                </nav>
                @php
                    $email = session('contestant_email');
                    $query_contestant = \App\Models\Contestant::where('email', $email)
                        ->where('status', 1)
                        ->first();
                    if (isset($query_contestant)) {
                        $contestant = $query_contestant;
                    } else {
                        $contestant['id'] = 0;
                    }

                    if (isset(Auth::user()->id)) {
                        $query_competition = \App\Models\CompetitionDatas::where('competition_id', $competition_page->id)
                            ->where('user_id', Auth::user()->id)
                            ->first();

                        $query_member = \App\Models\User::find(Auth::user()->id);

                        if (isset($query_competition)) {
                            $active_competition = $query_competition;
                        } else {
                            $active_competition['id'] = 0;
                        }

                        if ($query_member->status == 1) {
                            $active_user = $query_member;
                        } else {
                            $active_user['status'] = 0;
                        }
                    } else {
                        $active_competition['id'] = 0;
                        $active_user['status'] = 0;
                    }

                @endphp



                <div class="row">
                    <div class="col-md-12 p-3">
                        <div class="card p-2" style="border-radius: 10px">
                            @if (is_countable($competition_page->media) && count($competition_page->media) > 0)
                                @foreach ($competition_page->media as $media)
                                    @if ($media->media_type == 'image')
                                        <div class="d-flex justify-content-center mb-3">
                                            <img class="d-block w-100"
                                                src="{{ asset('/storage/yarisma/' . $media->file_name) }}" alt="First slide"
                                                height="520px">
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            <div class="d-flex justify-content-center mb-3">
                                <h5 style="border-bottom:2px solid gray;padding:5px">{{ $competition_page->title }}</h5>
                            </div>
                            <span style="padding:5px;margin-left:10px">
                                <div class="row">
                                    <div class="col-md-3">
                                        <i class="fas fa-calendar-day" style="font-size: 18px"></i>
                                        <b>Başlangıç:</b> <br>
                                        <span
                                            style="padding:4px;color:black;background-color:#eceff1;font-weight:bold;border-bottom:2px solid yellow ">{{ date('d-m-Y h:m:s', strtotime($competition_page->start_date)) }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <i class="fas fa-calendar-day" style="font-size: 18px"></i>
                                        <b>Bitiş:</b> <br>
                                        <span
                                            style="padding:4px;color:black;background-color:#eceff1;font-weight:bold;border-bottom:2px solid yellow ">{{ date('d-m-Y h:m:s', strtotime($competition_page->end_date)) }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        @if (is_countable($competition_page->media) && count($competition_page->media) > 0)
                                            <div class="col-md-12 d-flex justify-content-center">

                                                @foreach ($competition_page->media as $media)
                                                    @if ($media->media_type == 'doc')
                                                        <div style="background-color:#ddd; padding:10px">
                                                            <a href="{{ asset('/storage/yarisma') . '/' . $media->file_name }}"
                                                                style="height: 50px;width:70px;margin:10px" alt="">
                                                                @if (explode('.', $media->file_name)[1] == 'pdf')
                                                                    <i class="fas fa-file-pdf"
                                                                        style="font-size:50px;color:red"></i>
                                                                @else
                                                                    @if (explode('.', $media->file_name)[1] == 'xlsx')
                                                                        <i class="fas fa-file-excel"
                                                                            style="font-size:50px;color:green"></i>
                                                                    @else
                                                                        @if (explode('.', $media->file_name)[1] == 'doc' || explode('.', $media->file_name)[1] == 'docx')
                                                                            <i class="fas fa-file-word"
                                                                                style="font-size:50px"></i>
                                                                        @else
                                                                            @if (explode('.', $media->file_name)[1] == 'txt')
                                                                                <i class="fas fa-file-alt"
                                                                                    style="font-size:50px;color:#80deea"></i>
                                                                            @else
                                                                                <i class="fas fa-file-archive"
                                                                                    style="font-size:50px;color:#ffd180"></i>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            </a>
                                                            <b class="mr-2">Yarışma Kuralları</b>
                                                        </div>
                                                    @endif
                                                @endforeach

                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </span>

                            <br>

                            <div class="p-3">
                                <b>Yarışma Detayı</b>
                                <p>
                                    {!! isset($competition_page->content)
                                        ? $competition_page->content
                                        : '<div class="alert alert-warning" role="alert">İçerik girilmedi! </div>' !!}
                                </p>
                            </div>

                            <div class="row d-flex justify-content-center">
                                @if ($contestant['id'] != 0 || $active_user['status'] == 1)
                                    @if ($active_competition['id'] != 0)
                                        <button class="btn  mr-1" style="background-color: green;color:white">Katıldınız
                                            için
                                            teşekkür ederiz <i class="far fa-thumbs-up"></i></button>
                                    @else
                                        <button class="btn  mr-1" style="background-color: tomato;color:white"
                                            data-toggle="modal" data-target="#competitionModal">Katıl<i
                                                class="fas fa-sign-in-alt ml-1"></i></button>
                                    @endif
                                @else
                                    <button class="btn  mr-1" style="background-color: #e6191a;color:white"
                                        data-toggle="modal" data-target="#competitionContestantModal">Üyeliksiz Katıl <i
                                            class="fas fa-user-plus"></i></button>
                                    <button class="btn " style="background-color: #e6191a;color:white" data-toggle="modal"
                                        data-target="#competitionMemberModal">Üye olarak Katıl <i
                                            class="fas fa-user-tie"></i></button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--edit Modal -->
        <div class="modal fade" id="competitionModal" tabindex="-1" role="dialog" aria-labelledby="contestantModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="contestantModalLabel">Yarışma</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span>
                        </button>
                    </div>
                    <form id="competition-save-form" onsubmit="competitionSave();return false">
                        <div class="modal-body">
                            <input type="hidden" name="competition_id" value="{{ $competition_page->id }}">
                            <input type="hidden" name="contestant_id"
                                value="{{ $contestant['id'] == 0 ? 0 : $contestant->id }}">
                            <div class="row">
                                <div class="col-md-4 pl-5">
                                    <div class="form-group">
                                        <label class="hoverable">
                                            <div class="imageText">Yarışma Resmi <span style="color:red">*</span></div>
                                            <input type='file' name="images[]" id="imgInp" required
                                                accept="image/png, image/jpeg, image/jpg,image/webp" />
                                            <img id="newsimg" src="{{ URL::asset('/img/default/default-image.jpg') }}"
                                                style="height: 150px;width:200px" />
                                            <b style="font-size: 12px;color:orange">Dikkat: Zorunlu !</b>
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
                                @if ($competition_page->countImage == 2 || $competition_page->countImage == 3)
                                    <div class="col-md-4 pl-4">
                                        <div class="form-group">
                                            <label class="hoverable">
                                                <div class="imageText">Yarışma Resmi 2</div>
                                                <input type='file' name="images[]" id="imgInp1"
                                                    accept="image/png, image/jpeg, image/jpg,image/webp" />
                                                <img id="newsimg1"
                                                    src="{{ URL::asset('/img/default/default-image.jpg') }}"
                                                    style="height: 150px;width:200px" />
                                            </label>
                                            <script>
                                                imgInp1.onchange = evt => {
                                                    const [file] = imgInp1.files
                                                    if (file) {
                                                        newsimg1.src = URL.createObjectURL(file)
                                                    }
                                                }
                                            </script>
                                        </div>
                                    </div>
                                @endif

                                @if ($competition_page->countImage == 3)
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label class="hoverable">
                                                <div class="imageText">Yarışma Resmi 2</div>
                                                <input type='file' name="images[]" id="imgInp2"
                                                    accept="image/png, image/jpeg, image/jpg,image/webp" />
                                                <img id="newsimg2"
                                                    src="{{ URL::asset('/img/default/default-image.jpg') }}"
                                                    style="height: 150px;width:200px" />
                                            </label>
                                            <script>
                                                imgInp2.onchange = evt => {
                                                    const [file] = imgInp2.files
                                                    if (file) {
                                                        newsimg2.src = URL.createObjectURL(file)
                                                    }
                                                }
                                            </script>
                                        </div>
                                    </div>
                                @endif

                            </div>
                            <div class="p-3">
                                <div class="form-group col-md-12 mt-3">
                                    <label for="desc">Açıklama </label>
                                    <input id="desc" type="text" class="form-control" name="desc" autofocus
                                        placeholder="Açıklama giriniz">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                            <button type="submit" class="btn" style="background-color: #25b631;color:#fff;"><i
                                    class="fas fa-rocket mr-1"></i>Katıl</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="competitionContestantModal" tabindex="-1" role="dialog"
            aria-labelledby="contestantModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="contestantModalLabel">Üyeliksiz Katılım</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span>
                        </button>
                    </div>
                    <form id="contestant-save-form" onsubmit="contestantSave();return false">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Ad Soyad </label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="far fa-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control" name="name" required autofocus
                                        placeholder="Ad Soyad giriniz ">

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="email">Email</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="far fa-envelope"></i></div>
                                    </div>
                                    <input type="email" class="form-control" name="email" required autofocus
                                        placeholder="Email giriniz">

                                </div>
                            </div>
                            <div class="form-group">
                                <label>Telefon</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" id="phone_user" name="phone" required
                                        autofocus placeholder="Telefon giriniz">

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                            <button type="submit" class="btn btn-success"><i
                                    class="fas fa-save mr-1"></i>Kaydet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="competitionMemberModal" tabindex="-1" role="dialog"
            aria-labelledby="memberModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="memberModalLabel">Üye olarak katıl</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span>
                        </button>
                    </div>
                    <form method="POST" class="my-login-validation" autocomplete="off" id="login-form"
                        onsubmit="login();return false">
                        @csrf
                        <div class="p-3">
                            <input type="hidden" name="modal" value="1">
                            <div class="form-group">
                                <label class="email">Email</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="far fa-envelope"></i></div>
                                    </div>
                                    <input id="email" type="email" class="form-control" name="email"
                                        value="" required autofocus placeholder="Email giriniz">
                                    <span class="text-danger">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Şifre</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                    </div>
                                    <input id="password" type="password" class="form-control" name="password" required
                                        data-eye placeholder="şifre giriniz">
                                    <span class="text-danger">
                                        @error('password')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="form-group m-0">
                                <button type="submit" class="btn btn-warning btn-block" style="color:white">
                                    Giriş Yap
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <section style="margin-top: 100px">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-center">
                        <div class="alert alert-warning" role="alert">
                            Henüz yarışma başlamadı!
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

@endsection


<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<script src=" {{ asset('js/jquery.mask.js') }}"></script>
<script>
    $(document).ready(function() {
        $.noConflict();
        $('#phone_user').mask('0(000) 000 00 00');
    });

    function contestantSave() {
        axios({
            method: 'post',
            url: '{{ route('ui.contestant_save') }}',
            data: new FormData($('#contestant-save-form')[0])
        }).then(res => {

            if (res.data.status == true) {

                Swal.fire(
                    'Bilgileriniz eklendi.',
                    'Şimdi yarışmaya katılabilirsiniz',
                    'success'
                )
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
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

    function competitionSave() {

        axios({
            method: 'post',
            url: '{{ route('ui.competition_enter') }}',
            data: new FormData($('#competition-save-form')[0])
        }).then(res => {

            if (res.data.status == true) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Yarışmaya katıldığınız için teşekkür ederiz',
                    showConfirmButton: false,
                    timer: 1500
                })

                // document.getElementById('competition-save-form').reset();

                // $('#competitionModal').modal('hide');
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
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


    function login() {
        axios({
            method: 'post',
            url: '{{ route('login') }}',
            data: $('#login-form').serialize()
        }).then(res => {
            if (res.data.status == 0) {

                Swal.fire(
                    'Hatalı giriş !',
                    'Bilgilerinizi kontrol ediniz veya kayıt yapmadıysanız lütfen kayıt yapın',
                    'error'
                )

            }
            if (res.data.status != 0 && res.data.status != 2) {
                window.location.reload();
            }

        }).catch(err => {

        })
    }
</script>
