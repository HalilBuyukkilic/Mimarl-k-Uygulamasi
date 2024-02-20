<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use Auth;
use App\Models\User;
use App\Models\Workflow;
use App\Models\DataStatics;
use App\Models\Competition;
use App\Models\Events;
use App\Models\News;
use App\Models\Receipts;
use App\Models\Topics;
use App\Models\RoomRegister;
use App\Models\AboutUs;
use App\Models\Notificaiton;


class AdminController extends Controller
{
       function data_statics(){
           
        $dataUser =  User::where('role',2)->count();
        $dataWorkflow =  Workflow::where('send',1)->count();
        $dataCompetition =  Competition::count();
        $dataEvents =  Events::count();
        $dataNews =  News::count();
        $dataReceipts =  Receipts::where('send',1)->count();
        $dataTopics =  Topics::where('status',1)->count();

        return view('dashboards.admins.index',compact('dataUser','dataWorkflow', 'dataCompetition','dataEvents' ,'dataNews' ,'dataReceipts' , 'dataTopics'));
       }
    
       function profile(){
           return view('dashboards.admins.profile');
       }
       function settings(){
           return view('dashboards.admins.settings');
       }

       function updateInfo(Request $request){
           
               $validator = \Validator::make($request->all(),[
                   'name'=>'required',
                   'email'=> 'required|email|unique:users,email,'.Auth::user()->id,
                   'username' => 'required|string|unique:users,username,'.Auth::user()->id,
                   'identity_no' => 'required|string|unique:users,identity_no,'.Auth::user()->id,
                   'iban_no' => 'required|string|unique:users,iban_no,'.Auth::user()->id,
                   'tax_no' => 'required|string|unique:users,tax_no,'.Auth::user()->id,
               ]);

               $validator->setAttributeNames([
                'username' => 'Kullanıcı adı',
                'identity_no'=>'Tc kimlik no',
                'iban_no'=> 'İban No',
                'tax_no'=> 'Vergi No',
                // Diğer alanlar için özel metinler
                ]);
                
                $validator->setCustomMessages([
                    'username.unique' => 'Bu kullanıcı adı zaten alınmış.',
                    'username.required' => 'Lütfen bir kullanıcı adı girin.',

                   'identity_no.unique' => 'Bu tc no zaten alınmış.',
                   'identity_no.required' => 'Lütfen bir tc no girin.',

                   'iban_no.unique' => 'Bu iban no zaten alınmış.',
                   'iban_no.required' => 'Lütfen bir iban no girin.',

                   'tax_no.unique' => 'Bu vergi no zaten alınmış.',
                   'tax_no.required' => 'Lütfen bir vergi no girin.',
                  
                    // Diğer özel hata mesajları
                ]);
               if(!$validator->passes()){
                   return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
               }else{
                    $user = User::find(Auth::user()->id);
                    $user->name =$request->name;
                    $user->email =$request->email;
                    $user->username = $request->username;
                    $user->identity_no = $request->identity_no;
                    $user->iban_no = $request->iban_no ;
                    $user->tax_no =  $request->tax_no;
                    $user->update();

                    if(!$user->update()){
                        return response()->json(['status'=>0,'msg'=>'Bir şeyler ters gitti.']);
                    }else{
                        return response()->json(['status'=>1,'msg'=>'Profil bilgileriniz başarıyla güncellendi.']);
                    }
               }
       }

       function updatePicture(Request $request){
           $path = 'users/images/';
           $file = $request->file('admin_image');
           $new_name = 'UIMG_'.date('Ymd').uniqid().'.jpg';

           //Upload new image
           $upload = $file->move(public_path($path), $new_name);
           
           if( !$upload ){
               return response()->json(['status'=>0,'msg'=>'Bir şeyler ters gitti, yeni resim yüklenemedi.']);
           }else{
               //Get Old picture
               $oldPicture = User::find(Auth::user()->id)->getAttributes()['picture'];

               if( $oldPicture != '' ){
                   if( \File::exists(public_path($path.$oldPicture))){
                       \File::delete(public_path($path.$oldPicture));
                   }
               }

               //Update DB
               $update = User::find(Auth::user()->id)->update(['picture'=>$new_name]);

               if( !$upload ){
                   return response()->json(['status'=>0,'msg'=>'Bir şeyler ters gitti, db`deki resim güncellenemedi.']);
               }else{
                   return response()->json(['status'=>1,'msg'=>'Profil resminiz başarıyla güncellendi']);
               }
           }
       }


