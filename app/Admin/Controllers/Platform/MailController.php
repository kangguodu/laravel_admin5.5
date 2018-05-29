<?php

namespace App\Admin\Controllers\Platform;

use App\MailList;use App\MailListMall;use App\PlatformUser;use App\Malls;
use App\Http\Controllers\Controller;use Illuminate\Http\Request;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Facades\Admin;use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;use Encore\Admin\Widgets\Tab;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Widgets\Table;
use Encore\Admin\Widgets\Form;use Encore\Admin\Widgets\Collapse;


 // id 站內信ID	content_type 類型	title 主題	content 內容	status 狀態	sender 发送者	send_time 发送时间	updated_time 修改時間	updated_by
class MailController extends Controller
{
  private $content_type = [1=>'店鋪動態',2=>'平臺動態',3=>'規則更新',4=>'違規通知',5=>'營銷活動',6=>'重要通知'];
  private $sender;

  public function __construct()
  {
    $obj = PlatformUser::select(['name','id'])->get();
    $sender = $obj->toArray();
    foreach ($sender as $data) {
      $this->sender[$data['id']] = $data['name'];
    }
  }

    public function index()
    {
      Permission::check('mail');
      return Admin::content(function (Content $content) {
          $content->header('平臺站内信');
          $content->description('總覽');

          $content->row(function ($row)
          {
            $button = '
            <a href="" class="disabled btn  btn-default">全部站内信</a>
            <a href="javascript:window.location.href=\''.url('platform/mail/create').'\'" class="btn  btn-default pull-right">新建站内信</a>';
            $row->Column(12,$button);
          });
          $content->row(function ($row)
          {
            $mailObj = MailList::orderBy('send_time','DEC')->paginate(20);

            $box = new Box();

            $headers = ['標題','類型','發送者','發送時間','修改者','修改時間','操作'];

            $rows[] = $this->getSelectRow();

            foreach ($mailObj as $mail) {
              $handle = '<a href="'.url('platform/mail/'.$mail->id).'" class="fa fa-book" title="詳細信息"></a>&nbsp;&nbsp;&nbsp;&nbsp;';
              $handle .= '<a href="javascript:window.location.href=\''.url('platform/mail/'.$mail->id.'/edit').'\'" class="fa fa-pencil" title="修改"></a>&nbsp;&nbsp;&nbsp;&nbsp;';
              $handle .= '<a href="javascript:deleteMail('.$mail->id.')" class="fa fa-trash" title="刪除"></a>';
              $rows[] = [$mail->title,$this->content_type[$mail->content_type],@$this->sender[$mail->sender],date('Y-m-d H:i:s',$mail->send_time),@$this->sender[$mail->updated_by],empty($mail->updated_time)? null:date('Y-m-d H:i:s',$mail->updated_time),$handle];
              // array_unshift($rows,$row);
            }
            $table = new Table($headers,$rows);

            $box->title('信件預覽');
            $box->content($table);
            $row->Column(12,$box);
            $row->Column(12,$mailObj->links());
            $token = '<input type="hidden" name="_token" value="'.csrf_token().'">';
            $row->Column(12,$token);
          });
        });
    }

    public function destroy($id)
    {
      Permission::check('mail');
      if($mail = MailList::find($id)){
        $mail->delete();
        MailListMall::where('mail_id',$id)->delete();
      }
      echo "success";
    }

