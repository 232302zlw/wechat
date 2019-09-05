<?php

namespace App\index;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $pk = "id";
    protected $table = "users";
}
