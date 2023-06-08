<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Business;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = Job::orderBy('created_at', 'desc')->get();
        if ($jobs) {
            return response([
                'jobs' => $jobs,
            ]);
        } else {
            return response([
                'fail'
            ]);
        }
    }

    public function jobOfBusiness($id)
    {
        $jobs = Job::where('business_id', '=', $id)->get();

        return response($jobs);
    }


    public function jobInfo($id)
    {
        $job = Job::find($id);
        return response([
            'job' => $job
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function deleteInform(Request $request)
    {
        $res = $request->all();

        $inform = Notification::where('role_take', "=", $res['role_take'])
            ->where('job_id', "=", $res['job_id'])
            ->delete();
        return response([
            'inform' => $inform
        ]);
    }

    public function jobsConfirm()
    {
        $jobs = DB::table('jobs')
            ->where('jobs.status', '=', 1)
            ->join('businesses', 'businesses.id', '=', 'jobs.business_id')
            ->select(
                'jobs.*',
                'businesses.image',
            )
            ->orderBy('jobs.created_at', 'desc')->get();
        return response([
            'jobs' => $jobs
        ]);
    }

    public function jobFull()
    {
        $jobs = Job::join('businesses', 'businesses.id', '=', 'jobs.business_id')
            ->orderBy('jobs.created_at', 'desc')
            ->get();
        return response($jobs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreJobRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jobs = $request->all();

        $data = Job::create([
            'name_job' => $jobs['name'],
            'description' => $jobs['description'],
            'require_job' => $jobs['requireJob'],
            'location' => $jobs['locationWork'],
            'tech_using' => $jobs['techUsing'],
            'email_give' => $jobs['emailGiveCV'],
            'business_id' => $jobs['business_id'],
            'status' => $jobs['status'],
        ]);

        return response([
            'data' => $data
        ]);
    }

    public function topStudentHire()
    {

        $user = DB::table('hires')
            ->join('users', 'users.id', '=', 'hires.user_id')
            ->select(
                'hires.id',
                'hires.job_id',
                'hires.user_id',
                'users.email',
                'users.name',
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('hires.user_id')
            ->get();
        return response($user);
    }

    public function topHirePost()
    {
        $post = DB::table('hires')
            ->join('jobs', 'jobs.id', '=', 'hires.job_id')
            ->select(
                'hires.id',
                'hires.job_id',
                'hires.business_id',
                'hires.job_id',
                'jobs.location',
                'jobs.name_job',
                'jobs.created_at as ngayDang',
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('hires.job_id')
            ->get();
        return response($post);
    }

    public function topHireBusiness()
    {
        $post = DB::table('jobs')
            ->join('businesses', 'businesses.id', '=', 'jobs.business_id')
            ->select('businesses.id', 'jobs.business_id', 'businesses.location', 'businesses.name', DB::raw('COUNT(*) as count'))
            ->groupBy('jobs.business_id')
            ->get();
        return response($post);
    }

    public function editStatusJob(Request $request, $idJob)
    {
        $res = $request->all();
        $job = Job::find($idJob);

        $job->status = $res['status'];

        $job->update();

        return response([
            'job' => $job
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show($job)
    {
        $jobs = Job::where('user_id', $job)->orderBy('updated_at', 'desc')->get();
        if ($jobs) {
            return response([
                'data' => 'Hiện công ty chưa có bài tuyển nào'
            ]);
        } else {
            return response([
                'jobs' => $jobs
            ]);
        }
    }

    public function jobByBusiness($id)
    {
        $jobs = Job::where('business_id', $id)->get();
        return response($jobs);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJobRequest  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $job)
    {
        $updateJob = $request->all();
        $job = Job::find($job);
        $job->name_job = $updateJob['name_job'];
        $job->tech_using = $updateJob['tech_using'];
        $job->description = $updateJob['description'];
        $job->require_job = $updateJob['require_job'];
        $job->email_give = $updateJob['email_give'];

        $job->update();
        return response([
            'jobEdit' => $job
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        //
    }


    public function jobHot()
    {

        $jobs = Job::join('businesses', 'jobs.business_id', '=', 'businesses.id')
            ->orderBy('jobs.updated_at', 'desc')
            ->get(array(
                'updated_at' => 'jobs.updated_at',
                'business_id' => 'jobs.business_id',
                'nameJob' => 'jobs.name_job',
                'nameCompany' => 'businesses.name',
                'idJob' => 'jobs.id'
            ));
        return response([
            'jobs' => $jobs
        ]);
    }
}
