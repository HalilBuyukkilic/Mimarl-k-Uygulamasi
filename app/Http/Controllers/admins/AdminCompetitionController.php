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
use App\Models\Competition;
use App\Models\Contestant;
use App\Models\CompetitionDatas;

class AdminCompetitionController extends Controller
{
    public function competition(){

        return view('dashboards.admins.competition.competition');
    }


    public function competition_datatable(){
        
        $competition = Competition::on()->orderBy('id', 'DESC');

        if ($competition) {
            return DataTables::eloquent($competition)
                ->toJson();
        } else {
            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500
            ]);
        }
    }

    public function competition_create(){
        return view('dashboards.admins.competition.competition-create');
    }

    public function competition_save(Request $request){
    
    $validator = \Validator::make($request->all(),[
        'title'=>'required'
    ]);

    if(!$validator->passes()){
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    }else{
            $competition = new Competition();
            $image = $request->file('competition_image');
            $file = $request->file('file');

            $competition->title = $request->title;
            $competition->slug = Str::slug($request->title);
            $competition->content = $request->content;
            $competition->status = 0;
            $competition->countImage = $request->countImage;
            $competition->start_date = $request->start_date;
            $competition->end_date = $request->end_date;
            $competition->author = Auth::user()->id;
            $competition->meta_title = $request->meta_title;
            $competition->meta_desc = $request->meta_desc;
            $competition->meta_keys = $request->meta_keys;
            $competition->save();

            if (isset($image)) {
                $imageName = 'yarisma-' . time() . '-' . '-' . rand(1, 999999) . '.' . $image->extension();
                $image->storeAs('yarisma', $imageName, 'public'); //@sunucu işlemlerinde yorum satırı yap
                // $image->storeAs('storage/profile', $imageName, 'public'); // @sunucu işlemleri
                $media = new Media();
                $media->modul_type =  'yarisma';
                $media->modul_id =  $competition->id;
                $media->media_type =  'image';
                $media->file_name =  $imageName;
                $media->author =   Auth::user()->id;
                $media->save();

                if(!$media->save()){
                    return response()->json(['status'=>0,'msg'=>'Resim eklenirken bir hata oluştu!']);
                }
                
            }

            if (isset($file)) {
                $fileName = 'yarisma-' . time() . '-' . '-' . rand(1, 999999) . '.' . $file->extension();
                $file->storeAs('yarisma', $fileName, 'public'); //@sunucu işlemlerinde yorum satırı yap
                // $file->storeAs('storage/profile', $fileName, 'public'); // @sunucu işlemleri
                $media = new Media();
                $media->modul_type =  'yarisma';
                $media->modul_id =  $competition->id;
                $media->media_type =  'doc';
                $media->file_name =  $fileName;
                $media->author =   Auth::user()->id;
                $media->save();

                if(!$media->save()){
                    return response()->json(['status'=>0,'msg'=>'Dosya eklenirken bir hata oluştu!']);
                }
                
            }

            if(!$competition->save()){
                return response()->json(['status'=>0,'msg'=>'Ters giden birşeyler var']);
            }else{
                return response()->json(['status'=>1,'msg'=>'Yeni etkinlik eklendi.']);
            }
        }
    }



    public function competition_edit(Request $request, $competition_id){
        
        $competition =  Competition::whereId($competition_id)->with('media')->first();
        foreach ($competition->media as $key => $value) {
          if ($value->media_type == 'doc') {
            $competition_file = $value;
          }else{
            $competition_file['id'] = 0; 
          }
         
        }
      

        return view('dashboards.admins.competition.competition-edit', compact('competition' ,'competition_file'));
    }


    

    public function competition_update(Request $request)
    {

        $image = $request->file('competition_image');
        $file = $request->file('file');
        
        $validator = \Validator::make($request->all(),[
            'title'=>'required'
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $competition =  Competition::find($request->competition_id);
    
            $competition->title = $request->title;
            $competition->slug = Str::slug($request->title);
            $competition->content = $request->content;
            $competition->countImage = $request->countImage;
            $competition->start_date = $request->start_date;
            $competition->end_date = $request->end_date;
            $competition->author = Auth::user()->id;
            $competition->meta_title = $request->meta_title;
            $competition->meta_desc = $request->meta_desc;
            $competition->meta_keys = $request->meta_keys;
            $competition->update();

         

            
            if (isset($image)) {
                $imageName = 'yarisma-' . time() . '-' . '-' . rand(1, 999999) . '.' . $image->extension();
                $image->storeAs('yarisma', $imageName, 'public'); //@sunucu işlemlerinde yorum satırı yap
                // $image->storeAs('storage/profile', $imageName, 'public'); // @sunucu işlemleri
                $media = Media::find($request->media_id);
                $media->modul_type =  'yarisma';
                $media->modul_id =  $competition->id;
                $media->media_type =  'image';
                $media->file_name =  $imageName;
                $media->author =   Auth::user()->id;
                $media->update();

                if(!$media->update()){
                    return response()->json(['status'=>0,'msg'=>'Resim güncellenirken bir hata oluştu!']);
                }
            }

            if (isset($file)) {
                $fileName = 'yarisma-' . time() . '-' . '-' . rand(1, 999999) . '.' . $file->extension();
                $file->storeAs('yarisma', $fileName, 'public'); //@sunucu işlemlerinde yorum satırı yap
                // $file->storeAs('storage/profile', $fileName, 'public'); // @sunucu işlemleri
                $media = new Media();
                $media->modul_type =  'yarisma';
                $media->modul_id =  $competition->id;
                $media->media_type =  'doc';
                $media->file_name =  $fileName;
                $media->author =   Auth::user()->id;
                $media->save();

                if(!$media->save()){
                    return response()->json(['status'=>0,'msg'=>'Dosya eklenirken bir hata oluştu!']);
                }
                
            }

            if (!$competition->update()) {
                return response()->json(['status'=>0,'msg'=>'Ters giden birşeyler var']);
            }else{
                return response()->json(['status'=>1,'msg'=>'Yarışma güncellendi.']);
            }
        
        }

    }

    public function competition_delete(Request $request)
    {
        $competition = Competition::find($request->competition_id);
        if ($competition->delete()) {
            return response()->json(['status'=>1,'msg'=>'Silme işlemi başarılı']);
        } else {
            return response()->json(['status'=>0,'msg'=>'Silme işlemi olurken bir hata meydana geldi.']);
        }
    }




    public function competition_deleted_list(){

        return view('dashboards.admins.competition.competition-deleted-table');
    }

    public function competition_deleted_datatable(){
            $competition = Competition::on()->orderBy('id', 'DESC')->onlyTrashed();

            if ($competition) {
                return DataTables::eloquent($competition)
                    ->toJson();
            } else {
                return response()->json([
                    'message' => "Internal Server Error",
                    "code"    => 500
                ]);
            }
    }

    

    public function competition_datas(Request $request ,$competition_datas_id){
        $competition = Competition::find($competition_datas_id);
        return view('dashboards.admins.competition.competition-datas',compact('competition'));
    }


    public function competition_datas_datatable(Request $request){

        $competitionDatas = CompetitionDatas::on()
        ->where('competition_id',$request->competition_datas_id)->orderBy('point', 'DESC');

        if ($competitionDatas) {
            return DataTables::eloquent($competitionDatas)
                ->toJson();
        } else {
            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500
            ]);
        }
    }

    public function competition_datas_details(Request $request){

        $competition_data = CompetitionDatas::find($request->competition_datas_id);
 
        if ($competition_data->user_id != 0) {
            $competitionDatas = CompetitionDatas::with(['media_user' => function($query) use ($competition_data) {
                $query->where('author', $competition_data->user_id);
            },'user_data'])->where('id',$request->competition_datas_id)->first();
        }else{
            $competitionDatas = CompetitionDatas::with(['media_contestant' => function($query) use ($competition_data) {
                $query->where('contestant', $competition_data->contestant_id);
            },'contestant_data'])
            ->where('id',$request->competition_datas_id)->first();
        }
         
        
          
        if ($competitionDatas->exists()) {
            return Response::json(array(
                'status' => true,
                'messages' => 'asd',
                'data' => $competitionDatas
            ));
        }
    }
    
    public function competition_datas_point(Request $request){

        $competitionDatas =  CompetitionDatas::find($request->competition_datas_id);
        $competitionDatas->point = $request->rating;
        $competitionDatas->update();

        if ($competitionDatas->update()) {
            return response()->json(['status'=>1,'msg'=>'Yarışmacı oylama işlemi başarılı']);
        } else {
            return response()->json(['status'=>0,'msg'=>'Yarışmacı oylama işlemi olurken bir hata meydana geldi.']);
        }
    }
    

    public function competition_restored(Request $request){

        $competition =  Competition::onlyTrashed()->find($request->competition_id);
        if ($competition->restore()) {
            return response()->json(['status'=>1,'msg'=>'Yarışma geri yükleme işlemi başarılı']);
        } else {
            return response()->json(['status'=>0,'msg'=>'Yarışma geri yükleme işlemi olurken bir hata meydana geldi.']);
        }
    }


    

    
    public function competition_publish(Request $request){

        Competition::query()->update(['status' => 0]);
        $competition =  Competition::find($request->competition_id);
        $competition->status = $request->status;
        $competition->update();
        if ($competition->update()) {
            return response()->json(['status'=>1,'msg'=>'Yarışma duyuru ekranına taşıma işlemi başarılı']);
        } else {
            return response()->json(['status'=>0,'msg'=>'Yarışma duyuru ekranına taşıma işlemi olurken bir hata meydana geldi.']);
        }
    }



}
