<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlatformUser extends Model
{
    protected $table = 'platform_user';
    protected $fillable = ['username', 'name', 'password', 'email',  	'created_at', 	'updated_at' ];
}
