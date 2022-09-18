<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    /**
     * Determine if the driver is authorized to make this request.
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
        $rules = array();

        switch ($this->method()) {
            case 'POST':

                $rules = [
                    'title'  => ['required', 'string', 'max:191'],
                    'hashtag'  => ['nullable', 'string', 'max:191'],
                    'description'  => ['required', 'string'],
                    'image'  => ['image', 'mimes:jpg,jpeg,gif,png', 'max:2048'],
                ];
                return $rules;

            case 'PUT':

                $rules = [
                    'title'  => ['required', 'string', 'max:191'],
                    'hashtag'  => ['nullable', 'string', 'max:191'],
                    'description'  => ['required', 'string'],
                    'image'  => ['image', 'mimes:jpg,jpeg,gif,png', 'max:2048'],
                ];

                return $rules;

            default:
                # code...
                break;
        }
    }
}
