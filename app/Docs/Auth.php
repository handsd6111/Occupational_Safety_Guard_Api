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
     *                 @OA\Property(
     *                     property="account",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example=
     *                 {
     *                      "account": "test", 
     *                      "password": "testtest"
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response=200, 
     *          description="請求成功。",
     *          content={
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  example= {
     *                      "data": {
     *                          "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJvc2dhX2FwaSIsImlhdCI6MTY5MTIxODI5OSwibmJmIjoxNjkxMjE4Mjk5LCJleHAiOjE2OTEyMTg0NzksInVzZXJJZCI6NiwidXNlckFjY291bnQiOiJ0ZXN0IiwidXNlckVtYWlsIjoidGVzdEBnbWFpbC5jb20iLCJ1c2VyTmFtZSI6InRlc3QiLCJ1c2VyUm9sZXMiOlsidXNlciJdfQ.tIDrkKMuG7nWxSJUlTlYuMFje3RDMaq13gAI9U6M9r19fW916dduEcAl1aHep5D22_LhmYiGSysknfz5ni9vlO5g_zo3D8aJ_IC3v02ZQj_XTZ006eRFUWYiW8qzYCEJKEkF9AMFGw5_lH3ofM6mBnommJBbrV5ufbSy1CTggkajNcELhsjtKsz9rRF3xASON1Sq-9oouMbOw8XkYHzTJKoIlAE5XLf_6gJXCZEBcMC_oE1kcliR42LMiqkD_fGqfrBfOCfUdd8xkTBTlW1xUoa2wt8_-BcVo0hvLHvolnzDZ5ww8zmib6_2z9zpI4HuSpOvQLsRzLHBnjsBegMpkA",
     *                          "refresh_token": "99d0be99-9ca4-4283-8b22-37046bf3de22"
     *                      },
     *                      "statusCode": 200,
     *                      "message": "請求成功。",
     *                      "countOfData": 0,
     *                      "countOfPage": 0
     *                  }
     *              ),
     *          }
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
     *                 @OA\Property(
     *                     property="refresh_token",
     *                     type="string"
     *                 ),
     *                 example=
     *                 {
     *                      "refresh_token": "99d0bf9c-280f-4ad6-a14f-dab6b579f047",
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response=200, 
     *          description="請求成功。",
     *          content={
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  example= {
     *                      "data": {
     *                          "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJvc2dhX2FwaSIsImlhdCI6MTY5MTIxODI5OSwibmJmIjoxNjkxMjE4Mjk5LCJleHAiOjE2OTEyMTg0NzksInVzZXJJZCI6NiwidXNlckFjY291bnQiOiJ0ZXN0IiwidXNlckVtYWlsIjoidGVzdEBnbWFpbC5jb20iLCJ1c2VyTmFtZSI6InRlc3QiLCJ1c2VyUm9sZXMiOlsidXNlciJdfQ.tIDrkKMuG7nWxSJUlTlYuMFje3RDMaq13gAI9U6M9r19fW916dduEcAl1aHep5D22_LhmYiGSysknfz5ni9vlO5g_zo3D8aJ_IC3v02ZQj_XTZ006eRFUWYiW8qzYCEJKEkF9AMFGw5_lH3ofM6mBnommJBbrV5ufbSy1CTggkajNcELhsjtKsz9rRF3xASON1Sq-9oouMbOw8XkYHzTJKoIlAE5XLf_6gJXCZEBcMC_oE1kcliR42LMiqkD_fGqfrBfOCfUdd8xkTBTlW1xUoa2wt8_-BcVo0hvLHvolnzDZ5ww8zmib6_2z9zpI4HuSpOvQLsRzLHBnjsBegMpkA",
     *                          "refresh_token": "99d0be99-9ca4-4283-8b22-37046bf3de22"
     *                      },
     *                      "statusCode": 200,
     *                      "message": "請求成功。",
     *                      "countOfData": 0,
     *                      "countOfPage": 0
     *                  }
     *              ),
     *          }
     *     )
     * )
     */
    public function refreshToken(Request $request);
}
