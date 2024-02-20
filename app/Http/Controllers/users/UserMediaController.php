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

class UserMediaController extends Controller
{
    function media(){
        return view('dashboards.users.media.media');      
    }


    function imagesMedia(Request $request, $modul_type){
       
        $mediaImages =  Media::where('modul_type',$modul_type)
        ->where('media_type','image')
        ->where('author',Auth::user()->id)
        ->get();
      
        return view('dashboards.users.media.media_images', compact('mediaImages','modul_type'));
    }


    function imagesMediaShow(Request $request){
        $mediaImageShow =  Media::whereId($request->media_id)
        ->first();
        
       
        if ($mediaImageShow->exists()) {
            return Response::json(array(
                'status' => true,
                'messages' => 'asd',
                'data' => $mediaImageShow
            ));
        }
    }


    function docsMedia(Request $request, $modul_type){
        $docsMedia =  Media::where('modul_type',$modul_type)
        ->where('media_type','doc')
        ->where('author',Auth::user()->id)
        ->get();
      
        return view('dashboards.users.media.media_document', compact('docsMedia','modul_type'));
    }

    public function mediaSave(Request $request)
    {
       
        $media_image = $request->file('media_image');
        $media_file = $request->file('file');

        if (isset($media_image)) {
            $imageName = $request->modul_type. time() . '-' . '-' . rand(1, 999999) . '.' . $media_image->extension();
            $media_image->storeAs($request->modul_type, $imageName, 'public'); //@sunucu işlemlerinde yorum satırı yap
        
            $media = new Media(); 
            $media->modul_type =  $request->modul_type;
            $media->modul_id =  0;
            $media->media_type =  'image';
            $media->file_name =  $imageName;
            $media->author = Auth::user()->id;
            $media->save();

            if(!$media->save()){
                return response()->json(['status'=>0,'msg'=>'Resim eklerken bir hata oluştu']);
            }else{
          
                return response()->json(['status'=>1,'msg'=>'Resim ekleme işlemi başarılı']);
               
            }
        }else {
            if (isset($media_file)) {
                $media_fileName = $request->modul_type. time() . '-' . '-' . rand(1, 999999) . '.' . $media_file->extension();
                $media_file->storeAs($request->modul_type, $media_fileName, 'public'); //@sunucu işlemlerinde yorum satırı yap
            
                $media = new Media(); 
                $media->modul_type =  $request->modul_type;
                $media->modul_id =  0;
                $media->media_type =  'doc';
                $media->file_name =  $media_fileName;
                $media->author = Auth::user()->id;
                $media->save();
    
                if(!$media->save()){
                    return response()->json(['status'=>0,'msg'=>'Dosya eklerken bir hata oluştu']);
                }else{
              
                    return response()->json(['status'=>1,'msg'=>'Dosya ekleme işlemi başarılı']);
                   
                }
            
           
           }
        }


    }


    public function mediaDelete(Request $request)
    {
        $media = Media::find($request->media_id);
        if ($media->delete()) {
            return response()->json(['status'=>1,'msg'=>'Silme işlemi başarılı']);
        } else {
            return response()->json(['status'=>0,'msg'=>'Silme işlemi olurken bir hata meydana geldi.']);
        }
    }
    
    
}
