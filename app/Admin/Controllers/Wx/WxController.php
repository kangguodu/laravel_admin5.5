<?php

namespace App\Admin\Controllers\Wx;

use App\Goods;use App\Malls;use App\GoodsSku;
use App\Admin\Repositories\Platform\CategoryRepositories;
use App\Category;use App\StapleInfo;
use App\Http\Controllers\Controller;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Facades\Admin;use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;use DB;
use Encore\Admin\Widgets\Table;use Illuminate\Http\Response;
use Encore\Admin\Widgets\Form;use Illuminate\Http\Request;
use Encore\Admin\Widgets\Alert;

class WxController extends Controller
{
    //
    private $finalDir = './images/syn/';
    private $width = 720;
    private $keyDir='./images/wxkey/';
    private $vicePre='vice';
    private $viceDir = './images/wxvice/';
    private $splitNum=9;


    public function index()
    {
        return Admin::content(function ($content) {
            $content->header('微信圖片合成');
            $content->description('朋友圈圖片生成');


                $content->row(function ($row){
                    $form = new Form();
                    $form->action(url('wx/synimg'));
                    $form->disablePjax();
                    $options = [9=>'九宮格',6=>'六宮格',];
                    $form->select('splitNum','樣式選擇')->options($options)->default(9);
                    $form->file('keyImage','顯示主圖')->attribute(['accept'=>'image/*'])
                        ->help('支持圖片格式：JPG,JPEG,PNG');
                    $form->multipleFile('viceImage','附圖')->attribute(['accept'=>'image/*','multiple'=>'multiple',])
                        ->help('支持圖片格式：JPG,JPEG,PNG,請上傳雙倍數量的圖片！為保證展示效果，圖片尺寸請統一');
                    $row->Column(12,new Box('宮格圖片',$form));
            });
        });
    }

    public function store()
    {
        if (!is_dir($this->finalDir))               //生成圖片路徑不存在則創建路徑
            mkdir($this->finalDir,0777,true);

        $this->splitNum = $splitNum = empty($_POST['splitNum'])?9:$_POST['splitNum'];         //主圖分成幾份？默認為9

        $pc = new SplitImg;             //將主圖分成6份或9份
        $pc->setPath($_FILES['keyImage'],$splitNum,$this->keyDir);
        $pc->split();                   //完成切圖，保留在wx/key中    $dir.'key-'.$j.$i.'.jpeg';

        $vice = new FormatViceImg;          //對附圖進行格式統一     $dir.$this->pre.$i.'.jpeg';
        $formatHeight = $vice->filePath($_FILES['viceImage'],$this->vicePre,$this->viceDir);

        $viceNum = count($_FILES['viceImage']['tmp_name']);
//        if ($viceNum==1&&$_FILES['viceImage']['tmp_name'][0]==0)
//            return 'Bad Request!';
        $numPerImg = (int)($viceNum/$splitNum/2);      //每張圖片附圖2倍該值
        $vice = (int)$viceNum/2;
        $additionNum = (int)$vice%$splitNum;         //多出兩張圖片的處理數量
//        echo $numPerImg;echo $additionNum;die;
        if ($splitNum==6){

        }elseif ($splitNum==9){
            $this->syn9($numPerImg,$additionNum,$formatHeight);
        }
        $this->zipImage();
    }
    //九宮格處理
    private function syn9($numPerImg,$additionNum,$formatHeight)
    {
        $width = $this->width;$viceDir = $this->viceDir;$vicePre = $this->vicePre;
        $keyDir = $this->keyDir;
        $viceKey = 0;                //附圖key鍵值

        for ($i=0;$i<3;$i++){
            for ($j=0;$j<3;$j++){
                if ((3*$i+$j)<$additionNum){
                    $height = $formatHeight*($numPerImg+1)*2+$width;
                    $out = imagecreatetruecolor($width,$height);
                    $white = imagecolorallocate($out,255,255,255);
                    imagefill($out,0,0,$white);

                    for ($k=0;$k<($numPerImg+1);$k++){
                        $filename = $viceDir.$vicePre.$viceKey.'.jpeg';$viceKey++;
                        $img = imagecreatefromjpeg($filename);
                        imagecopy($out,$img,0,$k*$formatHeight,0,0,$width,$formatHeight);
                        imagedestroy($img);
                        $filename = $viceDir.$vicePre.$viceKey.'.jpeg';$viceKey++;
                        $img = imagecreatefromjpeg($filename);
                        imagecopy($out,$img,0,$height-($k+1)*$formatHeight,0,0,$width,$formatHeight);
                        imagedestroy($img);
                    }
                    $keyFilename = $keyDir.'key-'.$i.$j.'.jpeg';
                    $img = imagecreatefromjpeg($keyFilename);
                    imagecopy($out,$img,0,$k*$formatHeight,0,0,$width,$width);
                    imagedestroy($img);
                }else{
                    $height = $formatHeight*$numPerImg*2+$width;
                    $out = imagecreatetruecolor($width,$height);
                    $white = imagecolorallocate($out,255,255,255);
                    imagefill($out,0,0,$white);
                    for ($k=0;$k<$numPerImg;$k++){
                        $filename = $viceDir.$vicePre.$viceKey.'.jpeg';$viceKey++;
                        $img = imagecreatefromjpeg($filename);
                        imagecopy($out,$img,0,$k*$formatHeight,0,0,$width,$formatHeight);
                        imagedestroy($img);
                        $filename = $viceDir.$vicePre.$viceKey.'.jpeg';$viceKey++;
                        $img = imagecreatefromjpeg($filename);
                        imagecopy($out,$img,0,$height-($k+1)*$formatHeight,0,0,$width,$formatHeight);
                        imagedestroy($img);
                    }
                    $keyFilename = $keyDir.'key-'.$i.$j.'.jpeg';
                    $img = imagecreatefromjpeg($keyFilename);
                    imagecopy($out,$img,0,$k*$formatHeight,0,0,$width,$width);
                    imagedestroy($img);
                }
                imagejpeg($out,$this->finalDir.$i.$j.'.jpeg');
                imagedestroy($out);
            }
        }
    }

