@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'Konu Görüntüleme')

@section('content')
    <section class="content-header">
        <div class="container-fluid content-header-skeleton">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                        <li class="breadcrumb-item">Konular</li>
                        <li class="breadcrumb-item active">Konu Görüntüleme</li>
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
        <div class="container content-info-skeleton">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <span style="font-size: 22px;">
                        <i class="fas fa-clipboard-list mr-2"></i>Konu Görüntüleme
                    </span>
                    <span>
                        <a href="{{ route('admin.topics') }}"
                            class="backbg_fourthly back_textColor content-newform-right-buttons">
                            <i class="fas fa-list"></i> Liste
                        </a>
                        <a onclick="return_back();return false;"
                            class="backbg_secondary back_textColor  mr-1  content-newform-right-buttons">
                            <i class="fas fa-reply"></i> Geri
                        </a>
                    </span>
                </div>
                <hr class="mt-n3">



                <div class="row">
                    <div class="col-md-12">
                        <div class="row mt-4">
                            <div class="form-group col-md-10">
                                <label for="title">Başlık <span style="color: red">*</span></label>
                                <input id="title" type="text" class="form-control" name="title"
                                    value="{{ $topic->title }}" required autofocus placeholder="Başlık giriniz">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="status">Durum</label>
                                <div class="input-group">
                                    <select class="custom-select" name="status" id="inputGroupSelect02">
                                        <option value="1" {{ $topic->status == 1 ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="0" {{ $topic->status == 0 ? 'selected' : '' }}>Pasif
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-12 mt-3">
                                <label for="summary">Özet </label>
                                <input id="summary" type="text" class="form-control" name="summary" autofocus
                                    value="{{ $topic->summary }}" placeholder="Özet giriniz">
                            </div>
                        </div>
                    </div>
                </div>



                <div class="form-group col-md-12">
                    @if (is_countable($topic->media) && count($topic->media) > 0)
                        <label for="topic_files">Gönderilen Dosya </label>
                        <div class="row p-2 mt-2" style="background-color:#ddd">
                            @foreach ($topic->media as $media)
                                <div class="col-md-1 "
                                    style="border: 1px solid #bbb;padding:7px;border-radius:5px;background-color:#fff">
                                    @if ($media->media_type == 'image')
                                        <a href="{{ asset('/storage/konu') . '/' . $media->file_name }}">
                                            <img src="{{ asset('/storage/konu') . '/' . $media->file_name }}"
                                                style="height: 50px;width:60px" alt="">
                                        </a>
                                    @else
                                        @if ($media->media_type == 'doc')
                                            <a href="{{ asset('/storage/konu') . '/' . $media->file_name }}"
                                                style="height: 50px;width:70px;margin:10px" alt="">
                                                @if (explode('.', $media->file_name)[1] == 'pdf')
                                                    <i class="fas fa-file-pdf" style="font-size:50px;color:red"></i>
                                                @else
                                                    @if (explode('.', $media->file_name)[1] == 'xlsx')
                                                        <i class="fas fa-file-excel" style="font-size:50px;color:green"></i>
                                                    @else
                                                        @if (explode('.', $media->file_name)[1] == 'doc' || explode('.', $media->file_name)[1] == 'docx')
                                                            <i class="fas fa-file-word" style="font-size:50px"></i>
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
                                        @endif
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <textarea class="ckeditor form-control" name="content" id="topic_content">
                        {!! isset($topic->content) ? $topic->content : '' !!}
                        </textarea>
                </div>
            </div>
            <!-- /.tab-content -->
        </div><!-- /.card-body -->

        <!-- /.row -->
        <!-- /.container-fluid -->
        </div>
    </section>
    <section style="height: 100px">
    </section>
@endsection
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