       function changePassword(Request $request){
           //Validate form
           $validator = \Validator::make($request->all(),[
               'oldpassword'=>[
                   'required', function($attribute, $value, $fail){
                       if( !\Hash::check($value, Auth::user()->password) ){
                           return $fail(__('Mevcut şifre yanlış'));
                       }
                   },
                   'min:6',
                   'max:15'
                ],
                'newpassword'=>'required|min:6|max:15',
                'cnewpassword'=>'required|same:newpassword'
            ],[
                'oldpassword.required'=>'Mevcut şifrenizi girin',
                'oldpassword.min'=>'Eski şifre en az 6 karakterden oluşmalıdır',
                'oldpassword.max'=>'Eski şifre 15 karakterden uzun olmamalıdır',
                'newpassword.required'=>'Yeni şifreyi girin',
                'newpassword.min'=>'Yeni şifre en az 6 karakterden oluşmalıdır',
                'newpassword.max'=>'Yeni şifre 15 karakterden uzun olmamalıdır',
                'cnewpassword.required'=>'Yeni şifrenizi tekrar girin',
                'cnewpassword.same'=>'Yeni şifre ve Yeni şifre tekrar eşleşmelidir'
            ]);

           if(!$validator->passes() ){
               return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
           }else{
                
            $update = User::find(Auth::user()->id)->update(['password'=>\Hash::make($request->newpassword)]);

            if( !$update ){
                return response()->json(['status'=>0,'msg'=>'Bir şeyler ters gitti, db`de şifre güncellenemedi']);
            }else{
                return response()->json(['status'=>1,'msg'=>'Şifreniz başarıyla değiştirildi']);
            }
           }
       }




       function get_statics(){

            $dataPlus =  DataStatics::where('type',1)->sum('price');
            $dataMinus =  DataStatics::where('type',0)->sum('price');
            $dataResult = $dataPlus - $dataMinus;


            $plusArray = DataStatics::where('type',1)->latest('created_at')->take(5)->pluck('price')->toArray();
            $plusArrays = array_reverse($plusArray);


            $minusArray = DataStatics::where('type',0)->latest('created_at')->take(5)->pluck('price')->toArray();
            $minusArrays = array_reverse($minusArray);
           
            return Response::json(array(
                'status' => true,
                'messages' => 'asd',
                'dataPlus' =>   $dataPlus,
                'dataMinus' =>   $dataMinus,
                'dataResult' =>   $dataResult,
                'plusArray' =>   $plusArrays,
                'minusArray' =>   $minusArrays,
            ));
        }


        function about_us(){
            $aboutUs =  AboutUs::first();
            return view('dashboards.admins.pages.about_us',compact('aboutUs'));
        }

