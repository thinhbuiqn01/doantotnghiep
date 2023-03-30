<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessStoreRequest;
use App\Http\Requests\BusinessUpdateRequest;
use App\Models\Business;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  
    }
    public function bsnHot()
    {
        $business = DB::table('businesses')
            ->join('jobs', 'jobs.business_id', '=', 'businesses.id')
            ->select(DB::raw('businesses.id, businesses.name, businesses.description, businesses.location, businesses.image , COUNT(jobs.business_id) AS total_job'))
            ->groupBy('jobs.business_id')
            ->orderBy('jobs.business_id')
            ->limit(4)
            ->get();


        /* $jobs = DB::table('jobs')
            ->selectRaw('business_id, count(business_id) as job_count')
            ->join('businesses', 'jobs.business_id', '=', 'businesses.id')
            ->groupBy('business_id')
            ->orderByDesc('job_count')
            ->limit(4)
            ->get(); */

        return  $business;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $info = $request->all();
        $data = Business::create([
            "name" =>  $info['name'],
            "scales" =>  $info['scales'],
            "description" =>  $info['description'],
            "location" =>  $info['location'],
            "link_website" =>  $info['link_website'],
            "task" =>  $info['task'],
            "image" => '',
            "user_id" =>  $info['user_id'],
        ]);
        //return response($info);
    }
    public function storeImage(Request $request, $id)
    {
        $response = [];
        $validator = Validator::make(
            $request->all(),
            [
                'images' => 'required',
                'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]
        );

        if ($validator->fails()) {
            return response()->json(["status" => "failed", "message" => "Validation error", "errors" => $validator->errors()]);
        }
        $info = $request->all();
        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . rand(3, 9) . '.' . $image->getClientOriginalExtension();
                $image->move('uploads/', $filename);

                Business::where('user_id', $id)
                    ->update(['image' =>  $filename]);
            }

            $response["status"] = "successs";
            $response["message"] = "Success! image(s) uploaded";
        } else {
            $response["status"] = "failed";
            $response["message"] = "Failed! image(s) not uploaded";
        }
        $business = Business::where('user_id', $id)->get();

        return response()->json($business);
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
    public function update(BusinessUpdateRequest $request, $id)
    {
        //
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
}
