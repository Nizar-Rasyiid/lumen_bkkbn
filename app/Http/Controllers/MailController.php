<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\IuranTetapMail;
use App\Mail\EvaluatorMail;

use App\User;

class MailController extends Controller
{
    public function sendmail()
    {
        $user = User::where('email', 'andhika@mail.com')->first();
        // Mail::send(new IuranTetapMail(), [], function($message) {
        //   $message->to('andhika.ragilkesuma@gmail.com');
        //   $message->subject('Test Email dari Laravel EPNBP');
        // });

        Mail::to("andhika.ragilkesuma@gmail.com")->send(new IuranTetapMail($user));

        // if (Mail::failures()) {
    //      return response()->Fail('Sorry! Please try again latter');
    // } else {
    //      return response()->success('Great! Successfully send in your mail');
    // }

    // Mail::send('syarat_ketentuan_modal', [], function($message) {
    //     $message->to('andhika.ragilkesuma@gmail.com');
    //     $message->subject('Test Email dari Laravel EPNBP');
    // });
    }
}
