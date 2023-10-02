<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MeetingService;
use App\Models\Meeting;

class MeetingController extends Controller
{
    //
    public function list(Request $request)
    {
        return response()->json(Meeting::all());
    }


    public function create(Request $request)
    {
        $service = new MeetingService;

        //add any parameters you wish
        if ($service->scheduleMeeting())
        {
            return response()->json(["message" => "The meeting has been booked"]);
        }
        else
        {
            return response()->json(["message" => "The meeting can not be booked"]);
        }

    }
}