    public function create()
    {
      Permission::check('mail');
      Admin::js('editor/ueditor.config.js');
      Admin::js('editor/ueditor.all.min.js');
      Admin::js('editor/lang/zh-cn/zh-cn.js');
      Admin::js('js/editor.js');


      return Admin::content(function (Content $content) {
          $content->header('平臺站内信');
          $content->description('信件編輯');

          $content->row(function ($row)
          {
            $button = '
            <a href="'.url('platform/mail').'" class="btn  btn-default">全部站内信</a>
            <a href="javascript:window.location.href=\''.url('platform/mail/create').'\'" class="disabled btn  btn-default pull-right">新建站内信</a>';
            $row->Column(12,$button);
          });
          $content->row(function ($row)
          {
            $box = new Box();
            $form = new Form();

            $option = $this->content_type;
            $script = '<div>
            <script id="editor" name="content" type="text/plain" style="width:100%;min-height:400px"></script></div>';
            unset($option[0]);

            $form->action(url('platform/mail'));
            $form->method('post');
            $form->disablePjax();
            $form->text('title','標題')->placeholder('站内信標題');
            $form->select('content_type','信件類型')->options($option);
            $form->html($script);
            $box->title('新建站内信');
            $box->content($form);

            $row->Column(12,$box);

          });

          $content->row(function ($row)
          {
            $input = '<input type="file" accept="image/png,image/jpeg,image/gif" name="myPic" style="display:none" onchange="uploadMailImg()" id="img">';
            $row->Column(12,$input);
            echo <<<edo
            <script type="text/javascript">

            window.onload = function(){
              var ue = UE.getEditor("editor");
              var img = document.getElementById("edui142");
              if(!img){
                  window.location.reload();
              }
              $('#edui142').after('<div id="edui143" class="edui-box edui-button edui-for-simpleupload edui-default"><div class="edui-box edui-icon edui-default" onclick="clickImg()"></div></div>');
            }


            </script>
edo;
          });
        });
    }

    public function store()
    {
      Permission::check('mail');
      if (empty($_POST['title'])||empty($_POST['content'])) {
        return '<script type="text/javascript">history.go(-1)</script>';
      }
      $data['title'] = $_POST['title'];
      $data['content_type'] = $_POST['content_type'];
      $data['content'] = $_POST['content'];
      $data['status'] = 1;
      $data['sender'] = Admin::user()->id;
      $data['send_time'] = time();
      MailList::insert($data);
      $idObj = MailList::where('send_time',$data['send_time'])->select(['id'])->first();
      echo $id = $idObj->id;
      $mallArr = Malls::select(['id'])->get();
      $mailList = [];
      foreach ($mallArr as $mall) {
        $mailList[] = ['mail_id'=>$id,'read_status'=>1,'mall_id'=>$mall->id];
      }
      MailListMall::insert($mailList);

      return redirect(url('platform/mail/'.$id));

    }

    public function show($arg)
    {
      Permission::check('mail');
      $arr = explode('-',$arg);
      if (!empty($arr[1])&&$arr[1]=='unread')
        return $this->listUnread($arr[0]);
      if (!empty($arr[1])&&$arr[1]=='hadread')
        return $this->listHadread($arr[0]);

      return $this->showMailContent($arr[0]);
    }

