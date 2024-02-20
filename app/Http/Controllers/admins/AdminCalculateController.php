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
use App\Models\DataStatics;

class AdminCalculateController extends Controller
{
    function calculate(){
        return view('dashboards.admins.calculates.calculate');
    }



    public function calculate_datatable(){
        
        $calculate = DataStatics::on()->orderBy('id', 'DESC');

        if ($calculate) {
            return DataTables::eloquent($calculate)
                ->toJson();
        } else {
            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500
            ]);
        }
    }



    public function calculate_save(Request $request){
    
        $validator = \Validator::make($request->all(),[
            'price'=>'required',
            'type'=>'required',
           // 'date'=>'required'
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
                $calculate = new DataStatics();

                $calculate->price = $request->price;
                $calculate->type = $request->type;
                $calculate->date = $request->date;
                $calculate->desc = $request->desc;
                $calculate->author = Auth::user()->id;
                $calculate->save();

              

                if(!$calculate->save()){
                    return response()->json(['status'=>0,'msg'=>'Ters giden birşeyler var']);
                }else{
                    return response()->json(['status'=>1,'msg'=>'Yeni girdi çıktı eklendi.']);
                }
            }
    }



    public function calculate_edit(Request $request){
        $calculate_id = $request->calculate_id;
        $calculate =  DataStatics::whereId($calculate_id)->first();

       
        if ($calculate->exists()) {
            return Response::json(array(
                'status' => true,
                'messages' => 'asd',
                'data' => $calculate
            ));
        }
    }


    

    public function calculate_update(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'price'=>'required'
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $calculate =  DataStatics::find($request->calculate_id);
            $image = $request->file('image');

            if (isset($image)) {
                $imageName = 'yarisma-' . time() . '-' . '-' . rand(1, 999999) . '.' . $image->extension();
                $image->storeAs('yarisma', $imageName, 'public'); //@sunucu işlemlerinde yorum satırı yap
                // $image->storeAs('storage/profile', $imageName, 'public'); // @sunucu işlemleri
                $calculate->image = $imageName;
            }
            $calculate->price = $request->price;
            $calculate->type = $request->type;
            $calculate->date = $request->date;
            $calculate->desc = $request->desc;
            $calculate->author = Auth::user()->id;
            $calculate->update();

            if (!$calculate->update()) {
                return response()->json(['status'=>0,'msg'=>'Ters giden birşeyler var']);
            }else{
                return response()->json(['status'=>1,'msg'=>'Girdi çıktı güncellendi.']);
            }
        
        }

    }

    public function calculate_delete(Request $request)
    {
        $calculate = DataStatics::find($request->calculate_id);
        if ($calculate->delete()) {
            return response()->json(['status'=>1,'msg'=>'Silme işlemi başarılı']);
        } else {
            return response()->json(['status'=>0,'msg'=>'Silme işlemi olurken bir hata meydana geldi.']);
        }
    }




    public function calculate_deleted_list(){

        return view('dashboards.admins.calculate.calculate-deleted-table');
    }

    public function calculate_deleted_datatable(){
            $calculate = DataStatics::on()->orderBy('id', 'DESC')->onlyTrashed();

            if ($calculate) {
                return DataTables::eloquent($calculate)
                    ->toJson();
            } else {
                return response()->json([
                    'message' => "Internal Server Error",
                    "code"    => 500
                ]);
            }
    }
    

    public function calculate_restored(Request $request){

        $calculate =  DataStatics::onlyTrashed()->find($request->calculate_id);
        if ($calculate->restore()) {
            return response()->json(['status'=>1,'msg'=>'Girdi çıktı geri yükleme işlemi başarılı']);
        } else {
            return response()->json(['status'=>0,'msg'=>'Girdi çıktı geri yükleme işlemi olurken bir hata meydana geldi.']);
        }
    }
}
