<?php


namespace App\Http\Controllers;


use App\Models\Config;
use App\Service\ActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

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

    public function cacheAdd()
    {
        $result = Cache::add('xushanchuan','123456');
        return $result;
    }

    public function cacheGet()
    {
        return Cache::get('xushanchuan');
    }

    /**
     * 从缓存里获取，获取不到则从数据库设置到缓存中
     * @return mixed
     */
    public function getConfig()
    {
        return Cache::remember('price',500,function (){
           return Config::query()->where('key','price')->value('value');
        });
    }

    public function redisLock()
    {
        $lock = Cache::lock('foo', 10);

        if ($lock->get()) {
            // 获取锁定10秒...

            $lock->release();
        }
    }

    public function storage()
    {
        Storage::put('test.txt','11111');
        Storage::disk('public')->put('test1.txt','2222');
    }

    public function upload(Request $request)
    {
        
        //上传到filesystems文件中设置的public驱动，下的avatars文件夹下，并返回路径：avatars/aU5pJbn4nLn5lgLcFDbY11hFuHuLrFTr5hmS6KGP.png
        $path = $request->file('avatar')->store('avatars','public');
        return $path;
    }
}