    private function zipImage()
    {
        $dfile = tempnam('/tmp', 'tmp');//产生一个临时文件，用于缓存下载文件
        $zip = new zipfile();
        $filename = 'image.zip'; //下载的默认文件名

        $zip->add_path(realpath($this->finalDir));
          // 或是想打包整个目录 用 $zip->add_path($image_path);

        $zip->output($dfile);

// 下载文件
        ob_clean();
        header('Pragma: public');
        header('Last-Modified:'.gmdate('D, d M Y H:i:s') . 'GMT');
        header('Cache-Control:no-store, no-cache, must-revalidate');
        header('Cache-Control:pre-check=0, post-check=0, max-age=0');
        header('Content-Transfer-Encoding:binary');
        header('Content-Encoding:none');
        header('Content-type:multipart/form-data');
        header('Content-Disposition:attachment; filename="'.$filename.'"'); //设置下载的默认文件名
        header('Content-length:'. filesize($dfile));
        $fp = fopen($dfile, 'r');
        while(connection_status() == 0 && $buf = @fread($fp, 8192)){
            echo $buf;
        }
        fclose($fp); @unlink($dfile); @flush(); @ob_flush();$this->unlinkDir('./images');exit;
    }

    private function unlinkDir($dir)
    {
        if (!is_dir($dir))
            return;
        $dirRes = opendir($dir);
        while ($file = readdir($dirRes)){
            if ($file=='.'||$file=='..') {
                continue;
            }
            if (is_dir($dir.'/'.$file)){
                $this->unlinkDir($dir.'/'.$file);
                continue;
            }
            unlink($dir.'/'.$file);
        }
        rmdir($dir);
        closedir($dirRes);
    }
}

class FormatViceImg
{
    private $pre='';
    private $opWidth = 720;
//    private $opHeight = 360;
    private $imgNum;
    private $opHeight=720;
    public function filePath($files,$pre,$dir='./images/wxvice/')
    {
        $this->pre = $pre;
        $this->imgNum = $viceNum = count($files['tmp_name']);
        if ($viceNum<=1)
            return;

        $key = array_keys($files);
        for ($i=0;$i<$viceNum;$i++){
            foreach ($key as $value){
                $file[$i][$value] = $files[$value][$i];
            }
            $size[$i] = getimagesize($file[$i]['tmp_name']);
        }
        $this->getOpHeight($size);
        $this->opImage($file,$size,$dir);
        return $this->opHeight;
    }

