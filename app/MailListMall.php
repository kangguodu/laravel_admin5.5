<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailListMall extends Model
{
    protected $table = 'mail_list_mall';
    protected $fillable = ['id','mall_id','read_status','read_time','mail_id'];
    public $timestamps = false;
}
