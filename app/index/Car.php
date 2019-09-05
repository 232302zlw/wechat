<?php

namespace App\index;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $pk = "car_id";
    protected $table = "car_info";
}
