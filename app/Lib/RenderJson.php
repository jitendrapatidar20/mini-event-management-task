<?php
namespace App\Lib;

class RenderJson
{
  public static function send($status,$errorCode=200,$data=[],$message=""){

    if($status){
      $message = !empty($message)?$message:"Success";
      return response()->json(['status'=>$status,'message'=>$message,'data' => $data]);
    }
    else
    {
        $message = !empty($message)?$message:"Error";
        return response()->json(['status'=>$status,'message'=>$message,'error'=>$data],$errorCode);
    }
  }

}