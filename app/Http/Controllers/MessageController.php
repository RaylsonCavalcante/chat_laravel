<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\User;

class MessageController extends Controller
{
    //Send Message
    public function sendMessage(Request $req){

        $message = new Message();

        $message->message = $req->message;
        $message->user_id = Auth::id();
        $message->for = $req->user_id;
        $message->read = 1;
        $message->new = 1;

        $message->save();

    }

    //Show Messages
    public function showMessages(Request $req){

        $user = Auth::user();

        $message = Message::all();

        $output = '';
                    
        $out = '';
        $msg_empty = 0;
        foreach ($message as $messages) {
            
            if($messages->user_id == $user->id && $messages->for == $req->user_id){
                $out .= '
                    <div class="d-flex flex-row justify-content-start">
                      <img src="/img/profile/'.$user->photo.'"
                        alt="avatar 1" style="width: 45px; height: 100%;" class="rounded-circle">
                      <div>
                        <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">'.$messages->message.'</p>
                        <p class="small ms-3 mb-3 rounded-3 text-muted float-end">'.$messages->created_at->format('H:i A | d/m').'</p>
                      </div>
                    </div>';
                    $msg_empty = $msg_empty + 1;
            }else{

                if($messages->user_id == $req->user_id && $messages->for == $user->id){

                $for_user = User::find($req->user_id);
                $out .= '
                    <div class="d-flex flex-row justify-content-end">
                      <div>
                        <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">'.$messages->message.'</p>
                        <p class="small me-3 mb-3 rounded-3 text-muted">'.$messages->created_at->format('H:i A | d/m').'</p>
                      </div>
                      <img src="/img/profile/'.$for_user->photo.'"
                        alt="avatar 1" style="width: 45px; height: 100%;" class="rounded-circle">
                    </div>';
                    $msg_empty = $msg_empty + 1;
                }
            }

        }

        if (!$msg_empty > 0) {
            $output .= '<center>
                            <div class="col-md-6 col-lg-7 col-xl-8" style="margin-top: 12%;">
                              <div style="color: #508bfc;">
                                <center>
                                <i class="far fa-comments fa-9x" style="margin-right: 7px;"></i><br>
                                <span style="font-style: oblique;">Nenhuma mensagem!</span>
                                </center>
                              </div>
                            </div>
                        </center>';
        }else{
            $output .= ''.$out.'';
        }

        return $output;

    }

    //Check New Message
    public function newMessage(){
        
        $message = Message::where('new', 1)->first();

        if ($message) {
         
            $var = 1;

            $arr = [$var];

            echo json_encode($arr);
        }else{

            $var = 0;

            $arr = [$var];

            echo json_encode($arr);
        }

    }

    //Update Refresh
    public function updateRefresh(){
        
        $message = Message::where('new', 1)->get();

        if (count($message) > 0) {

            foreach ($message as $messages) {
                $messages->new = 0;
                
            }

            $messages->update();
        }

    }

    //Read Message
    public function readMessage(Request $req){
        
        $user = Auth::user();

        $message = Message::all();

        if (count($message) > 0) {

            foreach ($message as $messages) {
                
                if($messages->user_id == $req->user_id && $messages->for == $user->id){
                    if($messages->read == 1){
                        $messages->read = 0;
                        $messages->update();
                        $var = 1;
                    }
                }
            }

            $arr = [$var];

            echo json_encode($arr);
        }

    }

}