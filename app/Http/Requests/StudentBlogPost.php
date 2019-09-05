<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentBlogPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            's_name'=>'required|unique:info|max:4',
            's_age'=>'required|numeric'
        ];
    }

    public function message()
    {
        return[
            's_name.required'=>'学生姓名不能为空',
            's_name.unique'=>'学生姓名已存在',
            's_name.max'=>'学生姓名最大4位',
            's_age.required'=>'学生年龄不能为空',
            's_age.numeric'=>'学生年龄只能是数字'
        ];
    }
}