        function about_us_update(Request $request){
          
            $president_image = $request->file('president_image');
            $vice_president1_image = $request->file('vice_president1_image');
            $vice_president2_image = $request->file('vice_president2_image');
            $vice_president3_image = $request->file('vice_president3_image');
            $vice_president4_image = $request->file('vice_president4_image');
           
          

            $aboutUs =  AboutUs::first();

            if (isset($aboutUs)) {
                $aboutUs->president_name= $request->president_name;
                $aboutUs->president_cv =  $request->president_cv;
                $aboutUs->vice_president1_name =  $request->vice_president1_name;
                $aboutUs->vice_president2_name =  $request->vice_president2_name;
                $aboutUs->vice_president3_name =  $request->vice_president3_name;
                $aboutUs->vice_president4_name =  $request->vice_president4_name;
                $aboutUs->architects_company_content = $request->architects_company_content;
                $aboutUs->meta_title = $request->meta_title;
                $aboutUs->meta_desc = $request->meta_desc;
                $aboutUs->meta_keys = $request->meta_keys;
              
                if (isset($president_image)) {
                    $president_image_Name = 'sayfa-' . time() . '-' . '-' . rand(1, 999999) . '.' . $president_image->extension();
                    $president_image->storeAs('sayfa', $president_image_Name, 'public'); 
                    $aboutUs->president_image = $president_image_Name;
                }
                if (isset($vice_president1_image)) {
                    $vice_president1_image_Name = 'sayfa-' . time() . '-' . '-' . rand(1, 999999) . '.' . $vice_president1_image->extension();
                    $vice_president1_image->storeAs('sayfa', $vice_president1_image_Name, 'public'); 
                    $aboutUs->vice_president1_image = $vice_president1_image_Name;
                }
                if (isset($vice_president2_image)) {
                    $vice_president2_image_Name = 'sayfa-' . time() . '-' . '-' . rand(1, 999999) . '.' . $vice_president2_image->extension();
                    $vice_president2_image->storeAs('sayfa', $vice_president2_image_Name, 'public'); 
                    $aboutUs->vice_president2_image = $vice_president2_image_Name;
                }
                if (isset($vice_president3_image)) {
                    $vice_president3_image_Name = 'sayfa-' . time() . '-' . '-' . rand(1, 999999) . '.' . $vice_president3_image->extension();
                    $vice_president3_image->storeAs('sayfa', $vice_president3_image_Name, 'public'); 
                    $aboutUs->vice_president3_image = $vice_president3_image_Name;
                }
                if (isset($vice_president4_image)) {
                    $vice_president4_image_Name = 'sayfa-' . time() . '-' . '-' . rand(1, 999999) . '.' . $vice_president4_image->extension();
                    $vice_president4_image->storeAs('sayfa', $vice_president4_image_Name, 'public'); 
                    $aboutUs->vice_president4_image = $vice_president4_image_Name;
                }
              
    
                $aboutUs->update();
    
                if (!$aboutUs->update()) {
                    return response()->json(['status'=>0,'msg'=>'Ters giden birşeyler var']);
                }else{
                    return response()->json(['status'=>1,'msg'=>'Oda kaydı güncellendi.']);
                }
            } else {
                $aboutUs = new AboutUs();
                $aboutUs->president_name= $request->president_name;
                $aboutUs->president_cv =  $request->president_cv;
                $aboutUs->vice_president1_name =  $request->vice_president1_name;
                $aboutUs->vice_president2_name =  $request->vice_president2_name;
                $aboutUs->vice_president3_name =  $request->vice_president3_name;
                $aboutUs->vice_president4_name =  $request->vice_president4_name;
                $aboutUs->architects_company_content = $request->architects_company_content;
                $aboutUs->meta_title = $request->meta_title;
                $aboutUs->meta_desc = $request->meta_desc;
                $aboutUs->meta_keys = $request->meta_keys;
    
                if (isset($president_image)) {
                    $president_image_Name = 'sayfa-' . time() . '-' . '-' . rand(1, 999999) . '.' . $president_image->extension();
                    $president_image->storeAs('sayfa', $president_image_Name, 'public'); 
                    $aboutUs->president_image = $president_image_Name;
                }
                if (isset($vice_president1_image)) {
                    $vice_president1_image_Name = 'sayfa-' . time() . '-' . '-' . rand(1, 999999) . '.' . $vice_president1_image->extension();
                    $vice_president1_image->storeAs('sayfa', $vice_president1_image_Name, 'public'); 
                    $aboutUs->vice_president1_image = $vice_president1_image_Name;
                }
                if (isset($vice_president2_image)) {
                    $vice_president2_image_Name = 'sayfa-' . time() . '-' . '-' . rand(1, 999999) . '.' . $vice_president2_image->extension();
                    $vice_president2_image->storeAs('sayfa', $vice_president2_image_Name, 'public'); 
                    $aboutUs->vice_president2_image = $vice_president2_image_Name;
                }
                if (isset($vice_president3_image)) {
                    $vice_president3_image_Name = 'sayfa-' . time() . '-' . '-' . rand(1, 999999) . '.' . $vice_president3_image->extension();
                    $vice_president3_image->storeAs('sayfa', $vice_president3_image_Name, 'public'); 
                    $aboutUs->vice_president3_image = $vice_president3_image_Name;
                }
                if (isset($vice_president4_image)) {
                    $vice_president4_image_Name = 'sayfa-' . time() . '-' . '-' . rand(1, 999999) . '.' . $vice_president4_image->extension();
                    $vice_president4_image->storeAs('sayfa', $vice_president4_image_Name, 'public'); 
                    $aboutUs->vice_president4_image = $vice_president4_image_Name;
                }
    
                if (!$aboutUs->save()) {
                    return response()->json(['status'=>0,'msg'=>'Ters giden birşeyler var']);
                }else{
                    return response()->json(['status'=>1,'msg'=>'Oda kaydı güncellendi.']);
                }
            }

            if (!$aboutUs->update()) {
                return response()->json(['status'=>0,'msg'=>'Ters giden birşeyler var']);
            }else{
                return response()->json(['status'=>1,'msg'=>'Biz kimiz güncellendi.']);
            }
         
        }

