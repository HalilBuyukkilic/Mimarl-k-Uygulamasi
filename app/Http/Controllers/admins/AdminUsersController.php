<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\User;

class AdminUsersController extends Controller
{
       public function users(){

        return view('dashboards.admins.users');
       }

       public function users_datatable()
       {
           $users = User::on()->orderBy('id', 'DESC');
   
           if ($users) {
               return DataTables::eloquent($users)
                   ->toJson();
           } else {
               return response()->json([
                   'message' => "Internal Server Error",
                   "code"    => 500
               ]);
           }
       }



    public function user_checked(Request $request){

        $user = User::find($request->user_id);
        $user->status = $request->status;
        $user->update();

        if(!$user->update()){
            return response()->json(['status'=>0,'reply'=>$request->status,'msg'=>'Ters giden birşeyler var']);
        }else{
            return response()->json(['status'=>1,'reply'=>$request->status,'msg'=>'Üye durumu güncellendi.']);
        }
    }


    public function user_detail(Request $request){
        
        $user =  User::whereId($request->user_id)->first();

        if ($user->exists()) {
            return Response::json(array(
                'status' => true,
                'messages' => 'asd',
                'data' => $user
            ));
        }
    }
    

    public function user_permission(Request $request){

        $user = User::find($request->user_id);
        $user->role = 1;
        $user->update();

        if(!$user->update()){
            return response()->json(['status'=>0,'msg'=>'Ters giden birşeyler var']);
        }else{
            return response()->json(['status'=>1,'msg'=>'Üye rolü güncellendi.']);
        }
    }


    public function user_delete(Request $request){

        $user = User::find($request->user_id);
  
        if(!$user->delete()){
            return response()->json(['status'=>0,'msg'=>'Ters giden birşeyler var']);
        }else{
            return response()->json(['status'=>1,'msg'=>'Kullanıcı silindi.']);
        }
    }

    

}