    private function opImage($files,$sizes,$dir)
    {
        if (!is_dir($dir))
            mkdir($dir,0777,true);
        for ($i=0;$i<$this->imgNum;$i++){
            $filename = $dir.$this->pre.$i.'.jpeg';
            $file = $files[$i];
            $size = $sizes[$i];
            $devHeight = $this->devHeight($size);

            $out = imagecreatetruecolor($this->opWidth,$this->opHeight);
            $white = imagecolorallocate($out,255,255,255);
            imagefill($out,0,0,$white);
            $img= $this->imageRes($file);
            imagecopyresized($out,$img,0,$devHeight,0,0,$this->opWidth,$this->opHeight-2*$devHeight,$size[0],$size[1]);
            imagejpeg($out,$filename);
            imagedestroy($out);
            imagedestroy($img);
        }

    }

    private function imageRes($file){
        $img = null;
        switch ($file['type']){
            case 'image/jpeg':
            case 'image/jpg':
                $img = imagecreatefromjpeg($file['tmp_name']);
                break;
            case 'image/png':
                $img = imagecreatefrompng($file['tmp_name']);
                break;
            case 'image/bmp':
                $img = imagecreatefrombmp($file['tmp_name']);
                break;
        }
        return $img;
    }

    private function devHeight($size)
    {
        $relHeight = $size[1]*$this->opWidth/$size[0];
        return $dev = ($this->opHeight-$relHeight)/2;
    }

    private function getOpHeight($sizes)
    {
        foreach ($sizes as $size){
            empty($minRatio)?$minRatio = $size[0]/$size[1]:'';
            if (($size[0]/$size[1])<$minRatio){
                $minRatio = $size[0]/$size[1];
            }
        }
        $this->opHeight = $this->opWidth/$minRatio;
    }
}

class SplitImg {
    private $file;
    private $width;
    private $height;
    private $opWidth = 720;
    private $opHeight = 720;
    private $splitNum;
    private $dir;

    public function setPath($file,$splitNum=9,$dir = './images/wxkey/'){
        $this->file = $file;
        $this->dir = $dir;
        $this->splitNum = $splitNum;
        $size = getimagesize($file['tmp_name']);
        if ($splitNum==9){
            $this->width = $size[0]/3;
            $this->height = $size[1]/3;
        }elseif($splitNum==6){
            $this->width = $size[0]/3;
            $this->height = $size[1]/2;
        }
    }

    public function split(){
        $img = $this->imageRes();
        $dir = $this->dir;
        $splitNum = $this->splitNum;
        if ($splitNum==6){
            for ($i=0;$i<3;$i++){
                for ($j=0;$j<2;$j++){
                    if (!is_dir($dir))
                        mkdir($dir,0777,true);
                    $fileName = $dir.'key-'.$j.$i.'.jpeg';
                    $outPut = imagecreatetruecolor($this->opWidth,$this->opHeight);
                    imagecopyresized($outPut,$img,0,0,$i*$this->width,$j*$this->height,$this->opWidth,$this->opHeight,$this->width,$this->height);
                    imagejpeg($outPut,$fileName);
                    imagedestroy($outPut);
                }
            }
            imagedestroy($img);
            return;
        }elseif($splitNum==9){
            for ($i=0;$i<3;$i++){
                for ($j=0;$j<3;$j++){
                    $dir = './images/wxkey/';
                    if (!is_dir($dir))
                        mkdir($dir,0777,true);
                    $fileName = $dir.'key-'.$j.$i.'.jpeg';
                    $outPut = imagecreatetruecolor($this->opWidth,$this->opHeight);
                    imagecopyresized($outPut,$img,0,0,$i*$this->width,$j*$this->height,$this->opWidth,$this->opHeight,$this->width,$this->height);
                    imagejpeg($outPut,$fileName);
                    imagedestroy($outPut);
                }
            }
            imagedestroy($img);
        }
    }

    private function imageRes(){
        switch ($this->file['type']){
            case 'image/jpeg':
            case 'image/jpg':
                $img = imagecreatefromjpeg($this->file['tmp_name']);
                break;
            case 'image/png':
                $img = imagecreatefrompng($this->file['tmp_name']);
                break;
            case 'image/bmp':
                $img = imagecreatefrombmp($this->file['tmp_name']);
                break;
        }
        return $img;
    }
}

