<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenchantRequest extends FormRequest
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
            'mobile' => 'required|numeric|digits_between:8,16',

        ];
    }

    public function messages()
    {
        return [
            'mobile.required' => '负责人电话不能为空',
            'mobile.digits_between' => '负责人电话长度不对',
            'mobile.numeric' => '负责人电话必须为数字',

        ];
    }
}
