<?php

namespace App\Api\V1\Requests;

use Config;
use Dingo\Api\Http\FormRequest;

class SocialLoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'unique:users|max:20',
            'location_id' => 'exists:locations,id',
            'provider' => 'required|in:google,facebook,linkedin',
            'provider_id' => 'required_with:provider',
            'access_token' => 'required_with:provider',
            'image' => 'url'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
