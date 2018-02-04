<?php

namespace App\Http\Requests;

class TeamRequest extends BaseRequest
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
            'name' => 'required|string|min:3|max:255',
            'logo_url' => 'present|nullable|URL',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.max' => 'Name maximum size is exceeded',
            'logo_url.u_r_l' => ':attribute is not a valid URL'
        ];
    }
}
