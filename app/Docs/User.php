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
}
