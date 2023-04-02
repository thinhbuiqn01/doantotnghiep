<?php

namespace App\Http\Controllers;

use App\Models\Technology;
use App\Http\Requests\StoreTechnologyRequest;
use App\Http\Requests\UpdateTechnologyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tech = Technology::all();
        if ($tech) {
            return response([
                'tech' => $tech
            ]);
        } else {
            return response(['status' => 'false']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTechnologyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $tech =  Technology::create([
            'name' => $data['name'],
            'description' => $data['detail'],
            'status' => $data['status'],
            'link_page' => $data['linkWebsite'],

        ]);
        $tech->save();
        return response($tech);
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

                Technology::where('id', $id)
                    ->update(['image' =>  $filename]);
            }

            $response["status"] = "successs";
            $response["message"] = "Success! image(s) uploaded";
        } else {
            $response["status"] = "failed";
            $response["message"] = "Failed! image(s) not uploaded";
        }

        return response($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function show(Technology $technology)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTechnologyRequest  $request
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTechnologyRequest $request, Technology $technology)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function destroy(Technology $technology)
    {
        //
    }
}
