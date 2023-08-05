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
     *                 @OA\Property(
     *                     property="account",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="username",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 example=
     *                 {
     *                      "account": "m01", 
     *                      "password": "p@ssW0rD",
     *                      "username": "m01Name",
     *                      "email": "m01@gmail.com"
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response=201, 
     *          description="建立資料成功。",
     *          content={
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  example= {
     *                      {
     *                          "data": {},
     *                          "statusCode": 201,
     *                          "message": "建立資料成功。",
     *                          "countOfData": 0,
     *                          "countOfPage": 0
     *                      }
     *                  }
     *              ),
     *          }
     *     )
     * )
     */
    public function create(Request $request);
}
