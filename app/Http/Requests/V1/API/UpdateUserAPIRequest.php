<?php

namespace App\Http\Requests\V1\API;

use App\Models\V1\User;
use InfyOm\Generator\Request\APIRequest;

class UpdateUserAPIRequest extends APIRequest
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
            'username' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $this->user . '|unique:admins,email,' .   $this->user  . '|',
            'password' => 'nullable|'
        ];
    }
}
