<?php

namespace App;


class UploadImageAPI
{
    //
    static function upload($file,$type)
    {
        $realPath = realpath($file['tmp_name']);
        $mime = ['image/jpeg','image/jpg','image/png','image/gif'];
        if (!in_array($file['type'],$mime)) {
            return;
        }
        $url = 'http://office.techrare.com:5681/wopinapi/public/api/image/onlyuploadimage';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true);
        $data = array('file' => new \CURLFile($realPath,$file['name']),'dir'=>$type);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1 );
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);
        $arr = json_decode($result,true);
        if ($arr['success']) {
            return $arr['data']['image'];
        }
    }
}
