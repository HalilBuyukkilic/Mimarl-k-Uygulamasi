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
use App\Models\Workflow;

class AdminWorkflowController extends Controller
{
    public function workflow(){

        return view('dashboards.admins.workflow.workflow');
    }

    public function workflow_datatable(){
        $workflow = Workflow::on()->with('user')->where('send',1)->orderBy('id', 'DESC');

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

 
    public function workflow_show(Request $request, $workflow_id){

        $workflow =  Workflow::whereId($workflow_id)->with('media','user')->first();
     
        return view('dashboards.admins.workflow.workflow-show',compact('workflow'));
    }
    
    public function workflow_send_docs(Request $request)
    {
        $file = $request->file('file');
        if (isset($file)){
                
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

                
    
                    if ($media->save()) {
                        $workflow =  Workflow::find($request->workflow_id);
                        $workflow->okay=1;
                        $workflow->update();
                        return response()->json(['status'=>1,'msg'=>'Dekont yükleme işlemi başarılı']);
                    } else {
                        return response()->json(['status'=>0,'msg'=>'Dekont yükleme işlemi olurken bir hata meydana geldi.']);
                    }
            }
    
    }

    public function workflow_reject(Request $request){

        $workflow = Workflow::find($request->workflow_id);
        $workflow->okay = 2;
        $workflow->update();

        if(!$workflow->update()){
            return response()->json(['status'=>0,'reply'=>$request->status,'msg'=>'Ters giden birşeyler var']);
        }else{
            return response()->json(['status'=>1,'reply'=>$request->status,'msg'=>'İş akışı durumu değişti.']);
        }
    }
    

}
