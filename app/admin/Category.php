<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $pk = "cate_id";
    protected $table = "category_info";
    /* 指示模型是否自动维护时间戳 */
    public $timestamps = false;
}
