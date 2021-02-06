<?php
namespace App\Http\Traits;

trait ResponseTrait
{
    public function success(...$data)
    {
        if (is_array($data[0])) {
            $msg = '';
            $data = $data[0];
            if (isset($data['msg'])) {
                $msg = $data['msg'];
                unset($data['msg']);
            }
        } else {
            $msg = $data[0];
            $data = '';
        }
        return response([
            'code' => 0,
            'message' => !empty($msg) ? $msg : '成功',
            'data' => !empty($data) ? $data : null,
        ]);
    }

    public function error($message = '失败')
    {
        return response([
            'code' => 500,
            'message' => $message,
            'data' => null,
        ]);
    }

    /**
     * @param $data
     * @param array $header
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseJson($data, $header = [])
    {
        return response()->json($data, 200, $header);
    }

    /**
     * @param int $code
     * @param string $message
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnJson($code = 0, $message = 'ok', $data = [])
    {
        $returnData = [
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];
        return $this->responseJson($returnData);
    }

    /**
     * 返回成功的json
     * @param $data
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function successJson($data, $message = 'ok')
    {
        return $this->returnJson(0, $message, $data);
    }

}
