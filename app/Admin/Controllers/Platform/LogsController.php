<?php

namespace App\Admin\Controllers\Platform;

use App\AdminOperationLog;use App\PlatformUser;
use App\Http\Controllers\Controller;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Facades\Admin;use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Table;use Illuminate\Http\Response;
use Encore\Admin\Widgets\Form;use Illuminate\Http\Request;
use Encore\Admin\Widgets\Alert;

class LogsController extends Controller
{
    public function index()
    {
      Permission::check('logs');
      $user = $this->getUser();
      $logs = AdminOperationLog::orderBy('id','DES')->paginate(20);
      return Admin::content(function (Content $content)use ($user,$logs)
      {
        $content->header('操作日志');
        $content->description('平臺日志');

        $headers = ['ID','Name','Method','Path','IP','Input','Created_Time'];
        $rows = [];
        foreach ($logs as $log) {
          $input = $this->formatInput($log);
          $row = [$log->id,$user[$log->user_id],$log->method,$log->path,$log->ip,$input,$log->created_at];
          array_push($rows,$row);
        }
        $content->row(new Box('操作日志',new Table($headers,$rows)));
        $content->row($logs->links());
      });
    }

    public function show($id)
    {
      $log = AdminOperationLog::find($id);
      if (!$log) {
        return redirect(url('platform/logs'));
      }
      $user = PlatformUser::find($log->user_id);
      return Admin::content(function (Content $content)use ($user,$log)
      {
        $content->header('操作日志');
        $content->description('日志詳細');

        $headers = ['ID','Name','Method','Path','IP','Created_Time'];
        $rows = [[$log->id,$user->username,$log->method,$log->path,$log->ip,$log->created_at]];

        $content->row(new Box('操作日志',new Table($headers,$rows)));

        @$input = preg_replace_callback('/\\\\u([0-9a-f]{4})/i', [$this,'replace_unicode_escape_sequence'], $log->input);
        $content->row(new Box('輸入詳細',htmlspecialchars($input)));
      });
    }

    private function getUser()
    {
      $users = PlatformUser::select(['id','name'])->get();
      $userArr = [];
      foreach ($users as $user) {
        $userArr[$user->id] = $user->name;
      }
      return $userArr;
    }

    private function formatInput($log)
    {
      $input = $log->input;
      @$input = preg_replace_callback('/\\\\u([0-9a-f]{4})/i', [$this,'replace_unicode_escape_sequence'], $input);
      if (strlen($input)>100) {
        $input = '<a href="'.url('platform/logs/'.$log->id).'">'.substr($input,0,100).'....</a>';
      }
      return $input;
    }

    private function replace_unicode_escape_sequence($match) {
      return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
    }




}
