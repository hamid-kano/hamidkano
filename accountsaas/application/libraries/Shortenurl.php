<?php

// Declare the class
class Shortenurl
{

    // Constructor
    function __construct()
    {
        $this->key = '';
    }

    function setkey($key)
    {

        $this->key = $key;
    }

    // Shorten a URL
    function shorten($url)
    {
        // Send information along
        $url_c= $url;

        $params=array('access_token'=>$this->key,'longUrl'=>$url_c);

        $url = 'https://api-ssl.bit.ly/v3/user/link_save?'. http_build_query($params);


        $result = json_decode($this->bitly_get_curl($url), true);

      if(isset($result['data']['link_save']['link'])){
        return (string)$result['data']['link_save']['link'];
      } else{
        return "";
      } 

        
    }



    function bitly_get_curl($uri) {
        $output = "";
        try {
            $ch = curl_init($uri);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 4);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            $output = curl_exec($ch);
        } catch (Exception $e) {
        }
        return $output;
    }

}