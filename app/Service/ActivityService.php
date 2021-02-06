<?php


namespace App\Service;


use App\Models\Activity;

class ActivityService
{
    public function getBy($activityId)
    {
        return Activity::query()->find($activityId);
    }

    public function add($arr)
    {
        return Activity::query()->create([
            'name' => $arr['name'],
            'description' => $arr['description'],
        ]);
    }
}