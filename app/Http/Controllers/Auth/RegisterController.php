<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    // protected function create(array $data)
    // {
    //     return User::create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'role'=>2,
    //         'favoriteColor'=>$data['favoriteColor'],
    //         'password' => Hash::make($data['password']),
    //     ]);
    // }

    function register(Request $request){
      
         $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6','max:15', 'confirmed'],
            'identity_no' => ['required', 'string', 'min:11','max:11','unique:users' ],
            'iban_no' => ['required', 'string', 'min:16','unique:users'],
            'tax_no' => ['required', 'string', 'min:4','max:20', 'unique:users'],
            'username' => ['required', 'string', 'min:4','max:12', 'unique:users'],
         ],
         [
            'email.unique'=>'Bu eposta kayıtlarda zaten var',
            'username.unique'=>'Bu kullanıcı adı zaten alınmış',
            'identity_no.unique'=>'Bu tc no zaten kayıtlarda var',
            'iban_no.unique'=>'Bu iban no zaten kayıtlarda var',
            'tax_no.unique'=>'Bu vergi no zaten kayıtlarda var',
            'password.confirmed'=>'Şifre ve şifre tekrar uyuşmuyor',
        ]);

  
        

     
     
            $path = 'users/images/';
            $fontPath = public_path('fonts/Oliciy.ttf');
           
            $char = strtoupper($request->name[0]);
            $newAvatarName = rand(12,34353).time().'_avatar.png';
            $dest = $path.$newAvatarName;
         
            $createAvatar = makeAvatar($fontPath,$dest,$char);
            $picture = $createAvatar == true ? $newAvatarName : '';
   
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->identity_no = $request->identity_no;
            $user->tax_no = $request->tax_no;
            $user->iban_no = $request->iban_no;
            $user->username = $request->username;
            $user->role = 2;
            $user->picture = $picture;
            $user->password = \Hash::make($request->password);
   
            if( $user->save() ){
   
               return redirect()->back()->with('success','Tebrikler başarıyla kaydoldunuz. Yönetici onayladıktan sonra giriş yapabilirsiniz');
            }else{
                return redirect()->back()->with('error','Kayıt başarısız');
            }
       

    }


}
