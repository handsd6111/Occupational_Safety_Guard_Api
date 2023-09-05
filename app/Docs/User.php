<?php

namespace App\Docs;

use Illuminate\Http\Request;

interface User extends Info
{
    /**
     * @OA\Post(
     *     tags={"使用者"},
     *     path="/api/auth/register",
     *     summary="註冊",
     *     description="註冊一個新的使用者",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"account", "password", "username", "email"},
     *                 @OA\Property(
     *                     property="account",
     *                     type="string",
     *                     example="m001"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     example="p@ssW0rD"
     *                 ),
     *                 @OA\Property(
     *                     property="username",
     *                     type="string",
     *                     example="m001Name"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="m001@gmail.com"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201, 
     *         description="建立資料成功。",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object"
     *             ),
     *             @OA\Property(
     *                 property="statusCode",
     *                 type="integer",
     *                 example=201
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="建立資料成功。"
     *             ),
     *             @OA\Property(
     *                 property="countOfData",
     *                 type="integer",
     *                 example=0
     *             ),
     *             @OA\Property(
     *                 property="countOfPage",
     *                 type="integer",
     *                 example=0
     *             )
     *         )
     *     )
     * )
     */
    public function create(Request $request);

    /**
     * @OA\Get(
     *     tags={"使用者"},
     *     path="/api/users",
     *     summary="取得使用者",
     *     description="取得使用者的資訊",
     *     security={{"api_jwt_security": {}}},
     *     @OA\Response(
     *         response=201, 
     *         description="建立資料成功。",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object"
     *             ),
     *             @OA\Property(
     *                 property="statusCode",
     *                 type="integer",
     *                 example=201
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="建立資料成功。"
     *             ),
     *             @OA\Property(
     *                 property="countOfData",
     *                 type="integer",
     *                 example=0
     *             ),
     *             @OA\Property(
     *                 property="countOfPage",
     *                 type="integer",
     *                 example=0
     *             )
     *         )
     *     )
     * )
     */
    public function getUser(Request $request);

    /**
     * @OA\Put(
     *     tags={"使用者"},
     *     path="/api/users",
     *     summary="修改使用者訂閱",
     *     description="修改使用者是否訂閱重大職災事件推播",
     *     security={{"api_jwt_security": {}}},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="姓名",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         example="王大明"
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="信箱",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         example="test@gmail.com"
     *     ),
     *     @OA\Parameter(
     *         name="subscribe",
     *         in="query",
     *         description="是否訂閱(1: 訂閱, 0: 取消訂閱)",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         example=1
     *     ),
     *     @OA\Response(
     *         response=201, 
     *         description="建立資料成功。",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object"
     *             ),
     *             @OA\Property(
     *                 property="statusCode",
     *                 type="integer",
     *                 example=201
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="建立資料成功。"
     *             ),
     *             @OA\Property(
     *                 property="countOfData",
     *                 type="integer",
     *                 example=0
     *             ),
     *             @OA\Property(
     *                 property="countOfPage",
     *                 type="integer",
     *                 example=0
     *             )
     *         )
     *     )
     * )
     */
    public function updateUser(Request $request);
}
