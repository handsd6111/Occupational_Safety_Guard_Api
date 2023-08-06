<?php

namespace App\Docs;

use Illuminate\Http\Request;

interface Industry extends Info
{
    /**
     * @OA\Get(
     *     tags={"行業別"},
     *     path="/api/industries/{code}",
     *     summary="行業別",
     *     description="查詢多筆或單筆的行業別資料",
     *     @OA\Parameter(
     *         name="code",
     *         in="path",
     *         description="行業別編號",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         example="A"
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="頁碼(查單筆可不帶)",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         example=1
     *     ),
     *     @OA\Parameter(
     *         name="count",
     *         in="query",
     *         description="每頁筆數(查單筆可不帶)",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         example=5
     *     ),
     *     @OA\Response(
     *         response=200, 
     *         description="請求成功。",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(
     *                         property="code",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string"
     *                     )
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="statusCode",
     *                 type="integer"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="countOfData",
     *                 type="integer"
     *             ),
     *             @OA\Property(
     *                 property="countOfPage",
     *                 type="integer"
     *             )
     *         )
     *     )
     * )
     */
    public function getIndustry(Request $request, string $code);
}
