<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\Media;
use App\Models\News;


class AdminNewsController extends Controller
{
    public function news(){

        return view('dashboards.admins.news.news');
    }

    public function news_datatable(){
           $news = News::on()->orderBy('id', 'DESC');
   
           if ($news) {
               return DataTables::eloquent($news)
                   ->toJson();
           } else {
               return response()->json([
                   'message' => "Internal Server Error",
                   "code"    => 500
               ]);
           }
    }

    public function news_create(){
        return view('dashboards.admins.news.news-create');
    }

    public function news_save(Request $request){
      
      $validator = \Validator::make($request->all(),[
        'title'=>'required'
      ]);

      if(!$validator->passes()){
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
      }else{
            $image = $request->file('news_image');

            $news = new News();
            $news->title = $request->title;
            $news->slug = Str::slug($request->title);
            $news->summary = $request->summary;
            $news->content = $request->content;
            $news->status = $request->status;
            $news->author = Auth::user()->id;
            $news->meta_title = $request->meta_title;
            $news->meta_desc = $request->meta_desc;
            $news->meta_keys = $request->meta_keys;
            $news->save();

            if (isset($image)) {
                    $imageName = 'haber-' . time() . '-' . '-' . rand(1, 999999) . '.' . $image->extension();
                    $image->storeAs('haber', $imageName, 'public'); //@sunucu işlemlerinde yorum satırı yap
                    // $image->storeAs('storage/profile', $imageName, 'public'); // @sunucu işlemleri
                    $media = new Media();
                    $media->modul_type =  'haber';
                    $media->modul_id =  $news->id;
                    $media->media_type =  'image';
                    $media->file_name =  $imageName;
                    $media->author =   Auth::user()->id;
                    $media->save();
    
                    if(!$media->save()){
                        return response()->json(['status'=>0,'msg'=>'Resim eklenirken bir hata oluştu!']);
                    }
                    
                }

            if(!$news->save()){
                return response()->json(['status'=>0,'msg'=>'Ters giden birşeyler var']);
            }else{
                return response()->json(['status'=>1,'msg'=>'Yeni haber eklendi.']);
            }
        }
    }



    public function news_edit(Request $request, $news_id){

        $news =  News::whereId($news_id)->with('media')->first();
     
        return view('dashboards.admins.news.news-edit', compact('news'));
    }


    

    public function news_update(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'title'=>'required'
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $news =  News::find($request->news_id);
            $image = $request->file('news_image');

            $news->title = $request->title;
            $news->slug = Str::slug($request->title);
            $news->summary = $request->summary;
            $news->status = $request->status;
            $news->content = $request->content;
            $news->author = Auth::user()->id;
            $news->meta_title = $request->meta_title;
            $news->meta_desc = $request->meta_desc;
            $news->meta_keys = $request->meta_keys;
            $news->update();

            if (isset($image)) {
                $imageName = 'haber-' . time() . '-' . '-' . rand(1, 999999) . '.' . $image->extension();
                $image->storeAs('haber', $imageName, 'public'); //@sunucu işlemlerinde yorum satırı yap
                // $image->storeAs('storage/profile', $imageName, 'public'); // @sunucu işlemleri
          
                 if ($request->media_id == 0 && isset($image)) {
                    $media = new Media(); 
                    $media->modul_type =  'haber';
                    $media->modul_id =  $news->id;
                    $media->media_type =  'image';
                    $media->file_name =  $imageName;
                    $media->author =   Auth::user()->id;
                    $media->save();

                    if(!$media->save()){
                        return response()->json(['status'=>0,'msg'=>'Resim güncellenirken bir hata oluştu']);
                    }
                } else {
                    $media = Media::find($request->media_id);
                    $media->modul_type =  'haber';
                    $media->modul_id =  $news->id;
                    $media->media_type =  'image';
                    $media->file_name =  $imageName;
                    $media->author =   Auth::user()->id;
                    $media->update();

                    if(!$media->update()){
                        return response()->json(['status'=>0,'msg'=>'Resim güncellenirken bir hata oluştu!']);
                    }
                }
              
            }

            if (!$news->update()) {
                return response()->json(['status'=>0,'msg'=>'Ters giden birşeyler var']);
            }else{
                return response()->json(['status'=>1,'msg'=>'Haber güncellendi.']);
            }
        
        }

    }

    public function news_delete(Request $request)
    {
        $news = News::find($request->news_id);
        if ($news->delete()) {
            return response()->json(['status'=>1,'msg'=>'Silme işlemi başarılı']);
        } else {
            return response()->json(['status'=>0,'msg'=>'Silme işlemi olurken bir hata meydana geldi.']);
        }
    }




    public function news_deleted_list(){

        return view('dashboards.admins.news.news-deleted-table');
    }

    public function news_deleted_datatable(){
           $news = News::on()->orderBy('id', 'DESC')->onlyTrashed();
   
           if ($news) {
               return DataTables::eloquent($news)
                   ->toJson();
           } else {
               return response()->json([
                   'message' => "Internal Server Error",
                   "code"    => 500
               ]);
           }
    }
    

    public function news_restored(Request $request){

        $news =  News::onlyTrashed()->find($request->news_id);
        if ($news->restore()) {
            return response()->json(['status'=>1,'msg'=>'Haber geri yükleme işlemi başarılı']);
        } else {
            return response()->json(['status'=>0,'msg'=>'Haber geri yükleme işlemi olurken bir hata meydana geldi.']);
        }
    }


    public function showing_modal(Request $request){

        News::query()->update(['showing_modal' => 0]);
        $news =  News::find($request->news_id);
        $news->showing_modal = 1;
        $news->update();
        if ($news->update()) {
            return response()->json(['status'=>1,'msg'=>'Haberi duyuru ekranına taşıma işlemi başarılı']);
        } else {
            return response()->json(['status'=>0,'msg'=>'Haberi duyuru ekranına taşıma işlemi olurken bir hata meydana geldi.']);
        }
    }
    
    

}
