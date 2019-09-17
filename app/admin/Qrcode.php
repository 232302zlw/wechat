<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;

class Qrcode extends Model
{
    protected $pk = 'qrcode_id';
    protected $table = 'wechat_qrcode';
    public $timestamps = false;
}
