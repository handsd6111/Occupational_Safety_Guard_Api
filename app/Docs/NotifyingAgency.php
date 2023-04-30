<?php

namespace App\Docs;

use Illuminate\Http\Request;

interface NotifyingAgency extends Info
{
    /**
     * @OA\Post(
     *     tags={"通報機關地圖"},
     *     path="/api/notifying_agencies/{id}",
     *     summary="通報機關",
     *     description="查詢單筆或多筆的通報機關。",
     *     @OA\Parameter(
     *          name="id",
     *          description="若想要查詢單筆，請帶入機關編碼，查多筆可不帶0，這裡是因為Swagger不帶值會預設給空白。",
     *          required=false,
     *          in="path",
     *          @OA\Schema(
     *              default=0,
     *              type="integer"
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
     *                                  "id": 1,
     *                                  "agency_name": "勞動部職業安全衛生署北區職業安全衛生中心",
     *                                  "address": "24219 新北市新莊區中平路439號南棟9樓",
     *                                  "notified_hotline_at_work": "02-89956720",
     *                                  "notified_hotline_off_work": "02-89956720"
     *                              }
     *                          },
     *                          "statusCode": 200,
     *                          "message": "請求成功。",
     *                          "countOfData": 17,
     *                          "countOfPage": 17
     *                  }
     *              ),
     *          }
     *     )
     * )
     */
    public function getNotifyingAgencies(Request $request, int $id = 0);

    /**
     * @OA\Post(
     *     tags={"通報機關地圖"},
     *     path="/api/notifying_agencies/{id}/jurisdiction_regions",
     *     summary="管轄區",
     *     description="查詢通報機關所管轄的區域。",
     *     @OA\Parameter(
     *          name="na_id",
     *          description="欲查詢哪一筆通報機關的管轄區，帶入通報機關的id。",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              default=1,
     *              type="integer"
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
     *                                  "id": 1,
     *                                  "na_id": 1,
     *                                  "region": "新北市"
     *                              }
     *                          },
     *                          "statusCode": 200,
     *                          "message": "請求成功。",
     *                          "countOfData": 17,
     *                          "countOfPage": 17
     *                  }
     *              ),
     *          }
     *     )
     * )
     */
    public function getJurisdictionRegions(Request $request, int $na_id);
}