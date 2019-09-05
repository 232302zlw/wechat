<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $table='user_info';
    protected $pk='user_id';
}
