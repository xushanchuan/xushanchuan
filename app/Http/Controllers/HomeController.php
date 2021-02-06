<?php


namespace App\Http\Controllers;


use App\Service\ActivityService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    public function index($activityId)
    {
        $result = $this->activityService->getBy($activityId);
        return response()->json($result);
    }

    public function addActivity(Request $request)
    {
        $arr['name'] = $request->input('name');
        $arr['description'] = $request->input('description');
        $result = $this->activityService->add($arr);
        return response()->json($result);
    }
}