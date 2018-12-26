<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSidePost extends FormRequest
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
            'note' => 'required',
            'url' => 'required',
            'orderby'=> 'required|numeric',
        ];
    }

    public function messages(){
        return [

            'orderby'=> '排序值不能为空',
            'note.required' => '备注不能为空',
            'url.required' => '链接不能为空',
        ];
    }
}
