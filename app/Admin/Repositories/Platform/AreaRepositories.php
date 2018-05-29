<?php

namespace App\Admin\Repositories\Platform;

use App\Regions;
use Encore\Admin\Facades\Admin;use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Widgets\Table;
use Encore\Admin\Widgets\Form;
/**
 *
 */
class AreaRepositories
{
  private $parent_id;
  private $freeIcon = [1=>'<i class="pull-right btn btn-xs btn-default disabled" style="font-size:0.6em">免郵費</i>',0=>'<i class="btn btn-xs btn-default pull-right disabled" style="font-size:0.6em">不免郵</i>',];
  public function index()
  {
      return Admin::content(function (Content $content) {
        $content->header('區域管理');
        $content->description('查看區域分類信息');

        $content->row(function ($row)
        {
          // $row->Column(3,'');
          $row->Column(12,'<a href="#" class="btn btn-default disabled">區域信息</a><a class="btn btn-default pull-right" href="'.url('platform/area/create').'">新增區域</a>');
          $row->Column(3,'');
          $row->Column(12,'');
          $html = '<ul class="list-group"><li class="list-group-item">';
          $areaTop = Regions::find(1);
          $childArea = Regions::where('parent_id',1)->get();

          $childLi = '<ul class="list-group">';
          foreach ($childArea as $area) {
            $childLi .= '<li id="area-'.$area->region_id.'" class="list-group-item">';
            $childLi .= '<span class="col-sm-6" onclick="showKeyArea('.$area->region_id.')"><b>|——</b>'.$area->region_name.'</span>';
            $childLi .= '<i onclick="showKeyArea('.$area->region_id.')" class="fa fa-navicon btn btn-xs pull-right"></i>'.$this->freeIcon[$area->is_free].'&nbsp;';
            $childLi .= '<a href="javascript:deleteArea('.$area->region_id.')" class="fa fa-trash btn btn-default btn-xs pull-right"></a>&nbsp;';
            $childLi .= '<a href="'.url('platform/area/'.$area->region_id.'/edit').'" class="fa fa-pencil btn btn-default btn-xs pull-right"></a></li>';
          }
          $childLi .= '</ul>';
          $html .= $areaTop->region_name;
          $html .= '</li><li id="keyOf1"'.$areaTop->region_id.' class="list-group-item">'.$childLi.'</li></ul>';
          $box = new Box;
          $box->title('區域信息');
          $box->content($html);
          // $row->Column(3,'');
          $row->Column(12,$box);
        });
        $token = '<input id="_token" type="hidden" value="'.csrf_token().'" name="_token">';
        $content->row($token);
      });
  }

  public function getKeyArea($id,$arr)
  {
    $areas = Regions::where('parent_id',$id)->select(['region_id'])->get();
    foreach ($areas as $area) {
      array_push($arr,$area->region_id);
      $arr = $this->getKeyArea($area->region_id,$arr);
    }
    return $arr;
  }

  public function createContent()
  {
    return Admin::content(function (Content $content) {
      $content->header('區域管理');
      $content->description('添加新區域');
      $content->row(function ($row)
      {
        $row->Column(3,'');
        $html = '<div style="text-align:center"><b>Tips:</b>下拉框點擊后可進行搜索<br>&nbsp;</div>';
        $row->Column(6,$html);
      });
      $content->row(function ($row)
      {
        $form = new Form();
        $form->action(url('platform/area'));
        $form->text('region_name','區域名稱')->rules('required|min:1');;
        $form->switch('is_free','包郵')->default(1);
        $areas = Regions::orderBy('region_type','asc')->get();
        $areaArr = [];
        foreach ($areas as $area) {
          $areaArr += [$area->region_id=>$area->region_name];
        }
        $form->select('parent_id','父區域')->options($areaArr);

        $row->Column(2,'');
        $row->Column(8,$form);
      });
    });
  }

  public function ajaxUl($parent_id)
  {
    $this->parent_id = $parent_id;

    $pre = ['|','|——','|————','|——————','|————————'];
    $color = [1=>'#eeeeee',2=>'#e9e9e9',3=>'#dfdfdf',4=>'#d0d0d0'];
    $areaArr = Regions::where('parent_id',$this->parent_id)->get();
    if(empty($areaArr[0]))die;
    $childLi = '';
    foreach ($areaArr as $area) {
      $childLi .= '<li id="area-'.$area->region_id.'" class="list-group-item" style="background-color:'.$color[$area->region_type].'">';
      $childLi .= '<span class="col-sm-6" onclick="showKeyArea('.$area->region_id.')"><b>'.$pre[$area->region_type].'</b>'.$area->region_name.'</span>';
      $childLi .= '<i onclick="showKeyArea('.$area->region_id.')" class="fa fa-navicon btn btn-xs pull-right"></i>'.$this->freeIcon[$area->is_free].'&nbsp;';
      $childLi .= '<a href="javascript:deleteArea('.$area->region_id.')" class="fa fa-trash btn btn-default btn-xs pull-right"></a>&nbsp;';
      $childLi .= '<a href="'.url('platform/area/'.$area->region_id.'/edit').'" class="fa fa-pencil btn btn-default btn-xs pull-right"></a></li>';
    }
    echo $childLi;

  }


    private function areaContent()
    {
      return Admin::content(function (Content $content) {
          $content->header('地區');
          $content->description('地區分類信息');
          $content->row(function ($row)
          {
            $form=view('mall.region');
            $row->Column(1,'');
            $row->Column(10,$form);
          });
        });
    }

    public function addAreaContent($status)
    {
      if (!$status) {
        return Admin::content(function (Content $content) {
            $content->header('區域管理');
            $content->description('地區添加失敗');
            $content->row('<h1 style="text-align:center"><i class="fa fa-remove"></i>操作失敗</h1><br>');
            $content->row('<h4 style="text-align:center"><a href="javascript:history.go(-1);reload()">返回</a></h4>');
          });
      }
      return Admin::content(function (Content $content) {
          $content->header('添加成功');
          $content->description('地區添加成功');
          $content->row('<h1 style="text-align:center"><i class="fa fa-check"></i>操作成功</h1><br>');
          $content->row('<h4 style="text-align:center"><a href="'.url('platform/area').'">返回</a></h4>');
        });
    }


    public function parseAreaInfo()
    {
      $_POST['is_free']=='off'?$is_free = 0:$is_free = 1;
      $type = Regions::where('region_id',$_GET['parent_id'])->select('region_type')->first();
      $type = $type['region_type']+1;
      return array('parent_id'=>$_GET['parent_id'],'region_type'=>$type,'is_free'=>$is_free,'region_name'=>$_POST['region_name']);
    }
}
