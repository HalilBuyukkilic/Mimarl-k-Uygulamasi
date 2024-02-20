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
use App\Models\Events;

class AdminEventsController extends Controller
{
    public function events(){

        return view('dashboards.admins.events.events');
    }

    public function events_datatable(){
        $events = Events::on()->orderBy('id', 'DESC');

        if ($events) {
            return DataTables::eloquent($events)
                ->toJson();
        } else {
            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500
            ]);
        }
    }

    public function events_create(){
        return view('dashboards.admins.events.events-create');
    }

    public function events_save(Request $request){
    
        $validator = \Validator::make($request->all(),[
            'title'=>'required'
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
                $event = new Events();
                $images = $request->file('images');

                $event->title = $request->title;
                $event->slug = Str::slug($request->title);
                $event->content = $request->content;
                $event->status = $request->status;
                $event->author = Auth::user()->id;
                $event->meta_title = $request->meta_title;
                $event->meta_desc = $request->meta_desc;
                $event->meta_keys = $request->meta_keys;
                $event->save();
                if (isset($images[0])){
                    foreach ($images as  $image){
                    
                            $imageName = 'etkinlik-' . time() . '-' . '-' . rand(1, 999999) . '.' . $image->extension();
                            $image->storeAs('etkinlik', $imageName, 'public'); //@sunucu işlemlerinde yorum satırı yap
                            // $image->storeAs('storage/profile', $imageName, 'public'); // @sunucu işlemleri
                            $media = new Media();
                            $media->modul_type =  'etkinlik';
                            $media->modul_id =  $event->id;
                            $media->media_type =  'image';
                            $media->file_name =  $imageName;
                            $media->author =   Auth::user()->id;
                            $media->save();
            
                            if(!$media->save()){
                                return response()->json(['status'=>0,'msg'=>'Resim eklenirken bir hata oluştu!']);
                            }
                    }
                    
                }
                if(!$event->save()){
                    return response()->json(['status'=>0,'msg'=>'Ters giden birşeyler var']);
                }else{
                    return response()->json(['status'=>1,'msg'=>'Yeni etkinlik eklendi.']);
                }
        }
    }



    public function events_edit(Request $request, $event_id){
        
        $event =  Events::whereId($event_id)->with('media')->first();
     
        return view('dashboards.admins.events.events-edit', compact('event'));
    }


    

    public function events_update(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'title'=>'required'
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $event =  Events::find($request->event_id);
            $images = $request->file('images');

            $event->title = $request->title;
            $event->slug = Str::slug($request->title);
            $event->status = $request->status;
            $event->content = $request->content;
            $event->author = Auth::user()->id;
            $event->meta_title = $request->meta_title;
            $event->meta_desc = $request->meta_desc;
            $event->meta_keys = $request->meta_keys;
            $event->update();
            if (isset($images[0])){
                foreach ($images as  $image){
                        $imageName = 'etkinlik-' . time() . '-' . '-' . rand(1, 999999) . '.' . $image->extension();
                        $image->storeAs('etkinlik', $imageName, 'public'); //@sunucu işlemlerinde yorum satırı yap
                        // $image->storeAs('storage/profile', $imageName, 'public'); // @sunucu işlemleri
                        $media = new Media();
                        $media->modul_type =  'etkinlik';
                        $media->modul_id =  $request->event_id;
                        $media->media_type =  'image';
                        $media->file_name =  $imageName;
                        $media->author =   Auth::user()->id;
                        $media->save();
        
                        if(!$media->save()){
                            return response()->json(['status'=>0,'msg'=>'Resim eklenirken bir hata oluştu!']);
                        }
                }
            }

            if (!$event->update()) {
                return response()->json(['status'=>0,'msg'=>'Ters giden birşeyler var']);
            }else{
                return response()->json(['status'=>1,'msg'=>'Etkinlik güncellendi.']);
            }
        
        }

    }

    public function events_delete(Request $request)
    {
        $events = Events::find($request->event_id);
        if ($events->delete()) {
            return response()->json(['status'=>1,'msg'=>'Silme işlemi başarılı']);
        } else {
            return response()->json(['status'=>0,'msg'=>'Silme işlemi olurken bir hata meydana geldi.']);
        }
    }




    public function events_deleted_list(){

        return view('dashboards.admins.events.events-deleted-table');
    }

    public function events_deleted_datatable(){
            $events = Events::on()->orderBy('id', 'DESC')->onlyTrashed();

            if ($events) {
                return DataTables::eloquent($events)
                    ->toJson();
            } else {
                return response()->json([
                    'message' => "Internal Server Error",
                    "code"    => 500
                ]);
            }
    }
    

    public function events_restored(Request $request){

        $events =  Events::onlyTrashed()->find($request->event_id);
        if ($events->restore()) {
            return response()->json(['status'=>1,'msg'=>'Etkinlik geri yükleme işlemi başarılı']);
        } else {
            return response()->json(['status'=>0,'msg'=>'Etkinlik geri yükleme işlemi olurken bir hata meydana geldi.']);
        }
    }


}
