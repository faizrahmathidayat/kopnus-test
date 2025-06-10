<?php

namespace App\Http\Requests\JobSeeker;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Traits\ApiResponser;

class ApplyJobRequest extends FormRequest
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
            'job_id' => [
                'required',
                'exists:jobs,id,is_publish,1',
                new \App\Rules\JobSeeker\CheckDuplicateApplyJob
            ],
            'attachment' => 'required|mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document|max:2048'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorResponse('The data provided is invalid',422, $validator->errors()));
    }

    public function messages()
    {
        return array(
            'required' => ':attribute can\'t be empty.',
            'exists' => ':attribute not found.'
        );
    }

    public function attributes()
    {
        return array(
            'job_id' => 'Vacancy'
        );
    }
}
