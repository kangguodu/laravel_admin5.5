<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlatformRule extends Model
{
    //
    protected $table = 'platform_rules';
    protected $fillable = ['rule_type','rule_title','updated_by','updated_at','content','rule_group'];
    public $timestamps = false;
}