    public function edit($id)
    {
      Permission::check('mail');
      if(!empty($_GET['getcontent'])){
        $mailObj = MailList::find($id);
        return json_encode(['content'=>$mailObj->content]);
      }
      Admin::js('editor/ueditor.config.js');
      Admin::js('editor/ueditor.all.min.js');
      Admin::js('editor/lang/zh-cn/zh-cn.js');
      Admin::js('js/editor.js');
      return Admin::content(function (Content $content)use($id) {
          $content->header('平臺站内信');
          $content->description('信件編輯');

          $content->row(function ($row)
          {
            $button = '
            <a href="'.url('platform/mail').'" class="btn  btn-default">全部站内信</a>
            <a href="javascript:window.location.href=\''.url('platform/mail/create').'\'" class="disabled btn  btn-default pull-right">新建站内信</a>';
            $row->Column(12,$button);
          });
          $content->row(function ($row)use($id)
          {
            $box = new Box();
            $form = new Form();

            $mailObj = MailList::select(['title','content_type'])->where('id',$id)->first();
            $option = $this->content_type;
            $script = '<div>
            <script id="editor" name="content" type="text/plain" style="width:100%;min-height:400px"></script></div>';
            unset($option[0]);

            $form->action('javascript:updateMail('.$id.')');
            $form->method('put');
            $form->disablePjax();
            $form->text('title','標題')->placeholder('站内信標題')->default($mailObj->title);
            $form->select('content_type','信件類型')->options($option)->default($mailObj->content_type);
            $form->html($script);
            $box->title('新建站内信');
            $box->content($form);

            $row->Column(12,$box);

          });

          $content->row(function ($row)use($id)
          {
            $input = '<input type="file" accept="image/png,image/jpeg,image/gif" name="myPic" style="display:none" onchange="uploadMailImg()" id="img">';
            $row->Column(12,$input);
            echo <<<edo
            <script type="text/javascript">
            window.onload = function(){
              var ue = UE.getEditor("editor");
              var img = document.getElementById("edui142");
              if(!img){
                  window.location.reload();
              }
              $('#edui142').after('<div id="edui143" class="edui-box edui-button edui-for-simpleupload edui-default"><div class="edui-box edui-icon edui-default" onclick="clickImg()"></div></div>');
              getMailContent();
            }

            </script>
edo;
            $script = '
            <script type="text/javascript">
            function getMailContent(){
              $.get("'.url('platform/mail/'.$id.'/edit').'?getcontent=true",function(data){
                UE.getEditor("editor").execCommand("insertHtml", data.content);
              },"json");
            }
            </script>
            ';
            $row->Column(12,$script);
          });
        });
    }

    public function update($arg)
    {
      Permission::check('mail');
      // $data['title'] = $_POST['title'];
      // $data['content_type'] = $_POST['content_type'];
      // $data['content'] = $_POST['content'];
      // $data['updated_time'] = time();
      // $data['updated_by'] = Admin::user()->id;
      $mail = MailList::find($_POST['id']);
      empty(trim($_POST['title']))?:$mail->title = $_POST['title'];
      $mail->content_type = $_POST['content_type'];
      empty($_POST['content'])?:$mail->content = $_POST['content'];
      $mail->updated_time = time();
      $mail->updated_by = Admin::user()->id;
      $mail->save();
      echo "success";
    }

    public function select($content_type,$sender,$title='')
    {
      Permission::check('mail');
      $arg = ['content_type'=>$content_type,'sender'=>$sender,'title'=>$title];
      return Admin::content(function (Content $content) use($arg) {
          $content->header('平臺站内信');
          $content->description('預覽');

          $content->row(function ($row)
          {
            $button = '
            <a href="'.url('platform/mail').'" class="btn  btn-default">全部站内信</a>
            <a href="javascript:window.location.href=\''.url('platform/mail/create').'\'" class="btn  btn-default pull-right">新建站内信</a>';
            $row->Column(12,$button);
          });
          $content->row(function ($row) use($arg)
          {
            $mailObj = $this->getSearchRes($arg);
            $box = new Box();

            $headers = ['標題','類型','發送者','發送時間','修改者','修改時間','操作'];

            $rows[] = $this->getSelectRow($arg);

            foreach ($mailObj as $mail) {
              $handle = '<a href="'.url('platform/mail/'.$mail->id).'" class="fa fa-book" title="詳細信息"></a>&nbsp;&nbsp;&nbsp;&nbsp;';
              $handle .= '<a href="javascript:window.location.href=\''.url('platform/mail/'.$mail->id.'/edit').'\'" class="fa fa-pencil" title="修改"></a>&nbsp;&nbsp;&nbsp;&nbsp;';
              $handle .= '<a href="javascript:deleteMail('.$mail->id.')" class="fa fa-trash" title="刪除"></a>';
              $rows[] = [$mail->title,$this->content_type[$mail->content_type],@$this->sender[$mail->sender],date('Y-m-d H:i:s',$mail->send_time),@$this->sender[$mail->updated_by],empty($mail->updated_time)? null:date('Y-m-d H:i:s',$mail->updated_time),$handle];
              // array_unshift($rows,$row);
            }
            $table = new Table($headers,$rows);

            $box->title('信件預覽');
            $box->content($table);
            $row->Column(12,$box);
            $row->Column(12,$mailObj->links());
            $token = '<input type="hidden" name="_token" value="'.csrf_token().'">';
            $row->Column(12,$token);
          });
        });
    }

