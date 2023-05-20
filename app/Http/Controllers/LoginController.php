<?php
namespace App\Http\Controllers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class LoginController extends Controller
{
    //google
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback(){
    
        try {
            //code...
            $usergoogle = Socialite::driver('google')->user();
            $user = User::where('email',$usergoogle->getEmail())->first();
            $type = 3;
            if(!$user){
                $new_user = User::create([
                    'name'=> $usergoogle->getName(),
                    'email'=>$usergoogle->getEmail(),
                    'id_login'=>$usergoogle->getId(),
                    'username'=>$usergoogle->getNickname(),
                    'picture' =>$usergoogle->getAvatar(),
                    'type' => $type,
                ]);
                session()->put('user', [
                    'id'=> $new_user->id,
                    'name' => $new_user->name,
                    'username' => $new_user->username,
                    'email' => $new_user->email,
                    'biography' => $new_user->biography
                ]);
                session()->put('login_success', true);
            
                return redirect()->route('home');
                
                
            }else{
                if($user->login_id != null){
                    session()->put('user', [
                        'id'=> $user->id,
                        'name' => $usergoogle->name,
                        'username' => $usergoogle->username,
                        'email' => $usergoogle->email,
                        'biography' => $usergoogle->biography
                    ]);
                    session()->put('login_success', true);
                    return  redirect('/');
                }else{
                    $user->update([
                        'login_id'=>$usergoogle->getId(), 
                    ]);
                    session()->put('user', [
                        'id'=> $user->id,
                        'name' => $usergoogle->name,
                        'username' => $usergoogle->username,
                        'email' => $usergoogle->email,
                        'biography' => $usergoogle->biography
                    ]);
                    session()->put('login_success', true);
                    return  redirect('/');
                }
                
            }
        } catch (\Throwable $th) {
           session()->flash('fail', 'Email hoặc mật không chính xác');
        }
    }


    // facebook
    public function redirectToFacebook(){
        return Socialite::driver('facebook')->redirect();
    }
    public function handleFacebookCallback(){
        $user = Socialite::driver('facebook')->user();
        dd($user);
    }
}
