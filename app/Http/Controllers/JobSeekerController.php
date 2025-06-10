<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Job;
use App\Models\JobApply;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\JobSeeker\ApplyJobRequest;

class JobSeekerController extends Controller
{
    use ApiResponser;

    public function getVacancies(Request $request)
    {
        try {
            $search = $request->search ?? null;
            $per_page = $request->per_page ?? 10;

            $data = Job::withCount('job_applies')
            ->with('user')
            ->when($search, function ($query) use ($search) {
                return $query->where('title', 'like', "%{$search}%");
            })
            ->where('start_at', '<=', date('Y-m-d H:i:s'))
            ->where('end_at', '>=', date('Y-m-d H:i:s'))
            ->where('is_publish', true)
            ->paginate($per_page);

            return $this->successResponse('Success',$data);
        } catch(\Throwable $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function show($id)
    {
        try {
            $data = Job::withCount('job_applies')
            ->with('user')
            ->where('id', $id)
            ->where('start_at', '<=', date('Y-m-d H:i:s'))
            ->where('end_at', '>=', date('Y-m-d H:i:s'))
            ->where('is_publish', true)
            ->first();

            if(!$data) {
                return $this->errorResponse('Data not found', 404);
            }

            return $this->successResponse('Success',$data);
        } catch(\Throwable $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function appliedJobs(Request $request)
    {
        try {
            $user_id = auth()->user()->id;
            $search = $request->search ?? null;
            $per_page = $request->per_page ?? 10;

            $data = Job::when($search, function ($query) use ($search) {
                return $query->where('title', 'like', "%{$search}%");
            })
            ->whereHas('job_applies', function ($query) use ($user_id) {
                return $query->where('user_id', $user_id);
            })
            ->paginate($per_page);

            return $this->successResponse('Success',$data);
        } catch(\Throwable $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function showApplyJob($id)
    {
        try {
            $data = Job::with(['user','job_apply.user'])
            ->whereHas('job_applies', function ($query) use ($id) {
                return $query->where('user_id', auth()->user()->id);
            })
            ->where('id', $id)
            ->first();

            if(!$data) {
                return $this->errorResponse('Data not found', 404);
            }

            return $this->successResponse('Success',$data);
        } catch(\Throwable $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function applyVacancy(ApplyJobRequest $request)
    {
        try {
            $job_id = $request->job_id;
            $user_id = auth()->user()->id;
            $cover_letter = $request->cover_letter ?? null;
            $attachment = $request->file('attachment');
            $filename = time() . '_' . $attachment->getClientOriginalName();
            $path = $attachment->storeAs('uploads', $filename, 'public');

            $job_apply = JobApply::create([
                'job_id' => $job_id,
                'user_id' => $user_id,
                'cover_letter' => $cover_letter,
                'attachment' => $path,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $job_apply->url_attachment = asset('storage/' . $job_apply->attachment);
            return $this->successResponse('Success', $job_apply);
        } catch(\Throwable $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
