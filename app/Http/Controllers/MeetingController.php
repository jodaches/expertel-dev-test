<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MeetingCreateREquest;
use App\Services\MeetingService;
use App\Models\Meeting;

class MeetingController extends Controller
{
    //
    public function list(Request $request)
    {
        return response()->json(Meeting::all());
    }


    public function create(MeetingCreateREquest $request)
    {
        $data = $request->all();
        $service = new MeetingService;

        //add any parameters you wish
        if ($service->scheduleMeeting($data))
        {
            return response()->json(["message" => "The meeting has been booked"]);
        }
        else
        {
            return response()->json(["message" => "The meeting can not be booked"]);
        }

    }
}