class zipfile {
    var $datasec = array ();
    var $ctrl_dir = array ();
    var $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";
    var $old_offset = 0;

    function unix2_dostime($unixtime = 0){
        $timearray = ($unixtime == 0) ? getdate () : getdate($unixtime);
        if ($timearray ['year'] < 1980){
            $timearray ['year'] = 1980;
            $timearray ['mon'] = 1;
            $timearray ['mday'] = 1;
            $timearray ['hours'] = 0;
            $timearray ['minutes'] = 0;
            $timearray ['seconds'] = 0;
        }
        return (($timearray ['year'] - 1980) << 25) | ($timearray ['mon'] << 21) | ($timearray ['mday'] << 16) | ($timearray ['hours'] << 11) | ($timearray ['minutes'] << 5) | ($timearray ['seconds'] >> 1);
    }
    function add_file($data, $name, $time = 0){
        $name = str_replace('\\', '/', $name);

        $dtime = dechex($this->unix2_dostime($time));
        $hexdtime = '\x' . $dtime [6] . $dtime [7] . '\x' . $dtime [4] . $dtime [5] . '\x' . $dtime [2] . $dtime [3] . '\x' . $dtime [0] . $dtime [1];
        eval('$hexdtime = "' . $hexdtime . '";');

        $fr = "\x50\x4b\x03\x04";
        $fr .= "\x14\x00";
        $fr .= "\x00\x00";
        $fr .= "\x08\x00";
        $fr .= $hexdtime;

        $unc_len = strlen($data);
        $crc = crc32($data);
        $zdata = gzcompress($data);
        $zdata = substr(substr($zdata, 0, strlen($zdata)- 4), 2);
        $c_len = strlen($zdata);
        $fr .= pack('V', $crc);
        $fr .= pack('V', $c_len);
        $fr .= pack('V', $unc_len);
        $fr .= pack('v', strlen($name));
        $fr .= pack('v', 0);
        $fr .= $name;

        $fr .= $zdata;
        $fr .= pack('V', $crc);
        $fr .= pack('V', $c_len);
        $fr .= pack('V', $unc_len);

        $this->datasec [] = $fr;

        $cdrec = "\x50\x4b\x01\x02";
        $cdrec .= "\x00\x00";
        $cdrec .= "\x14\x00";
        $cdrec .= "\x00\x00";
        $cdrec .= "\x08\x00";
        $cdrec .= $hexdtime;
        $cdrec .= pack('V', $crc);
        $cdrec .= pack('V', $c_len);
        $cdrec .= pack('V', $unc_len);
        $cdrec .= pack('v', strlen($name));
        $cdrec .= pack('v', 0);
        $cdrec .= pack('v', 0);
        $cdrec .= pack('v', 0);
        $cdrec .= pack('v', 0);
        $cdrec .= pack('V', 32);

        $cdrec .= pack('V', $this->old_offset);
        $this->old_offset += strlen($fr);

        $cdrec .= $name;

        $this->ctrl_dir[] = $cdrec;
    }
    function add_path($path, $l = 0){
        $d = @opendir($path);
        $l = $l > 0 ? $l : strlen($path) + 1;
        while($v = @readdir($d)){
            if($v == '.' || $v == '..'){
                continue;
            }
            $v = $path . '/' . $v;
            if(is_dir($v)){
                $this->add_path($v, $l);
            } else {
                $this->add_file(file_get_contents($v), substr($v, $l));
            }
        }
    }
    function file(){
        $data = implode('', $this->datasec);
        $ctrldir = implode('', $this->ctrl_dir);
        return $data . $ctrldir . $this->eof_ctrl_dir . pack('v', sizeof($this->ctrl_dir)) . pack('v', sizeof($this->ctrl_dir)) . pack('V', strlen($ctrldir)) . pack('V', strlen($data)) . "\x00\x00";
    }

    function add_files($files){
        foreach($files as $file){
            if (is_file($file)){
                $data = implode("", file($file));
                $this->add_file($data, $file);
            }
        }
    }
    function output($file){
        $fp = fopen($file, "w");
        fwrite($fp, $this->file ());
        fclose($fp);
    }
}
