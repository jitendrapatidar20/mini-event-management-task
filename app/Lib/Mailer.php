<?php
namespace App\Lib;
use Illuminate\Support\Facades\Mail;
// use App\Mail\RegistrationMail;
use App\Mail\ForgotMail;
use App\Mail\TemplateMail;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Log;
class Mailer
{
    
    public static function send($email,$class){
        try{
            
           $st = Mail::to($email)->send($class);
          
         }
         catch(\Exception $e){
            //dd($e);
             return false;
         }
    }
    public static function sendMailTempalte($email,$name,$arr,$attachment=null){
        $template=EmailTemplate::whereTitle($name); 
        if($template->count()){
            $data= $template->first();
            foreach($arr as $key=>$val){
                
                $data->description  =   str_replace($key,$val,$data->description);
                $data->subject  =   str_replace($key,$val,$data->subject);
                  
            }
            return   self::send($email,new TemplateMail($data->subject,  nl2br($data->description),$attachment));
        }
        return false;
    }
    public static function emailConfirmation($name,$url,$email){
        $arr=[
            "{{LINK}}"=>$url,
            "{{NAME}}"=>$name,

        ];
       return  self::sendMailTempalte($email,"EMAIL-CONFIRMATION",$arr);
        
    }
    public static function forgot($name,$url,$email)
    {
        $arr=[
           "{{LINK}}"=>$url,
           "{{NAME}}"=>$name,
       ];
        return  self::sendMailTempalte($email,"FORGOT-PASSWORD",$arr);
    }

    public static function setpassword($User,$url)
    {
       $arr=[
           "{{LINK}}"=>$url,
           "{{NAME}}"=>$User->institutionGeneralDetail->applicant_name,
       ];
       return  self::sendMailTempalte($User->email,"SET-INSTITUTION-PASSWORD",$arr); 
   }
   public static function otp($name,$otp,$expiry_time,$email){
    $arr=[
       "{{NAME}}"=>$name,
       "{{OTP}}"=>$otp,
       "{{EXPIRY_TIME}}" =>$expiry_time
   ];
  return  self::sendMailTempalte($email,"OTP-VERIFY",$arr);
  
}
       
      
     
}