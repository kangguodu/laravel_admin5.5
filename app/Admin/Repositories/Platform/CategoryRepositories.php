<?php

namespace App\Admin\Repositories\Platform;

use App\Category;use Illuminate\Support\Facades\DB;
use App\Staple;use App\StapleInfo;
use Encore\Admin\Facades\Admin;use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Widgets\Table;
use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

/**
 *
 */
class CategoryRepositories
{
  protected $request;

  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  public function addChild($data)
  {
    $data = $this->initData($data);
    $parent_id = $data['parent_id'];      //parent id

    if($parent_id > 0){
      $root = Category::find($parent_id);     //get obj of parent
      $data = $this->initCatIdData($data,$root);     //init child data
      if ($bigest = Category::where('parent_id',$parent_id)->orderBy('priority','DES')->first()) {
        if ($data['priority']>$bigest->priority) {
          $data['priority'] = $bigest->priority+1;
          $child = $root->children()->create($data);
          $catid = 'cat_id_'.$root->level+2;
          Category::find($child->id)->update([$catid=>$child->id]);
          return $child->id;
        }
      }else {
        $data['priority'] = 1;
        $child = $root->children()->create($data);
        $catid = 'cat_id_'.$root->level+2;
        Category::find($child->id)->update([$catid=>$child->id]);
        return $child->id;
      }
      $priority = $data['priority']-1;      //num < will be increted
      Category::where('parent_id',$parent_id)->where('priority','>',$priority)->increment('priority');
      $child = $root->children()->create($data);
      $catid = 'cat_id_';
      $catid .= $root->level+2;
      Category::find($child->id)->update([$catid=>$child->id]);
      return $child->id;
    }else{
      if ($bigest = Category::where('parent_id',0)->orderBy('priority','DES')->first()) {
        if ($data['priority']>$bigest->priority) {
          $data['priority'] = $bigest->priority+1;
          $root = Category::create($data);
          return $root->id;
        }
      }else {
        $data['priority'] = 1;
        $root = Category::create($data);
        return $root->id;
      }
      Category::where('parent_id',0)->where('priority','>',$data['priority']-1)->increment('priority');
      $root = Category::create($data);
      // $data = ['category_id'=>$root->id,'staple_id'=>$_POST['staple']];
      // StapleInfo::insert($data);
      return $root->id;
    }
  }
//商品分類權限網上更改
  public function increasePrio($cat_id,$num)
  {
    $cate = Category::find($cat_id);
    $prePrioObj = Category::where('parent_id',$cate->parent_id)->where('priority','<',$cate->priority)->orderBy('priority','DESC')->limit($num)->get();
    $prePrio = $prePrioObj[$num-1]->priority;
    Category::where('parent_id',$cate->parent_id)->where('priority','<',$cate->priority)->orderBy('priority','DESC')->limit($num)->increment('priority');
    $cate->update(['priority'=>$prePrio,]);
  }

  public function declinePrio($cat_id,$num)
  {
    $cate = Category::find($cat_id);
    $prePrioObj = Category::where('parent_id',$cate->parent_id)->where('priority','>',$cate->priority)->orderBy('priority','ASC')->limit($num)->get();
    if(!@$prePrio = $prePrioObj[$num-1]->priority)die;
    Category::where('parent_id',$cate->parent_id)->where('priority','>',$cate->priority)->orderBy('priority','ASC')->limit($num)->decrement('priority');
    $cate->update(['priority'=>$prePrio,]);
  }

