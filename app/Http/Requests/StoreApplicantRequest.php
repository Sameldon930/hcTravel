<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicantRequest extends FormRequest
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
            'name' => 'required|max:20',
            'age' => 'required',
            'sex' => 'required',
            'apply_position' => 'required',
            'work_experience' => 'required',
            'education' => 'required',
        ];
    }

    public function messages(){
        return [
            'name.required' => '名字不能为空',
            'name.max' => '名字太长',
            'age.required'  => '年龄不能为空',
            'sex.required'  => '性别不能为空',
            'apply_position.required'  => '意向职位不能为空',
            'work_experience.required'  => '工作经验不能为空',
            'education.required'  => '学历不能为空',
        ];
    }
}
