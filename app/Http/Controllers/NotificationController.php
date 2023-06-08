<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeInform(Request $request)
    {
        $inform = request()->all();
        $nofity = Notification::create([
            'user_id' => $inform['user_id'],
            'job_id' => $inform['job_id'],
            'name' => $inform['name'],
            'description' => $inform['description']
        ]);
        if ($nofity) {
            return response([
                "data" => $nofity
            ]);
        } else {

            return response([
                "data" => []
            ]);
        }
    }
    public function storeInformJob(Request $request)
    {
        $inform = $request->all();
        $nofity = Notification::create([
            'name' => $inform['name'],
            'description' => $inform['description'],
            'job_id' => $inform['job_id'],
            'role_take' => $inform['role_take'],
            'status' => $inform['status'],
        ]);
        return response(
            ['status' => $nofity]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNotificationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function storeInforms(StoreNotificationRequest $request)
    {
    }

    public function informJobSchool()
    {
        $inform = Notification::where('role_take', 2)->get();
        return response([
            'notification' => $inform
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        //
    }

    public function showNotify($idUser)
    {
        $notify = Notification::where('id_user', $idUser)->get();
        return response($notify);
    }

    public function addNotify(Request $request)
    {
        $nofity = Notification::create([
            'user_id' => $request['user_id'],
            'job_id' => $request['job_id'],
            'user_id' => $request['user_id'],
            'description' => $request['description'],
            'status' => $request['status'],
        ]);
        return response([
            'message' => 'success',
        ]);
    }

    public function destroyNotify($id)
    {
        $inform = Notification::find($id);
        $inform->delete();
        return response([
            "message" => "success"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNotificationRequest  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inform = Notification::find($id);
        $inform->delete();
        return response([
            'status' => 200
        ]);
    }
}
