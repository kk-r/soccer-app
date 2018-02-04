<?php

namespace App\Http\Requests;

class PlayerRequest extends BaseRequest
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
            'logo_url' => 'present|nullable|URL',
            'first_name' => 'required|string|min:3|max:255',
            'last_name' => 'required|string|max:255',
            'team_id' => 'present|nullable|exists:teams,id'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'logo_url.u_r_l' => ':attribute is not a valid URL'
        ];
    }
}
