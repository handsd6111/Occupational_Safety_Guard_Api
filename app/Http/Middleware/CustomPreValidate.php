<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Interfaces\IStatusCode;

class CustomPreValidate
{
    /**
     * Request進來預先做驗證，看page跟count是否有照規則傳輸。
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $validator = Validator::make($request->all(), [
            'page' => 'required|integer|min:1',
            'count' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return Controller::sendResponse($validator->errors(), 400, IStatusCode::BAD_REQUEST);
        }

        $request['page'] -= 1; // SQL從0開始計算，想讓使用者從1開始，所以進來的值要減一。

        return $next($request); // 將request向後傳。
    }
}
