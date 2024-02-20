<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\Media;
use App\Models\Topics;

class UserTopicsController extends Controller
{
    public function topics(){

        return view('dashboards.users.topics.topics');
    }


    public function topics_datatable(){
        
        $topics = Topics::on()->where('author',Auth::user()->id)->orderBy('id', 'DESC');

        if ($topics) {
            return DataTables::eloquent($topics)
                ->toJson();
        } else {
            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500
            ]);
        }
    }

    public function topic_create(){
        return view('dashboards.users.topics.topic-create');
    }

    public function topic_save(Request $request){
    
        $validator = \Validator::make($request->all(),[
            'title'=>'required'
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
                $images = $request->file('images');
                $file = $request->file('file');
                $topic = new Topics();
             

                $topic->title = $request->title;
                $topic->slug = Str::slug($request->title);
                $topic->summary = $request->summary;
                $topic->content = $request->content;
                $topic->status = 0;
                $topic->author = Auth::user()->id;
                $topic->meta_title = $request->meta_title;
                $topic->meta_desc = $request->meta_desc;
                $topic->meta_keys = $request->meta_keys;
                $topic->save();

                if (isset($images[0])){
                    foreach ($images as  $image){
                    
                            $imageName = 'konu-' . time() . '-' . '-' . rand(1, 999999) . '.' . $image->extension();
                            $image->storeAs('konu', $imageName, 'public'); //@sunucu işlemlerinde yorum satırı yap
                            // $image->storeAs('storage/profile', $imageName, 'public'); // @sunucu işlemleri
                            $media = new Media();
                            $media->modul_type =  'konu';
                            $media->modul_id =  $topic->id;
                            $media->media_type =  'image';
                            $media->file_name =  $imageName;
                            $media->author =   Auth::user()->id;
                            $media->save();
            
                            if(!$media->save()){
                                return response()->json(['status'=>0,'msg'=>'Resim eklenirken bir hata oluştu!']);
                            }
                    }
                    
                }


                if (isset($file)) {
                    $fileName = 'konu-' . time() . '-' . '-' . rand(1, 999999) . '.' . $file->extension();
                    $file->storeAs('konu', $fileName, 'public'); //@sunucu işlemlerinde yorum satırı yap
                    // $file->storeAs('storage/profile', $fileName, 'public'); // @sunucu işlemleri
                    $media = new Media();
                    $media->modul_type =  'konu';
                    $media->modul_id =  $topic->id;
                    $media->media_type =  'doc';
                    $media->file_name =  $fileName;
                    $media->author =   Auth::user()->id;
                    $media->save();
    
                    if(!$media->save()){
                        return response()->json(['status'=>0,'msg'=>'Dosya eklenirken bir hata oluştu!']);
                    }
                    
                }

                if(!$topic->save()){
                    return response()->json(['status'=>0,'msg'=>'Ters giden birşeyler var']);
                }else{
                    return response()->json(['status'=>1,'msg'=>'Yeni etkinlik eklendi.']);
                }
            }
    }



    public function topic_edit(Request $request, $topic_id){
        
        $topic =  Topics::whereId($topic_id)->with('media')->first();
     
        foreach ($topic->media as $key => $value) {
            if ($value->media_type == 'doc') {
              $topic_file = $value;
            }else{
              $topic_file['id'] = 0; 
            }
        }

        return view('dashboards.users.topics.topic-edit', compact('topic','topic_file'));
    }


    

    public function topic_update(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'title'=>'required'
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $topic =  Topics::find($request->topic_id);
            $images = $request->file('images');
            $file = $request->file('file');



            $topic->title = $request->title;
            $topic->slug = Str::slug($request->title);
            $topic->summary = $request->summary;
            $topic->status = 0;
            $topic->content = $request->content;
            $topic->author = Auth::user()->id;
            $topic->meta_title = $request->meta_title;
            $topic->meta_desc = $request->meta_desc;
            $topic->meta_keys = $request->meta_keys;
            $topic->update();

            if (isset($images[0])){
                foreach ($images as  $image){
                
                        $imageName = 'konu-' . time() . '-' . '-' . rand(1, 999999) . '.' . $image->extension();
                        $image->storeAs('konu', $imageName, 'public'); //@sunucu işlemlerinde yorum satırı yap
                        // $image->storeAs('storage/profile', $imageName, 'public'); // @sunucu işlemleri
                        $media = new Media();
                        $media->modul_type =  'konu';
                        $media->modul_id =  $topic->id;
                        $media->media_type =  'image';
                        $media->file_name =  $imageName;
                        $media->author =   Auth::user()->id;
                        $media->save();
        
                        if(!$media->save()){
                            return response()->json(['status'=>0,'msg'=>'Resim eklenirken bir hata oluştu!']);
                        }
                }
                
            }


            if (isset($file)) {
                $fileName = 'konu-' . time() . '-' . '-' . rand(1, 999999) . '.' . $file->extension();
                $file->storeAs('konu', $fileName, 'public'); //@sunucu işlemlerinde yorum satırı yap
                // $file->storeAs('storage/profile', $fileName, 'public'); // @sunucu işlemleri
                $media = new Media();
                $media->modul_type =  'konu';
                $media->modul_id =  $topic->id;
                $media->media_type =  'doc';
                $media->file_name =  $fileName;
                $media->author =   Auth::user()->id;
                $media->save();

                if(!$media->save()){
                    return response()->json(['status'=>0,'msg'=>'Dosya eklenirken bir hata oluştu!']);
                }
                
            }


            if (!$topic->update()) {
                return response()->json(['status'=>0,'msg'=>'Ters giden birşeyler var']);
            }else{
                return response()->json(['status'=>1,'msg'=>'Konu güncellendi.']);
            }
        
        }

    }

    public function topic_delete(Request $request)
    {
        $topic = Topics::find($request->topic_id);
        if ($topic->delete()) {
            return response()->json(['status'=>1,'msg'=>'Silme işlemi başarılı']);
        } else {
            return response()->json(['status'=>0,'msg'=>'Silme işlemi olurken bir hata meydana geldi.']);
        }
    }




    public function topics_deleted_list(){

        return view('dashboards.users.topics.topics-deleted-table');
    }

    public function topics_deleted_datatable(){
            $topics = Topics::on()->where('author',Auth::user()->id)->orderBy('id', 'DESC')->onlyTrashed();

            if ($topics) {
                return DataTables::eloquent($topics)
                    ->toJson();
            } else {
                return response()->json([
                    'message' => "Internal Server Error",
                    "code"    => 500
                ]);
            }
    }
    

    public function topic_restored(Request $request){

        $topic =  Topics::onlyTrashed()->find($request->topic_id);
        if ($topic->restore()) {
            return response()->json(['status'=>1,'msg'=>'Konu geri yükleme işlemi başarılı']);
        } else {
            return response()->json(['status'=>0,'msg'=>'Konu geri yükleme işlemi olurken bir hata meydana geldi.']);
        }
    }
}
