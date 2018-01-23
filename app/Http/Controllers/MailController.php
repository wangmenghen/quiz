<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Mail;

class MailController extends Controller
{
    public function send()
    {
        $name = 'linxiaosi';
        $flag = Mail::send('emails.test',['name'=>$name],function($message){
            $to = 'dunniang3@163.com';
            $message ->to($to)->subject('测试邮件');
        });
        if($flag){
            echo '发送邮件成功，请查收！';
        }else{
            echo '发送邮件失败，请重试！';
        }
    }
}