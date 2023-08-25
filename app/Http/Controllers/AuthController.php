<?php

namespace App\Http\Controllers;

use App\Models\Interfaces\IStatusCode;
use App\Models\RefreshToken;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    const accessTokenExpireTime = 30 * 60;
    const refreshTokenExpireTime = 60 * 60;

    /**
     * 使用者登入
     * 
     * @param Request $request 使用者請求
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function login(Request $request)
    {
        // 建立Validation規則。
        $validator = Validator::make($request->all(), [
            'account' => 'required|string|exists:users,account',
            // 'email' => 'required|string|exists:members,email|min:8|max:30|regex:/(.+)@(.+)\.(.+)/i',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), IStatusCode::BAD_REQUEST);
        }

        // 取得指定帳號的使用者。
        $user = User::where('account', $request['account'])->first();
        
        // 建立Access Token與Refresh Token。
        $accessItem = self::generateAccessItem($user);
        $refreshToken = RefreshToken::firstOrCreate([
            'id' => $accessItem['refresh_token'],
            'user_id' => $user->id,
            'expired_time' => date('Y-m-d H:i:s', now()->timestamp + self::refreshTokenExpireTime)
        ]);
        DB::transaction(function () use ($user, $refreshToken) {
            $user->refreshTokens()->save($refreshToken);
        });

        // 利用password_verify function來驗證hash過的密碼是否與Request中的一致。
        if (password_verify($request['password'], $user->password)) {
            return $this->sendResponse($accessItem, IStatusCode::OK);
        } else {
            return $this->sendResponse(['password' => 'Your password is wrong.'], IStatusCode::BAD_REQUEST);
        }
    }
    
    /**
     * 更新原有的Access Token。
     * 
     * @param Request $request 使用者請求
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function refreshToken(Request $request)
    {
        // 取得Request的Header。
        $header = $request->header('authorization');

        // 從Header中取得JWT。
        $jwt = str_replace("Bearer ", '', $header);

        // 將JWT新增至Request中，以便後面進行驗證。
        $request['access_token'] = $jwt;

        // 建立Validation規則。
        $validator = Validator::make($request->all(), [
            'access_token' => 'required|string',
            'refresh_token' => 'required|string|exists:refresh_tokens,id'
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), IStatusCode::BAD_REQUEST);
        }

        // 驗證JWT，若沒問題則取得Payload的部分，內部包含使用者資訊。
        $userInfo = TokenController::verifyAndBase64DecodeJwt($request['access_token']);

        // 驗證失敗。
        if ($userInfo === false) {
            return $this->sendResponse([], IStatusCode::BAD_REQUEST);
        }

        // 取得指定使用者。
        $user = User::where('id', $userInfo->userId)->first();

        // 尋找Request中的Refresh Token。
        $refreshToken = $user->refreshTokens()->find($request['refresh_token']);

        // 若Refresh Token過期，則回傳HTTP Code 401。
        if ($refreshToken->expired_time < now()->timestamp) {
            return $this->sendResponse([], IStatusCode::UNAUTHORIZED, "Your token has expired");
        }
        // 建立Access Token與Refresh Token。
        $accessItem = self::generateAccessItem($user);

        // 更新原本的Refresh Token即可。
        $refreshToken->id = $accessItem['refresh_token'];
        $refreshToken->expired_time = date('Y-m-d H:i:s', now()->timestamp + self::refreshTokenExpireTime);
        DB::transaction(function () use ($refreshToken) {
            $refreshToken->save();
        });

        // 回傳登入資訊。
        return $this->sendResponse($accessItem, IStatusCode::OK);
    }


    /**
     * 建立Access Token與Refresh Token。
     * 
     * @param User $user 傳入一個User的Model，使用在JWT Payload中。
     * 
     * @return [
     *      'access_token' => 'jwt string',
     *      'refresh_token' => 'refresh token string',
     *  ];
     */
    private function generateAccessItem(User $user)
    {
        // 先取得目前時間
        $now = now()->timestamp;
        // 建立Payload物件，裡面包含傳入的$user參數資訊。
        $accessTokenData = [
            'iss' => 'osga_api',
            'iat' => $now, // 發行時間
            'nbf' => $now, // 定義在什麼時間之前，該jwt都是不可用的
            'exp' => $now + self::accessTokenExpireTime, // 過期時間
            'userId' => $user->id, // 使用者編號
            'userAccount' => $user->account, // 使用者帳號
            'userEmail' => $user->email, // 使用者信箱
            'userName' => $user->name, // 使用者名稱
            'userRoles' => [] // 使用者所擁有的角色，先為空，後續加入
        ];

        // 將使用者所擁有的角色加入至userRoles中。
        foreach ($user->roles as $role) {
            $accessTokenData['userRoles'][] = $role->id;
        }

        $accessJwt = TokenController::generateJwt($accessTokenData);
        $refreshToken = TokenController::generateRefreshToken();

        $data = [
            'access_token' => $accessJwt,
            'refresh_token' => $refreshToken,
        ];
        return $data;
    }
}