        function room_register(){
            $roomRegister =  RoomRegister::first();
            return view('dashboards.admins.pages.room_register',compact('roomRegister'));
        }

        function room_register_update(Request $request){
            $financial_advisor_image = $request->file('financial_advisor_image');
            $room_register_file = $request->file('room_register_file');

            $roomRegister =  RoomRegister::first();

            if (isset($roomRegister)) {
                $roomRegister->content = $request->content;
                $roomRegister->financial_advisor_map = $request->financial_advisor_map;
                $roomRegister->meta_title = $request->meta_title;
                $roomRegister->meta_desc = $request->meta_desc;
                $roomRegister->meta_keys = $request->meta_keys;
              
                if (isset($financial_advisor_image)) {
                    $financial_advisor_Name = 'sayfa-' . time() . '-' . '-' . rand(1, 999999) . '.' . $financial_advisor_image->extension();
                    $financial_advisor_image->storeAs('sayfa', $financial_advisor_Name, 'public'); 
                    $roomRegister->financial_advisor_image = $financial_advisor_Name;
                }

                if (isset($room_register_file)) {
                    $room_register_file_Name = 'sayfa-' . time() . '-' . '-' . rand(1, 999999) . '.' . $room_register_file->extension();
                    $room_register_file->storeAs('sayfa', $room_register_file_Name, 'public'); 
                    $roomRegister->room_register_file =  $room_register_file_Name;
                }
             
    
                $roomRegister->update();
    
                if (!$roomRegister->update()) {
                    return response()->json(['status'=>0,'msg'=>'Ters giden birşeyler var']);
                }else{
                    return response()->json(['status'=>1,'msg'=>'Oda kaydı güncellendi.']);
                }
            } else {
                $roomRegister = new RoomRegister();
                $roomRegister->content = $request->content;
                $roomRegister->financial_advisor_map = $request->financial_advisor_map;
                $roomRegister->meta_title = $request->meta_title;
                $roomRegister->meta_desc = $request->meta_desc;
                $roomRegister->meta_keys = $request->meta_keys;
    
                if (isset($financial_advisor_image)) {
                    $financial_advisor_Name = 'sayfa-' . time() . '-' . '-' . rand(1, 999999) . '.' . $financial_advisor_image->extension();
                    $financial_advisor_image->storeAs('sayfa', $financial_advisor_Name, 'public'); 
                    $roomRegister->financial_advisor_image = $financial_advisor_Name;
                }

                if (isset($room_register_file)) {
                    $room_register_file_Name = 'sayfa-' . time() . '-' . '-' . rand(1, 999999) . '.' . $room_register_file->extension();
                    $room_register_file->storeAs('sayfa', $room_register_file_Name, 'public'); 
                    $roomRegister->room_register_file =  $room_register_file_Name;
                }
    
                if (!$roomRegister->save()) {
                    return response()->json(['status'=>0,'msg'=>'Ters giden birşeyler var']);
                }else{
                    return response()->json(['status'=>1,'msg'=>'Oda kaydı güncellendi.']);
                }
            }
        }


        
        
        function room_register_file_delete(){
            $roomRegister =  RoomRegister::first();
            $roomRegister->room_register_file = null;
            $roomRegister->update();
            if (!$roomRegister->update()) {
                return response()->json(['status'=>0,'msg'=>'Ters giden birşeyler var']);
            }else{
                return response()->json(['status'=>1,'msg'=>'Biz kimiz güncellendi.']);
            }
         
        }


        function getNotification(){

            $notificaitonWorkflow =  Notificaiton::where('workflow',0)->count();
            $notificaitonTopics =  Notificaiton::where('topics',0)->count();
            $notificaitonReceipts =  Notificaiton::where('receipts',0)->count();
      
            return response()->json(['status'=>1,'is_akisi'=>$notificaitonWorkflow,'konu'=> $notificaitonTopics ,'dekont'=> $notificaitonReceipts ]);
       }
        
       function refreshNotification(){
           Notificaiton::where('workflow',0)->update(['workflow' => 1]);
           Notificaiton::where('topics',0)->update(['topics' => 1]);
           Notificaiton::where('receipts',0)->update(['receipts'=>1]);
       }





}
