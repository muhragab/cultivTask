<?php

namespace App\Http\Requests\V1\API;

use App\Models\V1\Admin;
use Illuminate\Foundation\Http\FormRequest;

class CreateAdminAPIRequest extends FormRequest
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
        return Admin::$rules;
    }
}
