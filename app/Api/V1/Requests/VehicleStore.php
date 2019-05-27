<?php

namespace App\Api\V1\Requests;

use Dingo\Api\Http\FormRequest;

class VehicleStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        // return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'brand_id' => 'required|exists:brands,id'
        ];
    }
}
