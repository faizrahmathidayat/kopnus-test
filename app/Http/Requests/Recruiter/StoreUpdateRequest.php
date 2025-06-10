<?php

namespace App\Http\Requests\Recruiter;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Traits\ApiResponser;
use App\Rules\Recruiter\OppositeDraftPublish;

class StoreUpdateRequest extends FormRequest
{
    use ApiResponser;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'start_at' => 'required|date_format:Y-m-d H:i:s',
            'end_at' => 'required|date_format:Y-m-d H:i:s|after:start_at',
            'is_draft' => [
                'required',
                'boolean',
                new OppositeDraftPublish($this->is_publish)
            ],
            'is_publish' => [
                'required',
                'boolean',
                new OppositeDraftPublish($this->is_draft)
            ]
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorResponse('The data provided is invalid',422, $validator->errors()));
    }

    public function messages()
    {
        return array(
            'required' => ':attribute can\'t be empty.'
        );
    }
}
