<script type="text/javascript">
  setTimeOut(window.history.go(-1),2000);
</script>
<a href="'.admin_url('platform/goodspec').'/'.$data->id.'/edit" class="fa fa-pencil"></a>
<a href="javascript:deleteActivity('.$data->id.')" class="fa fa-trash"></a>
<input type="hidden" name="_token" value="'.csrf_token().'">
<a href="#" class="btn btn-sm btn-info">全部</a>
<a href="#" class="active btn btn-sm">當前進行</a>
<a href="#" class="btn btn-sm btn-default pull-right">新添活動</a>
<a href="'.admin_url('platform/activity/'.$data->id.'/edit').'" class="fa fa-pencil"></a>
<div style="text-align:center">
  <h2>操作成功！</h2>
  <p><a href="'.admin_url('platform/activity').'">返回<i class="fa fa-reply"></i></a></p>
</div>
