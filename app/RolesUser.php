<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolesUser extends Model
{
    //
    protected $table = 'roles_user';
    protected $fillable = ['roles_id','user_id'];
    public $timestamps = false;
}