  public function getAddForm()
  {
    $cat_1 = Category::where('parent_id',0)->get(['id','cat_name']);
    $catArr[0] = '--新建一級分類--';
    foreach ($cat_1 as $cat ) {
      $catArr[$cat->id] = $cat->cat_name;
    }
    return Admin::content(function (Content $content)use($catArr)
    {
      $content->header('商品分類');
      $content->description('添加商品分類');

      $this->navbarRow($content);
      $data = Category::all();
      $option = [0=>'根分類'];
      foreach ($data as $category ) {
        $option[$category->id] = $category->cat_name;
      }

      $form = new Form();
      $form->action(url('platform/category'));
      $form->method('post');
      $form->disablePjax();
      //一級分類
      $form->select('cat_id_1','一級分類')
           ->options($catArr)->default(0)
           ->help('通過選項框選擇已有一級分類，或選擇<新建一級分類>，並于下方填寫你要新增的一級分類信息')
           ->load('cat_id_2',url('platform/category/create'))
           ->attribute(['onchange'=>'javascript:cat1Selected()']);
      $form->text('new_cat_1','')
           ->placeholder('一級分類名稱')
           ->attribute(['onblur'=>'javascript:cat1Input()']);
      // $form->text('cat_1_desc','描述');
      $form->text('cat_1_priority','權重')->default(1);
      $form->image('cat_1_image','圖片')
           ->help("商品分類圖片")->attribute(['accept'=>'image/*']);
      $form->html('<HR style="FILTER: alpha(opacity=100,finishopacity=0,style=2)" width="100%" color=#aaaaaa SIZE=10>');
      //二級分類
      $form->select('cat_id_2','二級分類')
           ->help('通過選項框選擇已有二級分類，或于下方填寫你要新增的分類信息')
           ->attribute(['onchange'=>'javascript:cat2Selected()']);
      $form->text('new_cat_2','')
           ->placeholder('新建二級分類')
           ->attribute(['onblur'=>'javascript:cat2Input()']);
      // $form->text('cat_2_desc','描述');
      $form->text('cat_2_priority','權重')->default(1);
      $form->image('cat_2_image','圖片')->attribute(['accept'=>'image/*'])
           ->help("商品分類圖片");
      $form->html('<HR style="FILTER: alpha(opacity=100,finishopacity=0,style=2)" width="100%" color=#aaaaaa SIZE=10>');

      //三級分類
      $form->text('new_cat_3','三級分類')
           ->placeholder('新建三級分類');
      // $form->text('cat_3_desc','描述');
      $form->text('cat_3_priority','權重')->default(1);
      $form->image('cat_3_image','圖片')->attribute(['accept'=>'image/*'])
           ->help("在輸入框輸入新分類名稱");
      $content->row(new Box('新增分類',$form));
    });
  }

  private function initData($data)
  {
      $data['parent_id'] = isset($data['parent_id'])?intval($data['parent_id']):0;
      $data['cat_desc'] = empty($data['cat_desc'])?'':trim($data['cat_desc']);
      $data['cat_name'] = trim($data['cat_name']);
      $data['is_deleted'] = isset($data['is_deleted'])?intval($data['is_deleted']):0;
      $data['is_hidden'] = isset($data['is_hidden'])?intval($data['is_hidden']):0;
      $data['priority'] = isset($data['priority'])?intval($data['priority']):0;
      $data['max_price'] = isset($data['max_price'])?intval($data['max_price']):0;
      $data['min_price'] = isset($data['min_price'])?intval($data['min_price']):0;
      $data['is_mall_dsr'] = isset($data['is_mall_dsr'])?intval($data['is_mall_dsr']):0;
      $data['price_range_ratio'] = isset($data['price_range_ratio'])?intval($data['price_range_ratio']):0;
      if(isset($data['staple']))unset($data['staple']);

      return $data;
  }

  private function initCatIdData($data,$parent)
  {
    $data['cat_id_1'] = empty($parent->cat_id_1)?0:$parent->cat_id_1;
    $data['cat_id_2'] = empty($parent->cat_id_2)?0:$parent->cat_id_2;
    $data['cat_id_3'] = empty($parent->cat_id_3)?0:$parent->cat_id_3;
    $data['cat_id_4'] = empty($parent->cat_id_4)?0:$parent->cat_id_4;
    return $data;
  }

  private function navbarRow(&$content)
  {
    $nav = '<a href="'.url('platform/category').'" class="btn btn-default btn-sm">全部分類</a>';
    $nav .= '<a href="javascript:history.go(-1)" class="pull-right btn btn-default btn-sm"><i class="fa fa-chevron-left"></i> 返回</a>';
    $nav .= '<a href="'.url('platform/category/create').'" class="pull-right btn btn-default btn-sm">添加分類</a>';
    $content->row($nav);
  }
}
