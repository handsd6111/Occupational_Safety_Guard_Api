<?php

namespace App\Docs;

use Illuminate\Http\Request;

interface County extends Info
{
    /**
     * @OA\Get(
     *     tags={"縣市、鄉鎮市區"},
     *     path="/api/counties",
     *     summary="縣市",
     *     description="查詢多筆的縣市資料。",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="頁碼",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         example=1
     *     ),
     *     @OA\Parameter(
     *         name="count",
     *         in="query",
     *         description="每頁筆數",
     *         required=true,
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
    public function getCounty(Request $request);

    /**
     * @OA\Get(
     *     tags={"縣市、鄉鎮市區"},
     *     path="/api/counties/{countyCode}/towns",
     *     summary="鄉鎮市區",
     *     description="查詢此縣市所擁有的鄉鎮市區資料。",
     *     @OA\Parameter(
     *          name="countyCode",
     *          description="欲查詢哪一筆通報機關的管轄區，帶入通報機關的id。",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              default="A",
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="頁碼",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         example=1
     *     ),
     *     @OA\Parameter(
     *         name="count",
     *         in="query",
     *         description="每頁筆數",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         example=10
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
     *                     ),
     *                     @OA\Property(
     *                         property="county_code",
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
    public function getTown(Request $request, int $id = 0);
}
