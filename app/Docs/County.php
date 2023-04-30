<?php

namespace App\Docs;

use Illuminate\Http\Request;

interface County extends Info
{
    /**
     * @OA\Post(
     *     tags={"縣市、鄉鎮市區"},
     *     path="/api/counties",
     *     summary="縣市",
     *     description="查詢多筆的縣市資料。",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="page",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="count",
     *                     type="integer"
     *                 ),
     *                 example=
     *                 {
     *                      "page": 1, 
     *                      "count": 1
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
     *                          "data": {
     *                              {
     *                                  "code": "A",
     *                                  "name": "臺北市"
     *                              }
     *                          },
     *                          "statusCode": 200,
     *                          "message": "請求成功。",
     *                          "countOfData": 22,
     *                          "countOfPage": 22
     *                  }
     *              ),
     *          }
     *     )
     * )
     */
    public function getCounty(Request $request);

    /**
     * @OA\Post(
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
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="page",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="count",
     *                     type="integer"
     *                 ),
     *                 example=
     *                 {
     *                      "page": 1, 
     *                      "count": 1
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
     *                          "data": {
     *                              {
     *                                  "code": "A01",
     *                                  "name": "松山區",
     *                                  "county_code": "A"
     *                              },
     *                          },
     *                          "statusCode": 200,
     *                          "message": "請求成功。",
     *                          "countOfData": 12,
     *                          "countOfPage": 12
     *                  }
     *              ),
     *          }
     *     )
     * )
     */
    public function getTown(Request $request, int $id = 0);
}