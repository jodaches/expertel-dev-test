<?php
namespace App\Services;

use App\Models\Meeting;


class MeetingService 
{

    /**
     * 
     *  MODIFY THIS FUNCTION TO YOUR LIKING
     * YOU CAN ADD AS MANY PARAMETERS AS YOU WANT
     * @param Array $data with Meeting's fillable properties 
     * @return boolean true on sucess
     */

    public function scheduleMeeting($data)
    {
        //check that the meeting doesn't have any conflict
        //IT ALLOWS TO START A MEETING EXACTLY AT THE END OF ANOTHER MEETING
        //IT ALLOWS TO END A MEETING EXACTLY AT THE START OF ANOTHER MEETING
        $startTime = $data['start_time'];
        $endTime = $data['end_time'];

        $existingMeeting = Meeting::where('user_id', $data['user_id'])        
            ->where(function($query) use($startTime, $endTime){
                //START INSIDE OTHER METTINGS
                $query->where(function($q) use ($startTime){
                    $q->where('start_time','=<', $startTime)
                        ->where('end_time','>', $startTime);
                })//END INSIDE OTHER METTINGS            
                ->orWhere(function($q) use($endTime){
                    $q->where('start_time','<', $endTime)
                        ->where('end_time','>=', $endTime);
                })
                //EXISTING MEETINGS INSIDE START AND END
                ->orWhere(function($q) use($endTime, $startTime){
                    $q->where('start_time','>', $startTime)
                        ->where('end_time','<', $endTime);
                });
            })                        
            ->first();

        if(!empty($existingMeeting)){
            return false;
        }

        //save the meeting to the database
        $meeting = Meeting::create($data);

        return true;
    }
}