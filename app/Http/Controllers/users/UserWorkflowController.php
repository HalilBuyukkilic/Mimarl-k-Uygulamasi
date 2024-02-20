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
use App\Models\Workflow;

class UserWorkflowController extends Controller
{
    public function workflow(){

        return view('dashboards.users.workflow.workflow');
    }

    public function workflow_datatable(){
        $workflow = Workflow::on()->with('user','media')->where('author',Auth::user()->id)->orderBy('id', 'DESC');

        if ($workflow) {
            return DataTables::eloquent($workflow)
                ->toJson();
        } else {
            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500
            ]);
        }
    }

    public function workflow_create(){
        return view('dashboards.users.workflow.workflow-create');
    }

    public function workflow_save(Request $request){
    
        $validator = \Validator::make($request->all(),[
            'title'=>'required'
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
                $workflow = new Workflow();
                $files = $request->file('files');

              
                $workflow->title = $request->title;
                $workflow->work_squaremeter = $request->work_squaremeter;
                $workflow->room_area = $request->room_area;
                $workflow->room_parcel = $request->room_parcel;
                $workflow->structure_class = $request->structure_class;
                $workflow->contractor_name = $request->contractor_name;
                $workflow->contractor_phone = $request->contractor_phone;
                $workflow->district = $request->district;
                $workflow->contractor_address = $request->contractor_address;
                $workflow->author = Auth::user()->id;
                $workflow->save();
                if (isset($files[0])){
                foreach ($files as  $file){
                   
                        $fileName = 'is_akisi-' . time() . '-' . '-' . rand(1, 999999) . '.' . $file->extension();
                        $file->storeAs('is_akisi', $fileName, 'public'); //@sunucu işlemlerinde yorum satırı yap
                        // $image->storeAs('storage/profile', $imageName, 'public'); // @sunucu işlemleri
                        $media = new Media();
                        $media->modul_type =  'is_akisi';
                        $media->modul_id =  $workflow->id;

                      
                        if ($file->extension()=='png' || $file->extension() == 'jpg' || $file->extension() == 'jpeg' || $file->extension() == 'webp'  ) {
                            $media->media_type =  'image';
                        }elseif ($file->extension() =='xlsx' || $file->extension() == 'docx' || $file->extension() == 'doc' || $file->extension() =='pdf' 
                                || $file->extension() == 'txt' || $file->extension() =='zip' || $file->extension()=='rar') {
                            $media->media_type =  'doc';
                        }else{
                            return response()->json(['status'=>0,'msg'=>'bilinmeyen bir dosya!']);
                        }
                        
                        $media->file_name =  $fileName;
                        $media->author =   Auth::user()->id;
                        $media->save();
        
                        if(!$media->save()){
                            return response()->json(['status'=>0,'msg'=>'Dosya eklenirken bir hata oluştu!']);
                        }
                    }
                }

                if(!$workflow->save()){
                    return response()->json(['status'=>0,'msg'=>'Ters giden birşeyler var']);
                }else{
                    return response()->json(['status'=>1,'msg'=>'Yeni iş akışı eklendi.']);
                }
        }
    }



    public function workflow_edit(Request $request, $workflow_id){
        
        $workflow =  Workflow::whereId($workflow_id)->with('media')->first();
       
        return view('dashboards.users.workflow.workflow-edit', compact('workflow'));
    }


    

    public function workflow_update(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'title'=>'required'
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $workflow =  Workflow::find($request->workflow_id);
            $files = $request->file('files');

         
            $workflow->title = $request->title;
            $workflow->work_squaremeter = $request->work_squaremeter;
            $workflow->room_area = $request->room_area;
            $workflow->room_parcel = $request->room_parcel;
            $workflow->structure_class = $request->structure_class;
            $workflow->contractor_name = $request->contractor_name;
            $workflow->contractor_phone = $request->contractor_phone;
            $workflow->district = $request->district;
            $workflow->contractor_address = $request->contractor_address;
            $workflow->author = Auth::user()->id;
            $workflow->update();
            
            if (isset($files[0])){
            foreach ($files as  $file){
                
                    $fileName = 'is_akisi-' . time() . '-' . '-' . rand(1, 999999) . '.' . $file->extension();
                    $file->storeAs('is_akisi', $fileName, 'public'); //@sunucu işlemlerinde yorum satırı yap
                    // $image->storeAs('storage/profile', $imageName, 'public'); // @sunucu işlemleri
                    $media = new Media();
                    $media->modul_type =  'is_akisi';
                    $media->modul_id =  $request->workflow_id;
                    if ($file->extension()=='png' || $file->extension() == 'jpg' || $file->extension() == 'jpeg' || $file->extension() == 'webp'  ) {
                        $media->media_type =  'image';
                    }elseif ($file->extension() =='xlsx' || $file->extension() == 'docx' || $file->extension() == 'doc' || $file->extension() =='pdf' 
                            || $file->extension() == 'txt' || $file->extension() =='zip' || $file->extension()=='rar') {
                        $media->media_type =  'doc';
                    }else{
                        return response()->json(['status'=>0,'msg'=>'bilinmeyen bir dosya!']);
                    }
                    $media->file_name =  $fileName;
                    $media->author =   Auth::user()->id;
                    $media->save();
    
                    if(!$media->save()){
                        return response()->json(['status'=>0,'msg'=>'Dosya eklenirken bir hata oluştu!']);
                    }
                }
            }

            if (!$workflow->update()) {
                return response()->json(['status'=>0,'msg'=>'Ters giden birşeyler var']);
            }else{
                return response()->json(['status'=>1,'msg'=>'İş akışı güncellendi.']);
            }
        
        }

    }

    public function workflow_delete(Request $request)
    {
        $workflow = Workflow::find($request->workflow_id);
        if ($workflow->delete()) {
            return response()->json(['status'=>1,'msg'=>'Silme işlemi başarılı']);
        } else {
            return response()->json(['status'=>0,'msg'=>'Silme işlemi olurken bir hata meydana geldi.']);
        }
    }




    public function workflow_deleted_list(){

        return view('dashboards.users.workflow.workflow-deleted-table');
    }

    public function workflow_deleted_datatable(){
            $workflow = Workflow::on()->orderBy('id', 'DESC')->onlyTrashed();

            if ($workflow) {
                return DataTables::eloquent($workflow)
                    ->toJson();
            } else {
                return response()->json([
                    'message' => "Internal Server Error",
                    "code"    => 500
                ]);
            }
    }
    

    public function workflow_restored(Request $request){

        $workflow =  Workflow::onlyTrashed()->find($request->workflow_id);
        if ($workflow->restore()) {
            return response()->json(['status'=>1,'msg'=>'İş akışı geri yükleme işlemi başarılı']);
        } else {
            return response()->json(['status'=>0,'msg'=>'İş akışı geri yükleme işlemi olurken bir hata meydana geldi.']);
        }
    }

    public function workflow_send(Request $request){

        $workflow = Workflow::find($request->workflow_id);
        $workflow->send = $request->status;
        $workflow->update();

        if(!$workflow->update()){
            return response()->json(['status'=>0,'reply'=>$request->status,'msg'=>'Ters giden birşeyler var']);
        }else{
            return response()->json(['status'=>1,'reply'=>$request->status,'msg'=>'İş akışı durumu değişti.']);
        }
    }




    

}
