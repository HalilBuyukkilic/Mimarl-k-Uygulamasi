<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UiController;

use App\Http\Controllers\admins\AdminController;
use App\Http\Controllers\admins\AdminUsersController;
use App\Http\Controllers\admins\AdminNewsController;
use App\Http\Controllers\admins\AdminTopicsController;
use App\Http\Controllers\admins\AdminEventsController;
use App\Http\Controllers\admins\AdminReceiptsController;
use App\Http\Controllers\admins\AdminCompetitionController;
use App\Http\Controllers\admins\AdminWorkflowController;
use App\Http\Controllers\admins\AdminMediaController;
use App\Http\Controllers\admins\AdminCalculateController;


use App\Http\Controllers\users\UserController;
use App\Http\Controllers\users\UserTopicsController;
use App\Http\Controllers\users\UserReceiptsController;
use App\Http\Controllers\users\UserWorkflowController;
use App\Http\Controllers\users\UserMediaController;

use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::fallback(function () {
//     return view('errors.404');
// });

Route::get('/',[UiController::class,'main_page'])->name('ui.home');
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('istatistik_ui_vericek',[UiController::class,'get_statics'])->name('ui.get_statics');


Route::get('haberler',[UiController::class,'news_list'])->name('ui.news.list');
Route::get('haberler/{slug}',[UiController::class,'news_page'])->name('ui.news.page');
Route::post('haber_gorunum',[UiController::class,'news_viewing'])->name('ui.news.viewing');



Route::get('konular',[UiController::class,'topic_list'])->name('ui.topic.list');
Route::get('konular/{slug}',[UiController::class,'topic_page'])->name('ui.topic.page');


Route::get('etkinlik',[UiController::class,'event_list'])->name('ui.event.list');
Route::get('etkinlik/{slug}',[UiController::class,'event_page'])->name('ui.event.page');


Route::get('yarisma',[UiController::class,'competition_page'])->name('ui.competition.page');
Route::post('yarisma_uyeliksiz_ekle',[UiController::class,'contestant_save'])->name('ui.contestant_save');
Route::post('yarisma_katil',[UiController::class,'competition_enter'])->name('ui.competition_enter');

Route::get('biz_kimiz',[UiController::class,'about_we'])->name('ui.about_we.page');
Route::get('oda_kaydi_nasil_yapilir',[UiController::class,'room_register'])->name('ui.room_register.page');

Route::post('dosya_indir', [UiController::class,'download_file'])->name('ui.download.file');


Route::middleware(['middleware'=>'PreventBackHistory'])->group(function () {
    Auth::routes();
});


Route::group(['prefix'=>'admin', 'middleware'=>['isAdmin','auth','PreventBackHistory']], function(){
    
    
        Route::get('veri_tablosu',[AdminController::class,'data_statics'])->name('admin.dashboard');
        Route::get('profil',[AdminController::class,'profile'])->name('admin.profile');
        Route::get('ayarlar',[AdminController::class,'settings'])->name('admin.settings');
        Route::get('istatistik_veri_cek',[AdminController::class,'get_statics'])->name('admin.get_statics');
        Route::get('bildirim_veri_cek',[AdminController::class,'getNotification'])->name('admin.get_notification');
        Route::get('bildirim_sifirla',[AdminController::class,'refreshNotification'])->name('admin.refresh_notification');
       

        Route::post('update-profile-info',[AdminController::class,'updateInfo'])->name('adminUpdateInfo');
        Route::post('change-profile-picture',[AdminController::class,'updatePicture'])->name('adminPictureUpdate');
        Route::post('change-password',[AdminController::class,'changePassword'])->name('adminChangePassword');

        Route::get('kullanicilar',[AdminUsersController::class,'users'])->name('admin.users');
        Route::get('kullanicilar_veritablosu',[AdminUsersController::class,'users_datatable'])->name('admin.users_datatable');
        Route::post('kullanici_durum',[AdminUsersController::class,'user_checked'])->name('admin.user_checked');
        Route::get('kullanici_detayi',[AdminUsersController::class,'user_detail'])->name('admin.user_detail');
        Route::post('kullanici_yetki',[AdminUsersController::class,'user_permission'])->name('admin.user_permission');
        Route::post('kullanici_sil',[AdminUsersController::class,'user_delete'])->name('admin.user_delete');

        Route::get('is_akisi',[AdminWorkflowController::class,'workflow'])->name('admin.workflow');
        Route::get('is_akisi_veritablosu',[AdminWorkflowController::class,'workflow_datatable'])->name('admin.workflow_datatable');
        Route::get('is_akisi_detayi/{workflow_id}',[AdminWorkflowController::class,'workflow_show'])->name('admin.workflow_show');
        Route::post('is_akisi_send_docs',[AdminWorkflowController::class,'workflow_send_docs'])->name('admin.workflow_send_docs');
        Route::post('is_akisi_reddetme',[AdminWorkflowController::class,'workflow_reject'])->name('admin.workflow_reject');
        

        Route::get('haberler',[AdminNewsController::class,'news'])->name('admin.news');
        Route::get('haberler_veritablosu',[AdminNewsController::class,'news_datatable'])->name('admin.news_datatable');
        Route::get('haber_ekle',[AdminNewsController::class,'news_create'])->name('admin.news_create');
        Route::post('haber_kaydet',[AdminNewsController::class,'news_save'])->name('admin.news_save');
        Route::get('haber_duzenle/{news_id}',[AdminNewsController::class,'news_edit'])->name('admin.news_edit');
        Route::post('haber_guncelle',[AdminNewsController::class,'news_update'])->name('admin.news_update');
        Route::post('haber_sil',[AdminNewsController::class,'news_delete'])->name('admin.news.delete');
        Route::get('silinmis_haberler',[AdminNewsController::class,'news_deleted_list'])->name('admin.deleted.news');
        Route::get('silinmis_haberler_veritablosu',[AdminNewsController::class,'news_deleted_datatable'])->name('admin.deleted.news_datatable');
        Route::post('haber_geriyukle',[AdminNewsController::class,'news_restored'])->name('admin.news_restored');
        Route::post('haber_duyur',[AdminNewsController::class,'showing_modal'])->name('admin.news_showing_modal');
     



        Route::get('etkinlikler',[AdminEventsController::class,'events'])->name('admin.events');
        Route::get('etkinlikler_veritablosu',[AdminEventsController::class,'events_datatable'])->name('admin.events_datatable');
        Route::get('etkinlik_ekle',[AdminEventsController::class,'events_create'])->name('admin.events_create');
        Route::post('etkinlik_kaydet',[AdminEventsController::class,'events_save'])->name('admin.events_save');
        Route::get('etkinlik_duzenle/{event_id}',[AdminEventsController::class,'events_edit'])->name('admin.events_edit');
        Route::post('etkinlik_guncelle',[AdminEventsController::class,'events_update'])->name('admin.events_update');
        Route::post('etkinlik_sil',[AdminEventsController::class,'events_delete'])->name('admin.events.delete');
        Route::get('silinmis_etkinlikler',[AdminEventsController::class,'events_deleted_list'])->name('admin.deleted.events');
        Route::get('silinmis_etkinlikler_veritablosu',[AdminEventsController::class,'events_deleted_datatable'])->name('admin.deleted.events_datatable');
        Route::post('etkinlik_geriyukle',[AdminEventsController::class,'events_restored'])->name('admin.event_restored');


        Route::get('yarismalar',[AdminCompetitionController::class,'competition'])->name('admin.competition');
        Route::get('yarisma_veritablosu',[AdminCompetitionController::class,'competition_datatable'])->name('admin.competition_datatable');
        Route::get('yarisma_ekle',[AdminCompetitionController::class,'competition_create'])->name('admin.competition_create');
        Route::post('yarisma_kaydet',[AdminCompetitionController::class,'competition_save'])->name('admin.competition_save');
        Route::post('yarisma_baslat',[AdminCompetitionController::class,'competition_publish'])->name('admin.competition_publish');
        Route::get('yarisma_duzenle/{competition_id}',[AdminCompetitionController::class,'competition_edit'])->name('admin.competition_edit');
        Route::post('yarisma_guncelle',[AdminCompetitionController::class,'competition_update'])->name('admin.competition_update');
        Route::post('yarisma_sil',[AdminCompetitionController::class,'competition_delete'])->name('admin.competition.delete');
        Route::get('silinmis_yarismalar',[AdminCompetitionController::class,'competition_deleted_list'])->name('admin.deleted.competition');
        Route::get('silinmis_yarisma_veritablosu',[AdminCompetitionController::class,'competition_deleted_datatable'])->name('admin.deleted.competition_datatable');
        Route::post('yarisma_geriyukle',[AdminCompetitionController::class,'competition_restored'])->name('admin.competition_restored');
        Route::get('yarisma_katilim/{competition_datas_id}',[AdminCompetitionController::class,'competition_datas'])->name('admin.competition_datas');
        Route::get('yarisma_katilim_veritablosu',[AdminCompetitionController::class,'competition_datas_datatable'])->name('admin.competition_data_datatable');
        Route::get('yarisma_katilim_detayi',[AdminCompetitionController::class,'competition_datas_details'])->name('admin.competition_datas_details.show');
        Route::post('yarisma_katilim_oyla',[AdminCompetitionController::class,'competition_datas_point'])->name('admin.competition_datas_point');


        Route::get('konular',[AdminTopicsController::class,'topics'])->name('admin.topics');
        Route::get('konular_veritablosu',[AdminTopicsController::class,'topics_datatable'])->name('admin.topics_datatable');
        
        Route::post('konu_secim',[AdminTopicsController::class,'topic_checked'])->name('admin.topic_checked');
        Route::get('konu_ekle',[AdminTopicsController::class,'topic_create'])->name('admin.topic_create');
        Route::post('konu_kaydet',[AdminTopicsController::class,'topic_save'])->name('admin.topic_save');
        Route::get('konu_goruntule/{topic_id}',[AdminTopicsController::class,'topic_show'])->name('admin.topic_show');
        Route::get('konu_duzenle/{topic_id}',[AdminTopicsController::class,'topic_edit'])->name('admin.topic_edit');
        Route::post('konu_guncelle',[AdminTopicsController::class,'topic_update'])->name('admin.topic_update');
        Route::post('konu_sil',[AdminTopicsController::class,'topic_delete'])->name('admin.topic.delete');
        
        Route::get('silinmis_konular',[AdminTopicsController::class,'topics_deleted_list'])->name('admin.deleted.topics');
        Route::get('silinmis_konular_veritablosu',[AdminTopicsController::class,'topics_deleted_datatable'])->name('admin.deleted.topics_datatable');
        Route::post('konu_geriyukle',[AdminTopicsController::class,'topic_restored'])->name('admin.topic_restored');


        Route::get('medya',[AdminMediaController::class,'media'])->name('admin.media');
        Route::get('medya/resimler/{modul_type}',[AdminMediaController::class,'imagesMedia'])->name('admin.media.images');
        Route::get('medya/resim/show',[AdminMediaController::class,'imagesMediaShow'])->name('admin.media.image.show');
        Route::post('medya/ekle',[AdminMediaController::class,'mediaSave'])->name('admin.media_save');
        Route::post('medya/sil',[AdminMediaController::class,'mediaDelete'])->name('admin.media.delete');
        
        Route::get('medya/dosyalar/{modul_type}',[AdminMediaController::class,'docsMedia'])->name('admin.media.docs');
        // Route::get('medya/resimler/haberler',[AdminMediaController::class,'imagesNews'])->name('admin.images.news');
        // Route::get('medya/resimler/konular',[AdminMediaController::class,'imagesTopics'])->name('admin.images.topics');
        // Route::get('medya/resimler/etkinlik',[AdminMediaController::class,'imagesEvents'])->name('admin.images.events');
        // Route::get('medya/resimler/yarisma',[AdminMediaController::class,'imagesCompetition'])->name('admin.images.competition');
       // Route::get('medya/dokumanlar/is_akisi',[AdminMediaController::class,'docsWorkflow'])->name('admin.docs.workflow');
        // Route::get('medya/dokumanlar/haberler',[AdminMediaController::class,'docsNews'])->name('admin.docs.news');
        // Route::get('medya/dokumanlar/konular',[AdminMediaController::class,'docsTopics'])->name('admin.docs.topics');
    
        





        Route::get('girdi_ciktilar',[AdminCalculateController::class,'calculate'])->name('admin.calculate');
        Route::get('girdi_ciktilar_veritablosu',[AdminCalculateController::class,'calculate_datatable'])->name('admin.calculate_datatable');
        Route::post('girdi_cikti_kaydet',[AdminCalculateController::class,'calculate_save'])->name('admin.calculate_save');
        Route::get('girdi_cikti_duzenle',[AdminCalculateController::class,'calculate_edit'])->name('admin.calculate_edit');
        Route::post('girdi_cikti_guncelle',[AdminCalculateController::class,'calculate_update'])->name('admin.calculate_update');
        Route::post('girdi_cikti_sil',[AdminCalculateController::class,'calculate_delete'])->name('admin.calculate.delete');
        Route::get('silinmis_girdi_ciktilar',[AdminCalculateController::class,'calculate_deleted_list'])->name('admin.deleted.calculate');
        Route::get('silinmis_girdi_ciktilar_veritablosu',[AdminCalculateController::class,'calculate_deleted_datatable'])->name('admin.deleted.calculate_datatable');
        Route::post('girdi_cikti_geriyukle',[AdminCalculateController::class,'calculate_restored'])->name('admin.calculate_restored');



        Route::get('dekontlar',[AdminReceiptsController::class,'receipts'])->name('admin.receipts');
        Route::get('dekontlar_veritablosu',[AdminReceiptsController::class,'receipts_datatable'])->name('admin.receipts_datatable');
        Route::post('dekont_kaydet',[AdminReceiptsController::class,'receipt_save'])->name('admin.receipt_save');
        Route::get('dekont_duzenle',[AdminReceiptsController::class,'receipt_edit'])->name('admin.receipt_edit');
        Route::post('dekont_guncelle',[AdminReceiptsController::class,'receipt_update'])->name('admin.receipt_update');
        Route::post('dekont_sil',[AdminReceiptsController::class,'receipt_delete'])->name('admin.receipt.delete');
        Route::get('silinmis_dekontlar',[AdminReceiptsController::class,'receipts_deleted_list'])->name('admin.deleted.receipts');
        Route::get('silinmis_dekontlar_veritablosu',[AdminReceiptsController::class,'receipts_deleted_datatable'])->name('admin.deleted.receipts_datatable');
        Route::post('dekont_geriyukle',[AdminReceiptsController::class,'receipt_restored'])->name('admin.receipt_restored');
        Route::post('dekont_onaylama',[AdminReceiptsController::class,'receipt_approval'])->name('admin.receipt_approval');

        Route::get('biz_kimiz',[AdminController::class,'about_us'])->name('admin.about_us');
        Route::get('oda_kaydi',[AdminController::class,'room_register'])->name('admin.room_register');

        Route::post('biz_kimiz_guncelle',[AdminController::class,'about_us_update'])->name('admin.about_us.update');
        Route::post('oda_kaydi_guncelle',[AdminController::class,'room_register_update'])->name('admin.room_register.update');
        Route::post('oda_kaydi_dosya_sil',[AdminController::class,'room_register_file_delete'])->name('admin.room_register.file_delete');




      

        // Route::get('storage-link', function () {
        //     $targetFolder=storage_path('app/public');
        //     $linkFolder = $_SERVER['DOCUMENT_ROOT'].'/storage';
        //     symlink($targetFolder,$linkFolder);
        
        //     return "Sembolik bağlantı oluşturuldu!";
        // });
     
});

Route::group(['prefix'=>'uye', 'middleware'=>['isUser','auth','PreventBackHistory']], function(){
    Route::get('veri_tablosu',[UserController::class,'data_statics'])->name('user.dashboard');
    Route::get('profil',[UserController::class,'profile'])->name('user.profile');
    Route::get('ayarlar',[UserController::class,'settings'])->name('user.settings');
    Route::get('is_akisi_bildirim_ekle',[UserController::class,'addNotificationWorkflow'])->name('user.is_akisi_add_notification');
    Route::get('dekont_bildirim_ekle',[UserController::class,'addNotificationReceipts'])->name('user.dekont_add_notification');
    Route::get('konu_bildirim_ekle',[UserController::class,'addNotificationTopics'])->name('user.topic_add_notification');

    Route::post('update-profile-info',[UserController::class,'updateInfo'])->name('userUpdateInfo');
    Route::post('change-profile-picture',[UserController::class,'updatePicture'])->name('userPictureUpdate');
    Route::post('change-password',[UserController::class,'changePassword'])->name('userChangePassword');
    Route::post('medya/sil',[UserController::class,'mediaDelete'])->name('user.media.delete');


    Route::get('medya',[UserMediaController::class,'media'])->name('user.media');
    Route::get('medya/resimler/{modul_type}',[UserMediaController::class,'imagesMedia'])->name('user.media.images');
    Route::get('medya/resim/show',[UserMediaController::class,'imagesMediaShow'])->name('user.media.image.show');
    Route::post('medya/ekle',[UserMediaController::class,'mediaSave'])->name('user.media_save');
    Route::post('medya/sil',[UserMediaController::class,'mediaDelete'])->name('user.media.delete');
    
    Route::get('medya/dosyalar/{modul_type}',[UserMediaController::class,'docsMedia'])->name('user.media.docs');
  


    Route::get('is_akisi',[UserWorkflowController::class,'workflow'])->name('user.workflow');
    Route::get('is_akisi_veritablosu',[UserWorkflowController::class,'workflow_datatable'])->name('user.workflow_datatable');
    Route::get('is_akisi_ekle',[UserWorkflowController::class,'workflow_create'])->name('user.workflow_create');
    Route::post('is_akisi_kaydet',[UserWorkflowController::class,'workflow_save'])->name('user.workflow_save');
    Route::post('is_akisi_gonder',[UserWorkflowController::class,'workflow_send'])->name('user.workflow_send');
    Route::get('is_akisi_duzenle/{workflow_id}',[UserWorkflowController::class,'workflow_edit'])->name('user.workflow_edit');
    Route::post('is_akisi_guncelle',[UserWorkflowController::class,'workflow_update'])->name('user.workflow_update');
    Route::post('is_akisi_sil',[UserWorkflowController::class,'workflow_delete'])->name('user.workflow.delete');
    Route::get('silinmis_is_akisi',[UserWorkflowController::class,'workflow_deleted_list'])->name('user.deleted.workflow');
    Route::get('silinmis_is_akisi_veritablosu',[UserWorkflowController::class,'workflow_deleted_datatable'])->name('user.deleted.workflow_datatable');
    Route::post('is_akisi_geriyukle',[UserWorkflowController::class,'workflow_restored'])->name('user.workflow_restored');


    Route::get('konular',[UserTopicsController::class,'topics'])->name('user.topics');
    Route::get('konular_veritablosu',[UserTopicsController::class,'topics_datatable'])->name('user.topics_datatable');
    Route::get('konu_ekle',[UserTopicsController::class,'topic_create'])->name('user.topic_create');
    Route::post('konu_kaydet',[UserTopicsController::class,'topic_save'])->name('user.topic_save');
    Route::get('konu_duzenle/{topic_id}',[UserTopicsController::class,'topic_edit'])->name('user.topic_edit');
    Route::post('konu_guncelle',[UserTopicsController::class,'topic_update'])->name('user.topic_update');
    Route::post('konu_sil',[UserTopicsController::class,'topic_delete'])->name('user.topic.delete');
    Route::get('silinmis_konular',[UserTopicsController::class,'topics_deleted_list'])->name('user.deleted.topics');
    Route::get('silinmis_konular_veritablosu',[UserTopicsController::class,'topics_deleted_datatable'])->name('user.deleted.topics_datatable');
    Route::post('konu_geriyukle',[UserTopicsController::class,'topic_restored'])->name('user.topic_restored');


    Route::get('dekontlar',[UserReceiptsController::class,'receipts'])->name('user.receipts');
    Route::get('dekontlar_veritablosu',[UserReceiptsController::class,'receipts_datatable'])->name('user.receipts_datatable');
    Route::post('dekont_kaydet',[UserReceiptsController::class,'receipt_save'])->name('user.receipt_save');
    Route::get('dekont_duzenle',[UserReceiptsController::class,'receipt_edit'])->name('user.receipt_edit');
    Route::post('dekont_guncelle',[UserReceiptsController::class,'receipt_update'])->name('user.receipt_update');
    Route::post('dekont_gonder',[UserReceiptsController::class,'receipt_send'])->name('user.receipt_send');
    Route::post('dekont_sil',[UserReceiptsController::class,'receipt_delete'])->name('user.receipt.delete');
    Route::get('silinmis_dekontlar',[UserReceiptsController::class,'receipts_deleted_list'])->name('user.deleted.receipts');
    Route::get('silinmis_dekontlar_veritablosu',[UserReceiptsController::class,'receipts_deleted_datatable'])->name('user.deleted.receipts_datatable');
    Route::post('dekont_geriyukle',[UserReceiptsController::class,'receipt_restored'])->name('user.receipt_restored');

});



