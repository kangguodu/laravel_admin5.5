<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailList extends Model
{
    //
    protected $table = 'mail_list';
    protected $fillable = ['content_type','title','content','status','sender','send_time','update_time','update_by'];
    public $timestamps = false;
}
