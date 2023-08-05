<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TokenController;
use App\Models\Interfaces\IStatusCode;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $needRole): Response
    {
        // 取得Request的Header。
        $header = $request->header('authorization');
        // 從Header中取得JWT。
        $jwt = str_replace("Bearer ", '', $header);
        // 解包JWT取得使用者資訊。
        $accessItem = TokenController::decodeJwt($jwt);
        // 透過UserId取得指定User。
        $user = User::where('id', $accessItem->userId)->first();
        // 只要有任何一個Role Match到就放行。
        if (count($user->roles->where('id', $needRole)) > 0) {
            return $next($request);
        }
        // 若都沒有Match則表示無權限，則會回傳HTTP Code 403。
        return Controller::sendResponse([], IStatusCode::FORBIDDEN);
    }
}
