<?php


namespace App\Http\Controllers;


use App\Models\Config;
use App\Models\SendRecords;
use App\Service\ActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
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

    public function mysqlLock(Request $request)
    {
        $mobile    = $request->input('mobile', '13711111111');
        DB::transaction(function ()use($mobile){
            $model = SendRecords::query()->where('mobile',$mobile)->where('created_at','>',date('Y-m-d H:i:s', time() - 60))->lockForUpdate()->first();
            if ($model){
                throw new \Exception('一分钟后重试');
            }
            $code = mt_rand(1000,9999);
            SendRecords::query()->create([
                'mobile' => $mobile,
                'code' => $code,
            ]);
        });
    }

    public function redisLockTest(Request $request)
    {
        $mobile    = $request->input('mobile', '13711111111');
        $existKey = "serve:mobile:{$mobile}";
//        Redis::command('set', [$existKey, "ok", 60]);

        $script = <<<SCRIPT
return redis.call('SET', KEYS[1], ARGV[1], 'NX', 'EX', ARGV[2])
SCRIPT;
        $res = Redis::eval($script, 1,$existKey, 2, 60);//数字1代表键名参数的数量，$existKey是键名参数


        if (!$res){
            return ['data' => [], 'msg' => '请稍后重试'];
        }
        return ['msg'=>'ok'];
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