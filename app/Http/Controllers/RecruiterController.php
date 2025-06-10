<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Job;
use App\Models\JobApply;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\JobSeeker\ApplyJobRequest;
use App\Http\Requests\Recruiter\StoreUpdateRequest;

class RecruiterController extends Controller
{
    use ApiResponser;

    public function getJobs(Request $request)
    {
        try {
            $search = $request->search ?? null;
            $per_page = $request->per_page ?? 10;

            $data = Job::withCount('job_applies')
            ->when($search, function ($query) use ($search) {
                return $query->where('title', 'like', "%{$search}%");
            })
            ->where('user_id', auth()->user()->id)
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
            ->with('job_applies.user')
            ->where('user_id', auth()->user()->id)
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

    public function store(StoreUpdateRequest $request)
    {
        try {
            DB::beginTransaction();

            $job = Job::create([
                'title' => $request->title,
                'description' => $request->description,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'is_draft' => $request->is_draft,
                'is_publish' => $request->is_publish,
                'user_id' => auth()->user()->id,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            DB::commit();
            return $this->successResponse('Success', $job);
        } catch(\Throwable $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function update(StoreUpdateRequest $request, $id)
    {
        try {
            $get_job = Job::where('user_id', auth()->user()->id)
            ->where('id', $id)
            ->first();

            if(!$get_job) {
                return $this->errorResponse('Data not found', 404);
            }

            $get_job->update([
                'title' => $request->title,
                'description' => $request->description,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'is_draft' => $request->is_draft,
                'is_publish' => $request->is_publish,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            return $this->successResponse('Success', $get_job);
        } catch(\Throwable $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $get_job = Job::where('user_id', auth()->user()->id)
            ->where('id', $id)
            ->first();

            if(!$get_job) {
                return $this->errorResponse('Data not found', 404);
            }

            $get_job->job_applies()->delete();
            $get_job->delete();
            return $this->successResponse('Success', $get_job);
        } catch(\Throwable $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
