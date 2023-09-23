<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Message;

class LoginController extends Controller
{   

    //Home
    public function home(){
        return view('/home');
    }

    //Login Screen
    public function loginScreen(){

        if(Auth::check()){
            return redirect()->back();
        }else{
            return view('auth/login');
        }
    }

    //Login
    public function login(Request $req)
    {   

        $credenciais = [
            'email' => $req->email,
            'password' => $req->password
        ];
        
        if (Auth::attempt($credenciais)) {

            $user = User::where('email', $req->email)->first();
            
            $var = 1;
            $id = $user->id;

            $arr = [$var,$id];

            echo json_encode($arr); //Se não funcionar esse método
                                    //Use esse abaixo
                                    //return response()->json($arr);

            //Mudar status para Online
            $user->status = 1;
            $user->update();
        }else{
            $var = 0;

            $arr = [$var];

            echo json_encode($arr);

        }
    }

    //Register
    public function register(Request $req)
    {
        $queryUser = User::where('email',$req->email)->first();

        if ($queryUser) {
            $var = 0;

            $arr = [$var];

            echo json_encode($arr);
        }else{


            $user = new User;

            $pass_crypt = bcrypt($req->pass);

            $user->name = $req->name;
            $user->email = $req->email;
            $user->password = $pass_crypt;
            $user->email_verified_at = now();
            $user->status = 0;
            $user->remember_token = Str::random(40);

            if ($req->hasFile('fileProfile') && $req->file('fileProfile')->isValid()) {
                
                $reqImage = $req->fileProfile;

                $extension = $reqImage->extension();

                $imageName = md5($reqImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

                $reqImage->move(public_path('img/profile'), $imageName);

                $user->photo = $imageName;
            }

            $user->save();

            $var = 1;

            $arr = [$var];

            echo json_encode($arr);
        }
    }

    //Logout
    public function logout(){
        //Mudar status para Online

        $user = Auth::user();
        $user->status = 0;
        if($user->update()){
            auth()->logout();
        }
        return redirect('/');
    }

    //Data User
    public function dataUser(){

        $user = Auth::user();

        $arr = [
            $user->photo,
            $user->name,
            $user->email,
        ];

        echo json_encode($arr);
    }

    //Update User
    public function updateUser(Request $req)
    {   
        $user = Auth::user();

        $user->name = $req->name;
        $user->email = $req->email;

        //Photo Upload
        if ($req->hasFile('photo') && $req->file('photo')->isValid()) {

            if($user->photo){
                unlink("img/profile/".$user->photo);
            }
            
            $reqImage = $req->photo;

            $extension = $reqImage->extension();

            $imageName = md5($reqImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $reqImage->move(public_path('img/profile'), $imageName);

            $user->photo = $imageName;
        }

        $user->update();

        $var = 1;

        $arr = [$var];

        echo json_encode($arr);

    }

    //Show Users
    public function showUsers(){

        $user = User::orderBy('name')->get();

        $message = Message::all();

        $output = '';

        if(count($user) > 0){

            foreach ($user as $users) {

                if ($users->id != Auth::id()) {
                
                $output .= '
                        <li class="p-2 border-bottom li-bg" id="selected_'.$users->id.'" style="border-radius: 3px;">
                          <a onclick="showScreenMessages('.$users->id.')" style="cursor: pointer;" class="d-flex justify-content-between">
                            <div class="d-flex flex-row">
                              <div>
                                <img
                                  src="/img/profile/'.$users->photo.'"
                                  alt="avatar" class="d-flex align-self-center me-3 rounded-circle" width="60">';
                            if ($users->status == 1) {
                                $output .= '<span class="badge bg-success badge-dot" ></span>';
                            }else{
                                $output .= '<span class="badge bg-secondary badge-dot" ></span>';
                            }
                              $output .= '</div>
                              <div class="pt-1">
                                <p class="fw-bold mb-0">'.$users->name.'</p>';

                            $count = 0;
                            $msg_empty = 0;
                            foreach($message as $messages){
                                if($messages->user_id == Auth::id() && $messages->for == $users->id || $messages->user_id == $users->id && $messages->for == Auth::id()){
                                    $msg = $messages->message;
                                    if ($messages->for == Auth::id() && $messages->read == 1) {
                                        $count = $count+1;
                                    }
                                    $msg_empty = $msg_empty + 1;
                                }
                            }

                            if ($msg_empty > 0) {
                            $output .= '
                                <p class="small text-muted text-long">'.$msg.'</p>
                              </div>
                            </div>
                            <div class="pt-1">';
                            }else{
                            $output .= '
                                <p class="small text-muted text-long">Nenhuma mensagem</p>
                              </div>
                            </div>
                            <div class="pt-1">';
                            }
                            
                            if ($count > 0) {
                                $output .= '
                                <span class="badge bg-danger rounded-pill float-end">'.$count.'</span>';
                            }else{
                                $output .= '
                                <span class="badge bg-danger rounded-pill float-end"></span>';
                            }

                            $output .= '
                            </div>
                          </a>
                        </li>';
                }
            }

        }else{
            $output .= ' <li class="p-2 border-bottom">
                                <p class="text-muted mb-0">Nenhuma conversa!</p>
                        </li>';
        }

        return $output;

    }
}
