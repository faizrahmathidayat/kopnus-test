<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = 'jobs';
    protected $guarded = [];

    public function job_applies()
    {
        return $this->hasMany(JobApply::class, 'job_id', 'id');
    }

    public function job_apply()
    {
        return $this->hasOne(JobApply::class, 'job_id', 'id')->where('user_id', auth()->user()->id);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
