function checkCanteen() {
  name = $('input[name="name"]').val();
  address = $('input[name="address"]').val();
  mobile = $('input[name="mobile"]').val();
  if (name&&address&&mobile) {
    $('form').attr({'action':url+'rebate/canteen'}).submit();
  }else {
    alert('有選項爲空');
  }
}
function deleteCanteen(id) {
  if (confirm('確認刪除？')) {
    token = $('input[name="_token"]').val();
    $.post(url+'rebate/canteen/'+id,{'_token':token,'_method':'delete','id':id},function (data) {
      if (data=='success') {
        window.location.href = url+'rebate/canteen';
      }
    });
  }
}

function passWithdraw(id) {
  if (confirm('該提現已轉賬？')) {
    token = $('input[name="_token"]').val();
    $.post(url+'rebate/withdraw/'+id,{'handle':'pass','_method':'PUT','_token':token},function (data) {
      if (data=='success') {
        window.location.reload();
      }else {
        alert('系統出錯');
      }
    })
  }
}

function doneWithdraw(id) {
  if (confirm('確認該提現已完成？')) {
    token = $('input[name="_token"]').val();
    $.post(url+'rebate/withdraw/'+id,{'handle':'done','_method':'PUT','_token':token},function (data) {
      if (data=='success') {
        window.location.reload();
      }else {
        alert('系統出錯');
      }
    })
  }
}
function rejectWithdraw() {
  if (confirm('駁回該提現？')) {
    token = $('input[name="_token"]').val();
    id = $('#applyId').val();
    handle_note = $('input[name="handle_note"]').val();
    $.post(url+'rebate/withdraw/'+id,{'handle':'reject','_method':'PUT','_token':token,'id':id,'handle_note':handle_note},function (data) {
      if (data=='success') {
        history.go(-1);
      }else {
        alert('系統出錯');
      }
    })
  }
}
