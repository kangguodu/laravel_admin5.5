<?php

namespace App\Admin\Controllers;

use App\Member;use App\Malls;use App\Orders;use App\Goods;
use App\Regions;use App\Activity;use App\Staple;
use App\Http\Controllers\Controller;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Chart\Bar;
use Encore\Admin\Widgets\Chart\Doughnut;
use Encore\Admin\Widgets\Chart\Line;
use Encore\Admin\Widgets\Chart\Pie;
use Encore\Admin\Widgets\Chart\PolarArea;
use Encore\Admin\Widgets\Chart\Radar;
use Encore\Admin\Widgets\Collapse;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Widgets\Table;
use yii\rbac\Permission;

class HomeController extends Controller
{
    public function index()
    {
        // \Encore\Admin\Auth\Permission::deny(['rebate']);
        return Admin::content(function (Content $content) {

            $content->header('首页');
            $content->description('laravel后台管理系统');

            $content->row(function ($row) {
                // $row->column(3, new InfoBox('會員數量', 'users', 'aqua', url('platform/member'), Member::count()));
                // $row->column(3, new InfoBox('入駐店鋪', 'bank', 'green', url('platform/store'), Malls::count()));
                // $row->column(3, new InfoBox('商品數量', 'shopping-bag', 'yellow', url('platform/goods'), Goods::count()));
                // $row->column(3, new InfoBox('訂單數量', 'file', 'red', '#', Orders::count()));
            });
            $content->row(function ($row)
            {
              // $row->Column(4,new InfoBox('覆蓋主要市縣','map','blue',url('platform/area'),Regions::where('parent_id',1)->count()));
              // $row->Column(4,new InfoBox('活動數量','bullhorn','orange',url('platform/activity'),Activity::count()));
              // $row->Column(4,new InfoBox('主營商品類目','tag','purple',url('platform/staple'),Staple::count()));
            });
        });
    }
}
