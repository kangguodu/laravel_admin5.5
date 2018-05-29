<?php

namespace App\Admin\Controllers;

use App\Activity;
use App\Http\Controllers\Controller;use Illuminate\Http\Request;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Facades\Admin;use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;use Encore\Admin\Widgets\Tab;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Widgets\Table;
use Encore\Admin\Widgets\Form;use Encore\Admin\Widgets\Collapse;

class OneSignalController extends Controller
{
    // protected $app_id = '419f0b34-f6c1-4bb0-b4b2-9500f328f0bd';
    protected $app_id = 'f982c365-6fed-49f2-bfb0-0eefe8807f1b';
    private $content;
    private $acti_id;
    private $included_segments = 'All';

    public function show($id)
    {
      Permission::check('activity');
      return Admin::content(function (Content $content) use($id) {
          $content->header('活動推送');
          $content->description('消息推送');

          $content->row(function ($row) use ($id)
          {
            $box = new Box();
            $form = new Form();
            $acti = Activity::select(['name'])->find($id);

            $form->action(url('onesignal'));
            $form->method('post');
            $form->disablePjax();
            $form->hidden('id')->default($id);
            $form->textarea('content','推送内容')->default($acti->name);

            $box->title('活動推送');
            $box->content($form);

            $row->Column(12,$box);
          });
        });
    }

    public function store()
    {
      Permission::check('activity');
      $this->savePostData();
      $response = $this->sendMessage();
      $this->increPushTime();
      return Admin::content(function (Content $content)use($response){
          $content->header('活動推送');
          $content->description('消息推送');

          $content->row(function ($row) use($response)
          {
            $box = new Box();

            $response = json_decode($response,true);
            // print_r($response);
            if (!empty($response['id'])) {
              $content = '<div style="text-align:center"><h2>推送成功</h2><p><a href="'.url('platform/activity').'">返回</a></p></div>';
            }else {
              $content = '<div style="text-align:center"><h2>推送失敗</h2><p><a href="'.url('platform/activity').'">返回</a></p></div>';
            }

            $box->title('活動推送');
            $box->content($content);

            $row->Column(12,$box);
          });
        });
    }

    private function savePostData()
    {
      if(empty($_POST['content']))die('<script type="text/javascript">
        history.go(-1);
      </script>');
      $this->acti_id = $_POST['id'];
      $this->content = trim($_POST['content']);
    }

    public function increPushTime()
    {
      Activity::find($this->acti_id)->increment('push_times');
    }

    private function sendMessage() {
      $content = array("zh-Hant" => $this->content,'en' => '2018');
      $fields = array(
        'app_id' => $this->app_id,
        'included_segments' => array(
            'All',
        ),
        'data' => array(
            "id" => $this->acti_id,
        ),
        'contents' => $content,
      );

      $fields = json_encode($fields);
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic MzM1NzUwM2UtM2EwZi00M2RjLWI2MWItZGE1M2YzNWEzMmIz'
        // 'Authorization: Basic NGQzMDI0ZDktNDcyZS00OTAxLThjZTItNmUyYzU4NmU1ZDMz'
      ));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_HEADER, FALSE);
      curl_setopt($ch, CURLOPT_POST, TRUE);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

      return $response = curl_exec($ch);
    }
}
