<?php

namespace App\Rules\JobSeeker;

use Illuminate\Contracts\Validation\Rule;
use App\Models\JobApply;

class CheckDuplicateApplyJob implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */

    public function passes($attribute, $value)
    {
        $data = JobApply::where([
            'job_id' => $value,
            'user_id' => auth()->user()->id
        ])
        ->first();

        if($data) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You have already applied for this job';
    }
}