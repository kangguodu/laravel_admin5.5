<?php
//header('Access-Control-Allow-Origin: http://www.baidu.com'); //设置http://www.baidu.com允许跨域访问
//header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); //设置允许的跨域header
date_default_timezone_set("Asia/chongqing");
error_reporting(E_ERROR);
header("Content-Type: text/html; charset=utf-8");

$CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents("config.json")), true);
$action = $_GET['action'];

switch ($action) {
    case 'config':
        $result =  json_encode($CONFIG);
        break;

    /* 上传图片 */
    case 'uploadimage':
    /* 上传涂鸦 */
    case 'uploadscrawl':
    /* 上传视频 */
    case 'uploadvideo':
    /* 上传文件 */
    case 'uploadfile':
        $result = include("action_upload.php");
        break;

    /* 列出图片 */
    case 'listimage':
        $result = include("action_list.php");
        break;
    /* 列出文件 */
    case 'listfile':
        $result = include("action_list.php");
        break;

    /* 抓取远程文件 */
    case 'catchimage':
        $result = include("action_crawler.php");
        break;

    default:
        $result = json_encode(array(
            'state'=> '请求地址出错'
        ));
        break;
}

/* 输出结果 */
if (isset($_GET["callback"])) {
    if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
        echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
    } else {
        echo json_encode(array(
            'state'=> 'callback参数不合法'
        ));
    }
} else {
  $resArr = json_decode($result,true);
  if (empty($resArr['url'])) {
    foreach ($resArr['list'] as &$res) {
      $path = $_SERVER['DOCUMENT_ROOT'].$res['url'];
      $url = 'http://office.techrare.com:5681/wopinapi/public/api/image/onlyuploadimage';
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true);
      $data = array('file' => new \CURLFile(realpath($path),'',$res['title']),'dir'=>'other');
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_POST, 1 );
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($curl, CURLOPT_USERAGENT,"TEST");
      $response = curl_exec($curl);
      $error = curl_error($curl);
      $data = json_decode($response,true);
      unlink($path);
      if (!empty($data['data']['image'])) {
        $res['url'] = $data['data']['image'];
        unlink($path);
      }else {
        header('HTTP/1.1 403 Forbidden');
        die;
      }
    }
  }else {
    $path = $_SERVER['DOCUMENT_ROOT'].$resArr['url'];
    $url = 'http://office.techrare.com:5681/wopinapi/public/api/image/onlyuploadimage';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true);
    $data = array('file' => new \CURLFile(realpath($path),'',$res['title']),'dir'=>'other');
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1 );
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_USERAGENT,"TEST");
    $response = curl_exec($curl);
    $error = curl_error($curl);
    $data = json_decode($response,true);
    unlink($path);
    rmdir($_SERVER['DOCUMENT_ROOT'].'/ueditor/php');
    $resArr['url'] = $data['data']['image'];
  }
  $result = json_encode($resArr);
    echo $result;
}
