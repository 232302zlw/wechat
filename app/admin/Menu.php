<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $pk = 'id';
    protected $table = 'wechat_menu';
    public $timestamps = false;
}
