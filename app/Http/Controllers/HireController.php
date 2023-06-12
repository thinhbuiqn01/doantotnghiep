<?php

namespace App\Http\Controllers;

use App\Models\Hire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hire = Hire::all();

        return response($hire);
    }

    public function hireStatusStudent(Request $request)
    {
        $dd = $request->all();
        $hire = Hire::find($dd['id']);
        $hire->status = 0;
        $hire->update();
        return response([
            'message' => 'success',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $response = [];
        $hires = Hire::where('user_id', $data['user_id'])
            ->where('job_id', $data['job_id'])
            ->get();

        if (count($hires) == 0) {

            $hire =  Hire::create([
                'user_id' => $data['user_id'],
                'business_id' => $data['business_id'],
                'job_id' => $data['job_id'],
                'phone_student' => $data['phone_student'],
                'name_student' => $data['name_student'],
                'email_student' => $data['email_student'],
                'status' => $data['status'],
            ]);
            return response($hire);
        } else {
            $response["message"] = 'Bạn đã ứng tuyển, vui lòng chờ kết quả từ nhà tuyển dụng';
            return response([
                'status' => 'error',
                'response' => $response
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateCV(Request $request, $id)
    {
        $response = [];
        if ($id) {

            if ($request->has('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = time() . rand(3, 9) . '.' . $image->getClientOriginalExtension();
                    $image->move('pdf/', $filename);

                    Hire::where('id', $id)
                        ->update(['cv' =>  $filename]);
                }

                $response["status"] = "successs";
                $response["message"] = "Success! image(s) uploaded";
            } else {
                $response["status"] = "failed";
                $response["message"] = "Failed! image(s) not uploaded";
            }

            return response($response);
        } else {
            $response["status"] = "failed";
            $response["message"] = "Failed! image(s) not uploaded";
            return response($response);
        }
    }


    public function hireOfBusiness($idJob)
    {
        $hires = Hire::where('job_id', '=', $idJob)->where('status', '=', 1)->get();
        return response($hires);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    public function exportTopStudentHire($idStudent)
    {
        $users = DB::table('hires')
            ->where('hires.user_id', '=', $idStudent)
            ->join('jobs', 'jobs.id', '=', 'hires.job_id')
            ->select(
                'jobs.name_job',
                'hires.email_student',
                'hires.name_student',
                'hires.created_at as ngayUngTuyen',
                'jobs.created_at as ngayDang',
                'hires.status'
            )
            ->orderBy('hires.created_at', 'DESC')
            ->get();
        return response($users);
    }
    public function exportTopBusinessHire($idBusiness)
    {
        $users = DB::table('hires')
            ->where('hires.business_id', '=', $idBusiness)
            ->join('jobs', 'jobs.id', '=', 'hires.job_id')
            ->join('businesses', 'businesses.id', '=', 'hires.business_id')
            ->select('businesses.name', 'jobs.created_at as ngayDang', 'jobs.location', 'jobs.name_job', DB::raw('COUNT(*) as daUngTuyen'))
            ->groupBy('hires.job_id')
            ->orderBy('ngayDang', 'DESC')
            ->get();

        return response($users);
    }
    public function exportTopJobHire($idJob)
    {

        $jobs = DB::table('hires')
            ->where('hires.job_id', '=', $idJob)
            ->join('jobs', 'jobs.id', '=', 'hires.job_id')
            ->select(
                'jobs.name_job',
                'hires.email_student',
                'hires.name_student',
                'hires.created_at as ngayUngTuyen',
                'jobs.created_at as ngayDang',
                'jobs.location',
                'jobs.email_give'
            )
            ->orderBy('hires.created_at', 'DESC')
            ->get();
        return response($jobs);
    }
}