    private function listUnread($id)
    {
      return Admin::content(function (Content $content) use($id) {
          $content->header('平臺站内信');
          $content->description('總覽');
          $btn = '<a href="'.url('platform/mail').'" class="btn  btn-default">全部站内信</a><a href="'.url('platform/mail/'.$id).'" class="btn  btn-default">站内信預覽</a><a href="'.url('platform/mail/'.$id.'-unread').'" class="disabled btn  btn-default">未讀店鋪</a><a href="'.url('platform/mail/'.$id.'-hadread').'" class="btn  btn-default">已讀店鋪</a><a href="javascript:window.location.href=\''.url('platform/mail/create').'\'" class="btn  btn-default pull-right">新建站内信</a>';
          $content->row($btn);

          $content->row(function ($row)use($id)
          {
            $unreadObj = MailListMall::where('mail_id',$id)->where('read_status',1)->paginate(20);
            $mail = MailList::find($id);
            $unreadArr = $unreadObj->toArray();
            $mallArr = array_column($unreadArr['data'],'mall_id');
            $mallObj = Malls::whereIn('id',$mallArr)->get();
            $mallArr = array_column($mallObjArr = $mallObj->toArray(),'id');
            $mallArr = array_combine($mallArr,$mallObjArr);
            $box = new Box();
            $headers = ['未讀店鋪','信件標題','發送者','發送時間','操作'];

            $rows = [];

            foreach ($unreadObj as $obj) {
              $handle = '';
              $rows[] = [$mallArr[$obj->mall_id]['mall_name'],$mail->title,@$this->sender[$mail->sender],date('Y-m-d H:i:s',$mail->send_time),''];
              // array_unshift($rows,$row);
            }
            $table = new Table($headers,$rows);

            $box->title('未讀店鋪');
            $box->content($table);
            $row->Column(12,$box);
            $row->Column(12,$unreadObj->links());
          });
        });
    }

    private function listHadread($id)
    {
      return Admin::content(function (Content $content) use($id) {
          $content->header('平臺站内信');
          $content->description('總覽');
          $btn = '<a href="'.url('platform/mail').'" class="btn  btn-default">全部站内信</a><a href="'.url('platform/mail/'.$id).'" class="btn  btn-default">站内信預覽</a><a href="'.url('platform/mail/'.$id.'-unread').'" class="btn  btn-default">未讀店鋪</a><a href="'.url('platform/mail/'.$id.'-hadread').'" class="disabled btn  btn-default">已讀店鋪</a><a href="javascript:window.location.href=\''.url('platform/mail/create').'\'" class="btn  btn-default pull-right">新建站内信</a>';
          $content->row($btn);

          $content->row(function ($row)use($id)
          {
            $readObj = MailListMall::where('mail_id',$id)->where('read_status',2)->paginate(20);
            $mail = MailList::find($id);
            $readArr = $readObj->toArray();
            $mallArr = array_column($readArr['data'],'mall_id');
            $mallObj = Malls::whereIn('id',$mallArr)->get();
            $mallArr = array_column($mallObjArr = $mallObj->toArray(),'id');
            $mallArr = array_combine($mallArr,$mallObjArr);
            $box = new Box();
            $headers = ['已讀店鋪','信件標題','發送者','發送時間','操作',];

            $rows = [];

            foreach ($readObj as $obj) {
              $handle = '';
              $rows[] = [$mallArr[$obj->mall_id]['mall_name'],$mail->title,@$this->sender[$mail->sender],date('Y-m-d H:i:s',$mail->send_time),''];
              // array_unshift($rows,$row);
            }
            $table = new Table($headers,$rows);

            $box->title('已讀店鋪');
            $box->content($table);
            $row->Column(12,$box);
            $row->Column(12,$readObj->links());
          });
        });
    }

