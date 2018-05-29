<?php

namespace App\Admin\Controllers\Platform;

use App\Staple;use App\Malls;use App\MallUser;use App\Regions;
use App\Http\Controllers\Controller;use Illuminate\Http\Request;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Facades\Admin;use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Widgets\Table;
use Encore\Admin\Widgets\Form;;

class UserController extends Controller
{
    private $id;
    private $ownerFa = [1=>'<i class="fa fa-check-circle-o"></i>',0=>'<i class="fa fa-times-circle-o"></i>'];

    public function show($id)
    {
      Permission::check('store');
      $this->id = $id;
      return Admin::content(function (Content $content) {
          $content->header('店铺用户');
          $content->description('店铺用户信息');
          $this->navbar($content);

          $token = '<input type="hidden" value="'.csrf_token().'" id="_token">';
          $content->row($token);
          $mall_id = $this->id;
          $resUserInfo = MallUser::where('mall_id',$mall_id)
                ->select(['id','username','nickname','phone','email','is_owner','created_at'])
                ->get();
          $resMallName = Malls::where('id',$mall_id)->select(['mall_name'])->get();

          $table = $this->parseUserInfo($resUserInfo,$resMallName);
          $headers = $table['headers'];$rows = $table['rows'];

          $content->row((new Box('店铺信息', new Table($headers, $rows))));
        });
    }

    public function edit($id)
    {
      Permission::check('store');
      $this->id = $id;
      return Admin::content(function (Content $content) {
        $content->header('店铺用户');
        $content->description('店铺用户修改');
        $this->navbar($content);

        $content->row(function ($row)
        {
          $data = MallUser::find($this->id);
          $mall = Malls::find($data->mall_id);
          $form = new Form();
          $form->disablePjax();
          $form->action('javascript:updateStoreUser(this)');
          $form->display('mall_id','店鋪名稱')->default($mall->mall_name);
          $form->hidden('id')->default($this->id);
          $form->text('username','用戶名')->default($data->username)->help('僅使用字母、數字及"-_" 構成用戶名，首字符必須為字母');
          $form->text('nickname','昵稱')->default($data->nickname);
          $form->mobile('phone','號碼')->default($data->phone);
          $form->email('email','Email')->default($data->email);
          $form->text('password','密碼')->help('不修改密碼請留空！');
          $data->is_owner?$owner='是':$owner='否';
          $form->display('is_owner','店主')->default($owner);
          $form->display('created_at','創建時間')->default($data->created_at);
          $form->display('updated_at','上次更改時間')->default($data->updated_at);
          $row->Column(12,new Box('修改',$form));
        });
      });
    }

    public function update()
    {
      Permission::check('store');
      $data = $this->matchUserInfo();
      if(MallUser::find($_POST['id'])->update($data))
      return "success";
      return 'failed';
    }

    private function matchUserInfo()
    {
      $username = trim($_POST['username']);
      if (!preg_match('/^[a-zA-Z][a-zA-Z0-9-_]+$/',$username))
      die('username');
      $uname = MallUser::where('username',$username)->select(['id','username'])->first();
      if (!empty($uname)&&$uname->id!=$_POST['id']) die("usernamerepeat");

      if (!preg_match('/^[\d]{11}/',$_POST['phone'])) die('phone');
      $phone = MallUser::where('phone',$_POST['phone'])->first();
      if (!empty($phone)&&$phone->id!=$_POST['id']) die("phonerepeat");

      $data['username'] = $username;
      $data['phone'] = $_POST['phone'];
      empty($nickname = trim($_POST['nickname']))? :$data['nickname']=$nickname;
      empty($email = trim($_POST['email']))? :$data['email']=$email;
      if(!empty(trim($_POST['password'])))
      preg_match('/[a-zA-Z0-9_]{6,25}/',trim($_POST['password']))? $data['password'] = \Hash::make($_POST['password']):die('password');
      return $data;
    }

    public function destroy()
    {
      Permission::check('store');
      $id = $_POST['id'];
      if (MallUser::where('id',$id)->delete()) {
        echo "用户已被删除！";
      }else {
        echo "请勿重复删除！";
      }
    }

    private function parseUserInfo($users,$mall)
    {
      $headers = ['Id','MallName','UserName','NickName','Phone','Email','Owner','Create','Handle'];
      $rows = [];
      foreach ($users as $user) {
        $handle = '<a href="'.url('platform/user').'/'.$user->id.'/edit" class="fa fa-pencil" title="修改"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:deleteMallUser(this,'.$user->id.')" class="fa fa-trash" title="刪除"></a>';
        $rows[] = [$user->id,$mall[0]['mall_name'],$user->username,$user->nickname,$user->phone,$user->email,$this->ownerFa[$user->is_owner],$user->created_at,$handle];
      }
      return array('headers'=>$headers,'rows'=>$rows);
    }
    private function navbar(&$content)
    {
      $nav = '<a href="javascript:history.go(-1)" class="btn btn-default pull-right"><i class="fa fa-chevron-left"></i> 返回</a>';
      $content->row($nav);
    }
}
