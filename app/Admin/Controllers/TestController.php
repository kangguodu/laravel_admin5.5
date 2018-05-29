<?php

namespace App\Admin\Controllers;

use App\Staple;use App\Malls;use App\MallUser;use App\Regions;use App\Category;use App\PlatformUser;use App\MailList;use App\MailListMall;use App\PlatformRule;
use App\RebateMember;
use App\Http\Controllers\Controller;use Illuminate\Http\Request;
use Encore\Admin\Auth\Permission;use Illuminate\Http\Response;
use Encore\Admin\Facades\Admin;use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Widgets\Table;
use Encore\Admin\Widgets\Form;
use Encore\Admin\Widgets\Collapse;
use Encore\Admin\Tree;use DB;
use Encore\Admin\Widgets\Navbar;
use Encore\Admin\Widgets\Alert;
use Encore\Admin\Widgets\Callout;
use Encore\Admin\Widgets\Carousel;

class TestController extends Controller
{
    public function index(Request $request)
    {
        print_r($request->session()->all());
        print_r($request->cookies);
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

    public function create()
    {
      return Admin::content(function ($content)
      {
        $alert = new Alert('content','title','success');
        $content->row($alert);
        $call = new Callout('content','title','danger');
        $content->row($call);

      });
    }

    public function update($id)
    {
      echo $id;
    }
    public function show($id = 1)
    {
      print_r(json_decode($_COOKIE['test'],true));
      // return response('跨域成功',200)->header('Access-Control-Allow-Origin','*');
    }
    public function edit()
    {
      echo "edit";
    }
    public function destroy()
    {
      echo "destroy";
    }
    public function store()
    {

    }
}