    private function showMailContent($id)
    {
      return Admin::content(function (Content $content) use($id) {
          $content->header('平臺站内信');
          $content->description('總覽');
          $btn = '<a href="'.url('platform/mail').'" class="btn  btn-default">全部站内信</a><a href="'.url('platform/mail/'.$id).'" class="disabled btn  btn-default">站内信預覽</a><a href="'.url('platform/mail/'.$id.'-unread').'" class="btn  btn-default">未讀店鋪</a><a href="'.url('platform/mail/'.$id.'-hadread').'" class="btn  btn-default">已讀店鋪</a><a href="javascript:window.location.href=\''.url('platform/mail/create').'\'" class="btn  btn-default pull-right">新建站内信</a>';
          $content->row($btn);
          $content->row(function ($row) use($id)
          {
            $mailObj = MailList::find($id);

            $box = new Box();

            $content = '<div class="col-sm-2">&nbsp;</div><div class="col-sm-8">';
            $content .= '<div style="text-align:center"><h2>'.$mailObj->title.'<br></h2></div>';
            $content .= '<div style="text-align:right">發送人：'.@$this->sender[$mailObj->sender].'</div><div>';
            $content .= '<br/><br/>'.$mailObj->content.'</div></div>';

            $box->title('信件預覽');
            $box->content($content);
            $row->Column(12,$box);
            $row->Column(3,'');
            $row->Column(5,'<input type="button" onclick="javascript:window.location.href=\''.url('platform/mail/'.$id.'/edit').'\'" class="btn btn-info" value="修改">');
            $row->Column(3,'<input type="button" onclick="javascript:deleteMail('.$id.')" class="btn btn-danger" value="刪除">');
            $token = '<input type="hidden" name="_token" value="'.csrf_token().'">';
            $row->Column(12,$token);
          });
        });
    }

    private function getSearchRes($arg)
    {
      $title = $arg['title'];
      $content_type = $arg['content_type'];
      $sender = $arg['sender'];
      $content_type == 'all'?$match['content_type']='<>':$match['content_type']='=';
      $sender == 'all'?$match['sender']='<>':$match['sender']='=';
      if ($title=='') {
        return MailList::where('sender',$match['sender'],$sender)->where('content_type',$match['content_type'],$content_type)->paginate(20);
      }else {
        return MailList::where('title','like','%'.trim($title).'%')->where('sender',$match['sender'],$sender)->where('content_type',$match['content_type'],$content_type)->paginate(20);
      }
    }

    private function getSelectRow($arg=null)
    {
      $input = '<input class="form-control" name="search" placeholder="輸入標題搜索">';
      $switch = '<select class="form-control" name="content_type"><option value=
      "all" selected="selected">全部</option>';
      foreach ($this->content_type as $key => $type) {
        if(is_numeric($arg['content_type'])&&$arg['content_type']==$key){
          $switch .= '<option selected="selected" value="'.$key.'">'.$type.'</option>';
        }else {
          $switch .= '<option value="'.$key.'">'.$type.'</option>';
        }
      }
      $switch .= '</select>';
      $sender = '<select class="form-control" name="sender"><option value=
      "all" selected="selected">全部</option>';
      foreach ($this->sender as $key => $name) {
        if(!empty($arg['sender'])&&$arg['sender']==$key){
        $sender .= '<option selected="selected" value="'.$key.'">'.$name.'</option>';continue;}
        $sender .= '<option value="'.$key.'">'.$name.'</option>';
      }
      $sender .= '</select>';
      $submit = '<a href="javascript:mailSearchSubmit()" class="btn  btn-default"><i class="fa fa-search"></i>&nbsp;搜索</a>';
      return array($input,$switch,$sender,'','','',$submit);
    }
}
