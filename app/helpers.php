<?php
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Input;

function rewriteRoute($url,$institutionSlug=null)
{

  if(strpos($_SERVER['HTTP_HOST'], "abc.com")  !== false)
  {
    if($institutionSlug)
    {
      return $url;
    }
    else
    {
     
      $string = explode("abc.com",$url);

      if($string[0] == "https://" || $string[0] == "http://" ||  $string[0] == "http://www." ||  $string[0] == "https://www.")
      {
        return $url;
      }
      else
      {
        $string = explode("//",$string[0]);
        if(strpos($string[1],'www.') !== false)
        {
          $string =  explode(".",$string[1]);
          $slug = $string[1];
          return $url = str_replace($slug.".","www.",$url) ;
        }
        else
        {
          $slug = $string[1];
          return $url = str_replace($slug,"www.",$url) ;
        }
      }
      
    }

  }
  else
  {
    return $url;
  }
}
