<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDecorationPost extends FormRequest
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
            'title' => 'required|max:255',
            'type' => 'required',
            'name' => 'required|max:255',
            'mobile' => 'required|max:25',
            'top' => 'required',
            'content' => 'required',
        ];
    }

    public function messages(){
        return [
            'title.required' => '标题不能为空',
            'title.max' => '标题太长',
            'name.required' => '店名不能为空',
            'name.max' => '店名太长',
            'mobile.required' => '联系电话不能为空',
            'mobile.max' => '联系电话太长',
            'top.required' => '请选择是否置顶',
            'content.required'  => '内容不能为空',
        ];
    }
}
