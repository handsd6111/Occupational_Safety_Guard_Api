<?php

namespace App\Docs;

use Illuminate\Http\Request;

interface Auth extends Info
{
    /**
     * @OA\Post(
     *     tags={"授權"},
     *     path="/api/auth/login",
     *     summary="登入",
     *     description="登入現有的使用者，並透過JWT操作其他需授權API",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"account", "password"},
     *                 @OA\Property(
     *                     property="account",
     *                     type="string",
     *                     example="test"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     example="testtest"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response=200, 
     *          description="請求成功。",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="access_token",
     *                      type="string",
     *                      example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9..."
     *                  ),
     *                  @OA\Property(
     *                      property="refresh_token",
     *                      type="string",
     *                      example="99d0be99-9ca4-4283-8b22-37046bf3de22"
     *                  )
     *              ),
     *              @OA\Property(
     *                  property="statusCode",
     *                  type="integer",
     *                  example=200
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="請求成功。"
     *              ),
     *              @OA\Property(
     *                  property="countOfData",
     *                  type="integer",
     *                  example=0
     *              ),
     *              @OA\Property(
     *                  property="countOfPage",
     *                  type="integer",
     *                  example=0
     *              )
     *          )
     *     )
     * )
     */
    public function login(Request $request);

    /**
     * @OA\Post(
     *     tags={"授權"},
     *     path="/api/auth/refresh_token",
     *     summary="Refresh Token",
     *     description="拿舊的 Token 換發新的 Token。",
     *     security={{"api_jwt_security": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"refresh_token"},
     *                 @OA\Property(
     *                     property="refresh_token",
     *                     type="string",
     *                     example="99d0bf9c-280f-4ad6-a14f-dab6b579f047"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200, 
     *         description="請求成功。",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="access_token",
     *                     type="string",
     *                     example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9..."
     *                 ),
     *                 @OA\Property(
     *                     property="refresh_token",
     *                     type="string",
     *                     example="99d0be99-9ca4-4283-8b22-37046bf3de22"
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="statusCode",
     *                 type="integer",
     *                 example=200
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="請求成功。"
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
    public function refreshToken(Request $request);
}
