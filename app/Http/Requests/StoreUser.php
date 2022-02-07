<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
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
        // return [
        //     'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        // ];

        $rules = [
            //
           ];

        if(request('password'))
        {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        return $rules;
    }

}