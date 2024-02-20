<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Models\User;
use App\Models\Media;
use App\Models\Workflow;
use App\Models\Receipts;
use App\Models\Topics;
use App\Models\Notificaiton;

class UserController extends Controller
{
     
        function data_statics(){
           
  
            $dataWorkflow =  Workflow::where('author',Auth::user()->id)->count();
            $dataReceipts =  Receipts::where('author',Auth::user()->id)->count();
            $dataTopics =  Topics::where('author',Auth::user()->id)->count();
    
            return view('dashboards.users.index',compact('dataWorkflow','dataReceipts','dataTopics'));
        }
        
    
       function profile(){
           return view('dashboards.users.profile');
       }

       function settings(){
           return view('dashboards.users.settings');
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
            $file = $request->file('user_image');
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

            if( !$validator->passes() ){
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



        public function mediaDelete(Request $request)
        {
            $media = Media::find($request->media_id);
            if ($media->delete()) {
                return response()->json(['status'=>1,'msg'=>'Silme işlemi başarılı']);
            } else {
                return response()->json(['status'=>0,'msg'=>'Silme işlemi olurken bir hata meydana geldi.']);
            }
        }


        function addNotificationWorkflow(){
                $notificaiton = new Notificaiton();
                $notificaiton->workflow = 0;
                $notificaiton->receipts = 1;
                $notificaiton->topics = 1;
                $notificaiton->save();
        }

        function addNotificationReceipts(){

                $notificaiton = new Notificaiton();
                $notificaiton->workflow = 1;
                $notificaiton->receipts = 0;
                $notificaiton->topics = 1;
                $notificaiton->save();
           
        }

        function addNotificationTopics(){

                $notificaiton = new Notificaiton();
                $notificaiton->workflow = 1;
                $notificaiton->receipts = 1;
                $notificaiton->topics = 0;
                $notificaiton->save();
           
        }

}
