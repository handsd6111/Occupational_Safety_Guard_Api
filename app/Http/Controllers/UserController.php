<?php

namespace App\Http\Controllers;

use App\Models\Interfaces\IStatusCode;
use App\Models\RefreshToken;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * 建立一個新的使用者
     * 
     * @param Request $request 使用者請求
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function create(Request $request)
    {
        // 建立Validation規則。
        $validator = Validator::make($request->all(), [
            'account' => 'required|string|min:4|max:20|unique:users,account',
            'password' => 'required|string|min:8|max:30',
            'username' => 'required|string|max:20',
            'email' => 'required|string|max:35|unique:users,email',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), IStatusCode::BAD_REQUEST);
        }

        // 利用argon2id為密碼做雜湊後才進資料庫
        $hashed_password = password_hash(
            $request['password'],
            PASSWORD_ARGON2ID,
            ['memory_cost' => 1024, 'time_cost' => 20]
        );

        // 先建立一個User的Object。
        $user = User::firstOrNew([
            'account' => $request['account'],
            'password' => $hashed_password,
            'name' => $request['username'],
            'email' => $request['email'],
            'enabled' => true
        ]);

        // 取得user的角色。
        $roleUser = Role::find('user');

        DB::transaction(function () use ($user, $roleUser) {
            // 將先前建立的User Object寫入資料庫。
            $user->save();
            // 預設指派user的角色給新建立的使用者。
            $user->roles()->save($roleUser);
        });

        // 送出建立成功的Response。
        return $this->sendResponse([], IStatusCode::CREATED);
    }

    public function getUserHasSubscribe(Request $request)
    {
        $user = $this->getUserByJwt($request);
        // return $user->subscribe;
        return $this->sendResponse((bool)$user->subscribe, 200, 1, 1);
    }

    public function subscribeAccident(Request $request)
    {
        // 建立Validation規則。
        $validator = Validator::make($request->all(), [
            'subscribe' => 'required|bool',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), IStatusCode::BAD_REQUEST);
        }

        $user = $this->getUserByJwt($request);
        $user->subscribe = $request['subscribe'];
        $user->save();
        
        return $this->sendResponse((bool)$user->subscribe, 200, 1, 1);
    }

    public function getUserByJwt($request)
    {
        // 取得Request的Header。
        $header = $request->header('authorization');

        // 從Header中取得JWT。
        $jwt = str_replace("Bearer ", '', $header);

        // 驗證JWT，若沒問題則取得Payload的部分，內部包含使用者資訊。
        $userInfo = TokenController::verifyAndBase64DecodeJwt($jwt);

        // 驗證失敗。
        if ($userInfo === false) {
            return $this->sendResponse('JWT錯誤', IStatusCode::BAD_REQUEST);
        }

        // 取得指定使用者。
        return User::where('id', $userInfo->userId)->first();
    }
}
