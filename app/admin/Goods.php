<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $pk = "goods_id";
    protected $table = "goods_info";

    protected $fillable = ['goods_name','goods_price','goods_num','is_new','is_best','is_hot','is_up','is_describe','goods_img','brand_id','cate_id'];
}
