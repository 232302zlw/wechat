<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // protected $primaryKey = "user_id";
    protected $pk = "user_id";
    protected $table = "user_info";
    protected $fillable = ['user_name','user_pwd','headimg','create_time'];
    public $timestamps = false;

    public static function getUser($where,$orderFiled,$pageSize,$order='asc')
    {
    	// dd($pageSize);
    	return self::where($where)->orderBy($orderFiled,$order)->paginate($pageSize);
    }

}
