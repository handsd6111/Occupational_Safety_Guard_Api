<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Interfaces\IStatusCode;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * 包裝自己的資訊進Response，讓前端有更多資訊可以利用。
     * 
     * @param any $data 欲傳送的資料。
     * @param int $statusCode HTTP狀態碼。
     * @param int $countOfData 總共多少頁。
     * @param int $countOfPage 總共多少頁。
     * @param string $message 要傳送的訊息，有預設值。
     * @param array $headers 標頭陣列。
     */
    public static function sendResponse(
        $data,
        int $statusCode,
        int $countOfData = 0,
        int $countOfPage = 0,
        string $message = null,
        array $headers = [],
    ) {
        if ($message === null) {
            $message = IStatusCode::Message[$statusCode];
        }
        $headers['Content-Type'] = "application/json";
        $result = [
            'data' => $data,
            'statusCode' => $statusCode,
            'message' => $message,
            'countOfData' => $countOfData,
            'countOfPage' => $countOfPage,
        ];
        return Response(json_encode($result), $statusCode, $headers);
    }
}
