<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function send_message(Request $request,User $user)
    {
      $request->validate([
         'message'=>['required','max:500','min:2']
      ]);
      Message::create([
         'sender'=>auth()->id(),
         'receiver'=>$user->id,
         'message'=>$request->message
      ]);
      return back();
    }
}
