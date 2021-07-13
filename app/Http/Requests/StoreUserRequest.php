<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
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



            'name' => 'required',
            'cnic' => 'required',
            'mobile_no' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'role_id' => 'required'



        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors()->all()
        ]));
    }

    public function getAttributes(): array
    {

        return [

            'role_id' =>  $this->role_id,
            'parent_id' => $this->parent_id,
            'master' => $this->master = 0,
            'email' =>  $this->email,
            'name' =>  $this->name,
            'mobile_no' =>  $this->mobile_no,
            'cnic' =>   $this->cnic,
            'password' => $this->password,


        ];
    }
}
