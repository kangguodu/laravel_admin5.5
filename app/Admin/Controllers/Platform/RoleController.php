<?php
namespace App\Admin\Controllers\Platform;


use App\Roles;
use App\Http\Controllers\Controller;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Facades\Admin;use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Table;
use Encore\Admin\Widgets\Form;use Illuminate\Http\Request;

/**
 *
 */
class RoleController extends Controller
{

  private $arr;

  public function index()
  {
    Permission::check('store');
    return Admin::content(function (Content $content){
      $content->header('店鋪權限');
      $content->description('權限信息預覽');

      $content->row(function ($row)
      {
        $button = '<a href="'.url('platform/role/create').'" class="btn btn-default">新加權限</a><a href="javascript:history.go(-1)" class="btn btn-default pull-right"><i class="fa fa-chevron-left"></i> 返回</a>';
        $row->Column(12,$button);
      });
      $data = Roles::paginate(20);
      $headers = ['權限','權限名稱','描述','創建時間','更新時間','操作'];
      $rows = [];
      foreach ($data as $role) {
        $link = '<a href="'.url('platform/role').'/'.$role->id.'/edit" class="fa fa-pencil"></a>';
        $link .= '&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:deleteRole('.$role->id.')" class="fa fa-trash"></a>';
        $rows[] = [$role->name,$role->display_name,$role->description,$role->created_at,$role->updated_at,$link];
      }
      $content->row('<input type="hidden" name="_token" value="'.csrf_token().'">');
      $content->row((new Box('權限信息', new Table($headers, $rows)))->solid());
      $content->row($data->links());
    });
  }

  public function create()
  {
    Permission::check('store');
    return Admin::content(function (Content $content){
      $content->header('店鋪權限');
      $content->description('新增權限');

      $content->row(function ($row)
      {
        $button = '<a href="'.url('platform/role').'" class="btn btn-default">全部權限</a><a href="javascript:history.go(-1)" class="btn btn-default pull-right"><i class="fa fa-chevron-left"></i> 返回</a>';
        $row->Column(12,$button);
      });
      $form = new Form();
      $form->action(url('platform/role'));
      $form->method('post');
      $form->disablePjax();
      $form->text('name','權限')->help('僅可輸入字母、數字');
      $form->text('display_name','權限名稱');
      $form->text('description','描述');
      $form->display('created_at','創建時間')->default(date('Y-m-d H:i',time()));
      $form->display('updated_at','最近更新時間')->default(date('Y-m-d H:i',time()));
      $box = new Box('新增權限',$form);
      $content->row($box);
    });
  }

  public function store()
  {
    Permission::check('store');
    return Admin::content(function (Content $content){
      $content->header('店鋪權限');
      $content->description('添加權限');

      if (empty(trim($_POST['name']))||!preg_match('/^[a-zA-Z][a-zA-Z0-9]+$/',trim($_POST['name']))){
      $errMsg = '<div style="text-align:center"><h2>ERROR</h2><p>權限為字母或數字構成，您的輸入錯誤</p></div>';
      $content->row($errMsg);
      }else {
        $data['name'] = trim($_POST['name']);
        $data['display_name'] = $_POST['display_name'];
        $data['description'] = $_POST['description'];
        Roles::create($data);
        $successMsg = '<div style="text-align:center"><h2>添加成功</h2><p><a href="'.url('platform/role').'">返回</a></p></div>';
        $content->row($successMsg);
      }

    });
  }

  public function edit($id)
  {
    Permission::check('store');
    $this->arr['id'] = $id;
    return Admin::content(function (Content $content){
      $content->header('店鋪權限');
      $content->description('修改權限信息');

      $content->row(function ($row)
      {
        $button = '<a href="'.url('platform/role').'" class="btn btn-default">全部權限</a><a href="javascript:history.go(-1)" class="btn btn-default pull-right"><i class="fa fa-chevron-left"></i> 返回</a>';
        $row->Column(12,$button);
      });
      $role = Roles::find($this->arr['id']);
      $form = new Form();
      $form->action('javascript:updateRole('.$this->arr['id'].')');
      $form->disablePjax();
      $form->text('name','權限')->default($role->name);
      $form->text('display_name','權限名稱')->default($role->display_name);
      $form->text('description','描述')->default($role->description);
      $form->display('created_at','創建時間')->default($role->created_at);
      $form->display('updated_at','最近更新時間')->default($role->updated_at);
      $content->row(new Box('修改權限',$form));
    });
  }

  public function update($type)
  {
    Permission::check('store');
    if (!empty(trim($_POST['name']))&&preg_match('/^[a-zA-Z][a-zA-Z0-9]+$/',trim($_POST['name'])))
    $data['name'] = trim($_POST['name']);
    $data['display_name'] = trim($_POST['display_name']);
    $data['description'] = trim($_POST['description']);
    if(Roles::find($_POST['id'])->update($data))
    {
      echo "success";
    }
  }

  public function destroy($type)
  {
    Permission::check('store');
    if ($_POST['id']==1) {
      return 'failed';
    }
    if (Roles::find($_POST['id'])->delete()) {
      echo "success";
    }else {
      echo "failed";
    }
  }
}
