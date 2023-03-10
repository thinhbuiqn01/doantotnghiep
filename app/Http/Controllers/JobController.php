<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $jobs = Job::all();
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
    public function create()
    {
        //
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show($job)
    {
        $jobs = Job::where('business_id', $job)->get();
        if (!$jobs) {
            return response([
                'data' => 'Hiện công ty chưa có bài tuyển nào'
            ]);
        } else {
            return response([
                'jobs' => $jobs
            ]);
        }
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
                'nameJob' => 'jobs.name_job',
                'nameCompany' => 'businesses.name',
                'idJob' => 'jobs.id'
            ));
        return response([
            'jobs' => $jobs
        ]);
    }
}
