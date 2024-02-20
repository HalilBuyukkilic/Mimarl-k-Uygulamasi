@extends('layouts.app')
@section('title', 'Mimarlar A.Ş')
@section('meta_keys', 'Mimarlar A.Ş')
@section('meta_desc', 'Mimarlar A.Ş')
@section('modul_css')
    <link rel="stylesheet" href="css/ui/home.css">
@endsection
<style>
    .image_modal {
        position: relative;

    }

    #showImage-modal {
        width: 100%;
        display: block;
    }

    .modal_title {
        background-color: rgb(0, 0, 0, 0.5);
        position: absolute;
        bottom: 0;
        color: white;
        width: 100%;
        font-size: 15px;
        padding: 15px 0;
        text-align: center;
        opacity: 1;
        transition: 0.6s;
    }

    .slide_title {
        background-color: rgb(0, 0, 0, 0.5);
        position: absolute;
        bottom: 0;
        color: white;

        font-size: 15px;
        padding: 15px 0;
        opacity: 1;
        transition: 0.6s;
    }
</style>
@section('content')
    <section style="background-color: #ececec;padding:20px;margin-top:70px">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 p-2">
                    <div class="p-2 home-card-section">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                            </ol>
                            <div class="carousel-inner">
                                @if (isset($news_slide_active->media))
                                    <div class="carousel-item active">
                                        <a href="{{ route('ui.news.page', $news_slide_active->slug) }}">
                                            <img class="d-block w-100"
                                                src="{{ asset('/storage/haber/' . $news_slide_active->media->file_name) }}"
                                                alt="First slide" height="450px">
                                            <div class="carousel-caption d-none d-md-block slide_title">
                                                <h5>
                                                    {{ $news_slide_active->title }}
                                                </h5>
                                                <p>
                                                    {{ $news_slide_active->summary }}
                                                </p>
                                            </div>
                                    </div>
                                    </a>
                                @else
                                    <div class="col-md-12 p-2 d-flex justify-content-center">
                                        <div class="alert alert-warning" role="alert">
                                            Henüz Haber Eklenmemiştir !
                                        </div>
                                    </div>
                                @endif

                                @if (count($news_slide) > 0)
                                    @foreach ($news_slide as $item)
                                        <div class="carousel-item">
                                            <a href="{{ route('ui.news.page', $item->slug) }}">
                                                <img class="d-block w-100"
                                                    src="{{ asset('/storage/haber/' . $item->media->file_name) }}"
                                                    alt="First slide" height="450px">
                                                <div class="carousel-caption d-none d-md-block slide_title">
                                                    <h5>
                                                        {{ $item->title }}
                                                    </h5>
                                                    <p>
                                                        {{ $item->summary }}
                                                    </p>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 p-2">
                    <div class="p-2 home-card-section">
                        <div id="carouselExampleIndicator" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicator" data-slide-to="5" class="active"></li>
                                <li data-target="#carouselExampleIndicator" data-slide-to="6"></li>
                                <li data-target="#carouselExampleIndicator" data-slide-to="7"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active" style="margin-bottom:7px">
                                    <canvas id="line-chart"
                                        style="max-height:450px;max-width:850px;margin-left:10px"></canvas>
                                </div>
                                <div class="carousel-item" style="margin-bottom:7px">
                                    <canvas id="bar-chart-grouped"
                                        style="max-height:450px;max-width:850px;margin-left:10px"></canvas>
                                </div>
                                <div class="carousel-item">
                                    <canvas id="pie-chart"
                                        style="max-height:450px;max-width:850px;margin-left:10px"></canvas>
                                </div>
                                {{-- <div class="carousel-item">
                                    <img class="d-block w-100" src="{{ URL::asset('/img/default/default-image.jpg') }}"
                                        alt="Third slide" height="450px">
                                </div> --}}
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicator" role="button"
                                data-slide="prev">
                                <span style="background-color:tomato" class="carousel-control-prev-icon"
                                    aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicator" role="button"
                                data-slide="next">
                                <span style="background-color:tomato" class="carousel-control-next-icon"
                                    aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <h2 class="d-flex justify-content-center mt-4 mb-4">DUYURULAR</h2>
                <div class="row">
                    <div class="col-md-6 p-2">
                        <div class="p-3 home-card-section">
                            <span class="d-flex justify-content-between">
                                <div class="home-notice-card-left-badge">
                                    <i class="fas fa-bullhorn home-notice-card-icon"></i>
                                </div>
                                <div class="home-notice-card-title">
                                    HABERLER
                                </div>
                            </span>
                            <hr class="my_hr">
                            <div class="home-notice-card-content mt-4">
                                <ul class="li_inline mr-4">
                                    @if (count($news_list) > 0)
                                        @foreach ($news_list as $item)
                                            <li>
                                                <a href="{{ route('ui.news.page', $item->slug) }}"><b>{{ date('d-m-Y', strtotime($item->created_at)) }}</b>{{ $item->title }}
                                                </a>
                                            </li>
                                            <hr class="my_hr">
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="d-flex justify-content-center">
                                <a class="btn btn-secondary" href="{{ route('ui.news.list') }}">Tümünü Göster <i
                                        class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 p-2">
                        <div class="p-3 home-card-section">
                            <span class="d-flex justify-content-between">
                                <div class="home-notice-card-rigth-badge">
                                    <i class="fas fa-clipboard-list home-notice-card-icon"></i>
                                </div>
                                <div class="home-notice-card-title">
                                    KONULAR
                                </div>
                            </span>
                            <hr class="my_hr">
                            <div class="home-notice-card-content mt-4">
                                <ul class="li_inline mr-4">
                                    @if (count($topics_list) > 0)
                                        @foreach ($topics_list as $item)
                                            <li>
                                                <a
                                                    href="{{ route('ui.topic.page', $item->slug) }}"><b>{{ date('d-m-Y', strtotime($item->created_at)) }}</b>{{ $item->title }}</a>
                                            </li>
                                            <hr class="my_hr">
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="d-flex justify-content-center">
                                <a class="btn btn-secondary" href="{{ route('ui.topic.list') }}">Tümünü Göster <i
                                        class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section style="background-color:#fafafa ;padding:20px;height:auto">
        <h2 class="d-flex justify-content-center mt-4 mb-1">ETKİNLİKLER</h2>
        <section class="home-events-section text-align-center">
            <div class="container">
                <div class="row">

                    @if (count($events_list) > 0)
                        @foreach ($events_list as $item)
                            <div class="col-md-3 p-2">
                                <a href="{{ route('ui.event.page', $item->slug) }}">
                                    <div class="card home-events-card card-inverse">
                                        <div class="card-block">
                                            <span class="home-events-card-fa fa fa-question-circle fa-3x"></span>
                                            <h4 class="card-title">{{ $item->title }}</h4>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
        </section>
    </section>


    <section style="background-color: #ececec;padding:20px;">
        <h2 class="d-flex justify-content-center mt-4 mb-4">SIKÇA SORULAN SORULAR</h2>
        <div id="accordion">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h6 class="panel-title">
                                    <a class="accordion-toggle" role="button" data-toggle="collapse"
                                        href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        İşveren, araştırmacı, firmalar tarafından üyelerimizin iletişim bilgilerinin
                                        verilmesi
                                        talebi
                                    </a>
                                </h6>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                                aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <br>
                                    Türk Mühendis ve Mimar Odaları Birliği Ana Yönetmeliği’nin 117.Maddesi ile Üye
                                    Bilgilerinin
                                    Gizliliği hakkında düzenlemeler getirilmiştir. Bu Maddede belirtildiği üzere; "Odalar
                                    üye
                                    adreslerini hiçbir şekilde dışarıya veremez, ancak mesleki araştırma ve meslekle ilgili
                                    tanıtım
                                    yapan kurum ve kuruluşlarca üyelere postalanması talep edilen tanıtım broşür ve benzeri
                                    matbuat
                                    için
                                    posta masrafları çeşitli giderler ve adres başına ilgili Oda Yönetim Kurulunca
                                    belirlenecek
                                    uygun
                                    bir ücret alınarak, ilgili Oda tarafından üyelere gönderilir."
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h6 class="panel-title">
                                    <a class="accordion-toggle" role="button" data-toggle="collapse"
                                        href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Öğrencilerden yaz stajları konusunda yardım talebi
                                    </a>
                                </h6>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel"
                                aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <br>
                                    TMMOB Mimarlar Odası Genel Merkezinin staj konusunda size yardımcı olması mümkün
                                    değildir. Ancak
                                    bulunduğunuz yerdeki Oda birimi ile iletişime geçerek konuyla ilgili yardım
                                    alabilirsiniz.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <h6 class="panel-title">
                                    <a class="accordion-toggle" role="button" data-toggle="collapse"
                                        href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Web Sitesine Üye Girişi nasıl yapılır, e-mail şifresi nasıl alınır?
                                    </a>
                                </h6>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel"
                                aria-labelledby="headingFour">
                                <div class="panel-body">
                                    <br>
                                    TMMOB Mimarlar Odası Web Sitesine Üye Girişi yapabilmeniz için, bağlı bulunduğunuz
                                    Mimarlar
                                    Odası
                                    Şubesinden konuyla ilgili hazırlanmış olan Sözleşmeyi alarak imzalayıp yine bağlı
                                    bulunduğunuz
                                    Şubeye teslim etmeniz gerekmektedir. TMMOB Mimarlar Odası Web Sitesi Üye Girişi’nde
                                    kullanacağınız
                                    şifreniz daha sonra tarafınıza iletilecektir.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="panel-heading" role="tab" id="headingFour">
                                <h6 class="panel-title">
                                    <a class="accordion-toggle" role="button" data-toggle="collapse"
                                        data-parent="#accordion" href="#collapseFour" aria-expanded="false"
                                        aria-controls="collapseFour">
                                        Yurtdışında alınan Mimarlık eğitimi sonrası Odaya kayıt nasıl yapılır?
                                    </a>
                                </h6>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse in" role="tabpanel"
                                aria-labelledby="headingFour">
                                <div class="panel-body">
                                    <br>
                                    -Aşağıda belirtilen belgeler kayıt yaptırılmak istenen Oda Birimine iletilecektir.
                                    <br>

                                    1) Kıbrıs’ta bulunan Üniversitelerden mezun olan üyelerden üye kayıt başvurularında;
                                    <ul>
                                        <li>Üyenin odaya kayıt başvuru dilekçesi</li>
                                        <li>5 adet vesikalık fotoğraf</li>
                                        <li>Nüfus cüzdanı aslı ile 2 adet fotokopisi</li>
                                        <li> Diploma veya çıkış belgesi aslı ile 2 adet noter tasdikli örneği</li>
                                        <li> YÖK'den denklik belgesinin aslı ile 2 adet noter tasdikli örneği</li>

                                    </ul>

                                    2)Yurtdışında çeşitli Üniversitelerin ve benzeri eğitim kurumlarından mezun olan (Kıbrıs
                                    Üniversiteleri hariç) üyelerden üye kayıt başvurularında;
                                    <ul>
                                        <li> Üyenin odaya kayıt başvuru dilekçesi</li>
                                        <li> 5 adet vesikalık fotoğraf</li>
                                        <li> Nüfus cüzdanı aslı ile 2 adet fotokopisi</li>
                                        <li> Diploma veya çıkış belgesi aslı ile 2 adet noter tasdikli örneği</li>
                                        <li>YÖK'den denklik belgesinin aslı ile 2 adet noter tasdikli örneği</li>
                                        <li>Kurumundan onaylanarak alınan ders kredilerinin Avrupa Kredi Transfer Sistemi
                                            (ECTS)
                                            karşılıkları**</li>
                                        <li> Yabancı programların mezunları için, programda alınan derslerin içerikleri
                                            (Türkçe
                                            çevirili)</li>
                                    </ul>
                                    <br>

                                    ** : Avrupa Kredi Transfer Sistemi’ne (ECTS) göre, Ünevirsite eğitiminde alınması
                                    gereken
                                    minimum
                                    kredi miktarı sömestr başına 30 ECTS kredi hesabı ile (European Credit Transfer System
                                    ECTS)
                                    uluslar
                                    arası bir standarda kavuşturulmuştur. Öğrenci değişim anlaşmaları yaptığımız tüm AB
                                    ülkeleri bu
                                    sisteme uymaktadır. Buna göre mimarlık eğitiminin tamamlana bilmesi için toplam 240 ECTS
                                    kredisi
                                    ile
                                    lisans derecesi almakta, +60 ECTS kredisi ile Yüksek lisans (Master of Architecture)
                                    derecesi
                                    alınmaktadır. (toplamda 300 ECTS Kredisi)
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="panel-heading" role="tab" id="headingFive">
                                <h6 class="panel-title">
                                    <a class="accordion-toggle" role="button" data-toggle="collapse"
                                        href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                        Odaya Öğrenci Üye nasıl olunur?
                                    </a>
                                </h6>
                            </div>
                            <div id="collapseFive" class="panel-collapse collapse in" role="tabpanel"
                                aria-labelledby="headingFive">
                                <div class="panel-body">
                                    <br>
                                    - TMMOB Mimarlar Odası Öğrenci Üyelik Yönetmeliği ile Üniversitelerin Mimarlık
                                    bölümlerinde öğrenim gören öğrencilerin "Öğrenci Üye" olarak kaydedilmesi esasları
                                    belirlenmiştir. Buna göre Türkiye Cumhuriyeti Vatandaşı olan ve Üniversitelerin mimarlık
                                    bölümlerinde lisans öğrencisi olma koşulunu sağlayanlar Yönetmeliğin 6.Maddesinde
                                    belirtilen belgelerle başvurmaları halinde Öğrenci Üyeliğe kabul edilirler:
                                    <br>
                                    <br>
                                    Öğrenci Üyelik İçin Gerekli Belgeler
                                    <br>
                                    <br>
                                    <ul>
                                        <li> 4 adet vesikalık fotoğraf</li>
                                        <li>Nüfus Cüzdanı aslı ve fotokopisi</li>
                                        <li>Oda’ya üye olma isteğini belirten, oda tarafından hazırlanmış ve öğrencisi
                                            olduğu üniversitenin mimarlık bölümünce onaylanan başvuru formu.</li>
                                        <li>Bu belgeleri bulunduğunuz yerdeki Mimarlar Odası Şubesine iletmeniz
                                            gerekmektedir.</li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="panel-heading" role="tab" id="headingSix">
                                <h6 class="panel-title">
                                    <a class="accordion-toggle" role="button" data-toggle="collapse"
                                        href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                        TMMOB Mimarlar Odası tarafından ücretli çalışan mimarlar için belirlenen asgari
                                        ücret nedir?
                                    </a>
                                </h6>
                            </div>
                            <div id="collapseSix" class="panel-collapse collapse in" role="tabpanel"
                                aria-labelledby="headingSix">
                                <div class="panel-body">
                                    <br>
                                    - 6235 Sayılı Türk Mühendis ve Mimar Odaları Birliği Kanunu ve TMMOB Mimarlar Odası
                                    Serbest Mimarlık Hizmetlerini Uygulama, Tescil ve Mesleki Denetim Yönetmeliği hükümleri
                                    uyarınca, Mimarlar Odası Yönetim Kurulu'nun 8 Şubat 2012 tarih ve 42/32-8 sayılı kararı
                                    ile "2012 yılı için tam zamanlı olarak ücretli çalışan mimarların asgari ücretinin tüm
                                    sosyal hakları ile birlikte aylık 1.950-TL olarak belirlenmesine" karar vermiştir.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="panel-heading" role="tab" id="headingSeven">
                                <h6 class="panel-title">
                                    <a class="accordion-toggle" role="button" data-toggle="collapse"
                                        href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                        Lisans eğitimi Mimarlık olmadığı halde Mimarlık Yüksek Lisans programları
                                        tamamlanarak Odaya kayıt yaptırılabilir mi?
                                    </a>
                                </h6>
                            </div>
                            <div id="collapseSeven" class="panel-collapse collapse in" role="tabpanel"
                                aria-labelledby="headingSeven">
                                <div class="panel-body">
                                    <br>
                                    3458 Sayılı Mühendislik ve Mimarlık Hakkında Kanun’un 1.Maddesi ile Türkiye Cumhuriyeti
                                    sınırları içerisinde mühendislik veya mimarlık unvanı ile mesleğini icra etmek
                                    isteyenlerin sahip olması gereken diploma ve belgeler sayılmış Kanunun 7.Maddesi ile bu
                                    diploma ve belgelere sahip olmayanların Türkiye’de mühendis veya mimar unvanı ile
                                    istihdam olunamayacakları ve imza kullanamayacakları belirtilmiştir.
                                    <br>
                                    <br>
                                    6235 Sayılı Türk Mühendis ve Mimar Odaları Birliği Kanunu’nun 33.Maddesi gereği;
                                    "Türkiye‘de mühendislik ve mimarlık meslekleri mensupları mesleklerinin icrasını iktiza
                                    ettiren işlerle meşgul olabilmeleri ve meslekî tedrisat yapabilmeleri için ihtisasına
                                    uygun bir odaya kaydolmak ve azalık vasfını muhafaza etmek mecburiyetindedirler."
                                    <br>
                                    <br>
                                    02.12.2002 tarih 24954 sayılı Resmi Gazete’de yayımlanmış olan TMMOB Ana Yönetmeliği’nin
                                    49.Maddesi ile Odalara Üyelik koşulları düzenlenmiştir; "Mühendislik-mimarlık mesleği
                                    mensupları, Birlik Genel Kurulu kararı ile belirlenen Odaya kaydolurlar. Oda
                                    kayıtlarında ve mesleği yapmada lisans eğitim esastır. Bir lisans diplomasıyla ancak
                                    TMMOB Genel Kurulunun onayladığı bir Odaya kaydolunabilinir. Lisansüstü eğitim ile
                                    alınan unvan, ikinci bir lisans diploması olarak değerlendirilemez, buna bağlı olarak
                                    mesleki çalışma yapılamayacağı gibi ilgili Odaya da kayıt yapılamaz."
                                    <br>
                                    <br>
                                    18.12.2004 tarih 25674 sayılı Resmi Gazete’de yayımlanmış olan TMMOB Mimarlar Odası Ana
                                    Yönetmeliği’nin 7.Maddesi ile Mimarlar Odası’na asli üyelik koşulları belirlenmiştir;
                                    "Türkiye Cumhuriyeti uyruğunda olup, yurt içinde mimarlık eğitimi veren eğitim
                                    kurumlarından birini bitiren ya da yurt dışındaki mimarlık eğitimi veren kurumlardan
                                    mezun olan ve diplomasının denkliği Yükseköğretim Kurulunca onaylanan, böylelikle yasal
                                    olarak mimarlık mesleğini uygulamaya hak kazanmış her mimar, mesleki etkinlikte
                                    bulunabilmek için Odaya üye olmak ve üyelik niteliğini korumak zorundadır. Üyelik
                                    kaydında lisans diploması esastır."
                                    <br>
                                    <br>
                                    Anılan mevzuat gereği lisans unvanınız Mimar olmadığı halde Mimarlık programında yüksek
                                    lisans yapmış olmanız Mimar unvanı ve yetkisi almanız için yeterli değildir.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="panel-heading" role="tab" id="headingEight">
                                <h6 class="panel-title">
                                    <a class="accordion-toggle" role="button" data-toggle="collapse"
                                        href="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                        Düzenlenmek istenen etkinlikler Oda Web Sitesi’nde nasıl duyurulabilir?
                                    </a>
                                </h6>
                            </div>
                            <div id="collapseEight" class="panel-collapse collapse in" role="tabpanel"
                                aria-labelledby="headingEight">
                                <div class="panel-body">
                                    <br>
                                    -Web Sitemizden duyurulmasını istediğiniz etkinliğe ait afiş ve programı aşağıda
                                    iletilen formatta, iletişim bilgileri verilen Aslı Tuncer Madge'e iletmeniz
                                    gerekmektedir.
                                    <br>
                                    <br>
                                    FORMAT
                                    <br>
                                    Görsel Malzeme
                                    <br>
                                    <br>
                                    Dijital ortamda, jpeg formatında olmalıdır. (etkinlik afişi)
                                    Metin
                                    <br>
                                    <br>
                                    Gönderilecek metinler dijital formatta ve Word ortamında hazırlanmış olmalıdır.
                                    (etkinlik programı)
                                    İLETİŞİM
                                    Aslı Tuncer Madge
                                    E-posta: asli.tuncer@mo.org.tr
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="panel-heading" role="tab" id="headingNine">
                                <h6 class="panel-title">
                                    <a class="accordion-toggle" role="button" data-toggle="collapse"
                                        href="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                        Oda Birimleri iletişim bilgilerine nasıl ulaşabilirim?
                                    </a>
                                </h6>
                            </div>
                            <div id="collapseNine" class="panel-collapse collapse in" role="tabpanel"
                                aria-labelledby="headingNine">
                                <div class="panel-body">
                                    <br>
                                    -TMMOB Mimarlar Odası Şube ve Temsilciliklerine ait iletişim bilgileri Odamız Resmi Web
                                    Sitesinde mevcuttur.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="panel-heading" role="tab" id="headingTen">
                                <h6 class="panel-title">
                                    <a class="accordion-toggle" role="button" data-toggle="collapse"
                                        href="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                        Odaya olan aidat borcumu nasıl öğrenebilir ve nasıl ödeme yapabilirim?
                                    </a>
                                </h6>
                            </div>
                            <div id="collapseTen" class="panel-collapse collapse in" role="tabpanel"
                                aria-labelledby="headingTen">
                                <div class="panel-body">
                                    <br>
                                    -18.12.2004 tarih, 25674 sayılı Resmi Gazete’de yayımlanan TMMOB Mimarlar Odası Ana
                                    Yönetmeliği gereği, Merkez Yönetim Kurulunca belirlenen yıllık üye ödentileri ile ilgili
                                    borcunuzu bağlı bulunduğunuz Oda Biriminden öğrenebilirsiniz.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Modal -->
    @if (isset($showing_modal))
        <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="dialog">
                <div class="modal-content">
                    <div class="image_modal" id="showImage-modal">
                        <img class="d-block w-100"
                            src="{{ asset('/storage/haber/' . $showing_modal->media->file_name) }}" alt="First slide"
                            height="450px">
                        <div class="modal_title">
                            <h5>
                                {{ $showing_modal->title }}
                            </h5>
                            <p class="mt-2">
                                {{ $showing_modal->summary }}
                            </p>
                        </div>

                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>
<script>
    $(document).ready(function() {
        $('#imageModal').modal('show');


        axios({
            method: 'get',
            url: '{{ route('ui.get_statics') }}',
        }).then(res => {
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
{{-- <div class="card">
    <div class="card-header">card başlıgı</div>

    <div class="card-body">

    </div>
</div> --}}
