<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApartmentRentRequest extends FormRequest
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
            'rental'=>'required|numeric',
            'house_type'=>'required',
            'payment_mode'=>'required',
            'region'=>'required',
            'mobile'=>'required',
            'content'=>'required',

        ];
    }

    public function messages()
    {
        return [
            'rental.required' => '输入的租金不能为空且必须为数字',
            'house_type.required'=>'房租类型不能为空',
            'payment_mode.required'=>'支付方式不能为空',
            'region.required'=>'所属区域不能为空',
            'mobile.required'=>'联系方式不能为空',
            'content.required'=>'招租详情不能为空',
        ];
    }
}
