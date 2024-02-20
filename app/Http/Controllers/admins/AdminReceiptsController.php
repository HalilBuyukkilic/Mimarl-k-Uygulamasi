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
use App\Models\Receipts;

class AdminReceiptsController extends Controller
{
    public function receipts(){

        return view('dashboards.admins.receipts.receipts');
    }



    public function receipts_datatable(){
        
        $receipts = Receipts::on()
        ->with('user','media')->where('send',1)->orderBy('id', 'DESC');
    
        if ($receipts) {
            return DataTables::eloquent($receipts)
                ->toJson();
        } else {
            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500
            ]);
        }
    }



    public function receipt_save(Request $request){
        $file = $request->file('file');
        $validator = \Validator::make($request->all(),[
            'file'=>'file|required'
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
               
                $receipt = new Receipts();
                $receipt->desc = $request->desc;
                $receipt->author = Auth::user()->id;
                $receipt->save();

                if (isset($file)) {
                    $fileName = 'dekont-' . time() . '-' . '-' . rand(1, 999999) . '.' . $file->extension();
                    $file->storeAs('dekont', $fileName, 'public'); //@sunucu işlemlerinde yorum satırı yap
                    // $image->storeAs('storage/profile', $imageName, 'public'); // @sunucu işlemleri
                    $media = new Media();
                    $media->modul_type =  'dekont';
                    $media->modul_id =  $receipt->id;
                    $media->media_type =  'doc';
                    $media->file_name =  $fileName;
                    $media->author =   Auth::user()->id;
                    $media->save();
    
                    if(!$media->save()){
                        return response()->json(['status'=>0,'msg'=>'Dosya eklenirken bir hata oluştu!']);
                    }
                    
                }

                if(!$receipt->save()){
                    return response()->json(['status'=>0,'msg'=>'Ters giden birşeyler var']);
                }else{
                    return response()->json(['status'=>1,'msg'=>'Yeni dekont eklendi.']);
                }
            }
    }



    public function receipt_edit(Request $request){
        
        $receipt =  Receipts::whereId($request->receipt_id)->with('user','media')->first();

        if ($receipt->exists()) {
            return Response::json(array(
                'status' => true,
                'messages' => 'asd',
                'data' => $receipt
            ));
        }
    }


    

    public function receipt_update(Request $request)
    {
                $file = $request->file('file');
                      
                $receipt = Receipts::find($request->receipt_id);
                $receipt->desc = $request->desc;
                $receipt->send = $request->send;
                $receipt->author = Auth::user()->id;
                $receipt->update();

                if (isset($file)) {
                    $fileName = 'dekont-' . time() . '-' . '-' . rand(1, 999999) . '.' . $file->extension();
                    $file->storeAs('dekont', $fileName, 'public'); //@sunucu işlemlerinde yorum satırı yap
                    // $image->storeAs('storage/profile', $imageName, 'public'); // @sunucu işlemleri
                    $media = Media::find($request->media_id);
                    $media->modul_type =  'dekont';
                    $media->modul_id =  $receipt->id;
                    $media->media_type =  'doc';
                    $media->file_name =  $fileName;
                    $media->author =   Auth::user()->id;
                    $media->update();
    
                    if(!$media->update()){
                        return response()->json(['status'=>0,'msg'=>'Dosya eklenirken bir hata oluştu!']);
                    }
                    
                }

                if(!$receipt->update()){
                    return response()->json(['status'=>0,'msg'=>'Ters giden birşeyler var']);
                }else{
                    return response()->json(['status'=>1,'msg'=>'Yeni dekont eklendi.']);
                }
            
    }

    
    public function receipt_delete(Request $request)
    {
        $receipt = Receipts::find($request->receipt_id);
        if ($receipt->delete()) {
            return response()->json(['status'=>1,'msg'=>'Silme işlemi başarılı']);
        } else {
            return response()->json(['status'=>0,'msg'=>'Silme işlemi olurken bir hata meydana geldi.']);
        }
    }




    public function receipts_deleted_list(){
        return view('dashboards.admins.receipts.receipts-deleted-table');
    }

    public function receipts_deleted_datatable(){
            $receipts = Receipts::on()->orderBy('id', 'DESC')->onlyTrashed();

            if ($receipts) {
                return DataTables::eloquent($receipts)
                    ->toJson();
            } else {
                return response()->json([
                    'message' => "Internal Server Error",
                    "code"    => 500
                ]);
            }
    }
    

    public function receipt_restored(Request $request){

        $receipt =  Receipts::onlyTrashed()->find($request->receipt_id);
        if ($receipt->restore()) {
            return response()->json(['status'=>1,'msg'=>'Dekont geri yükleme işlemi başarılı']);
        } else {
            return response()->json(['status'=>0,'msg'=>'Dekont geri yükleme işlemi olurken bir hata meydana geldi.']);
        }
    }



    public function receipt_approval(Request $request){
        $receipt =  Receipts::whereId($request->receipt_id)->first();
        $receipt->okay = $request->okay;
        $receipt->update();
        if ($receipt->update()) {
            return Response::json(array(
                'status' => true,
                'messages' => 'asd',
                'data' => $receipt
            ));
        }
    }

}
