<?php
namespace App\Rules\Recruiter;

use Illuminate\Contracts\Validation\Rule;

class OppositeDraftPublish implements Rule
{
    protected $otherValue;

    public function __construct($otherValue)
    {
        $this->otherValue = filter_var($otherValue, FILTER_VALIDATE_BOOLEAN);
    }

    public function passes($attribute, $value)
    {
        return (bool)$value !== $this->otherValue;
    }

    public function message()
    {
        return 'The :attribute and :other must be opposite.';
    }
}
