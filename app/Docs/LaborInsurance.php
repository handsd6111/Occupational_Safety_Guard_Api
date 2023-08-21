<?php

namespace App\Docs;

use Illuminate\Http\Request;

interface LaborInsurance extends Info
{
    /**
     * @OA\Get(
     *     tags={"勞保下載"},
     *     path="/api/labor_insurance/{li_id}/{lei_id}/{ls_id}/{lq_id}",
     *     summary="勞保下載",
     *     description="查詢全部或指定條件之重大職災資訊",
     *     @OA\Parameter(
     *         name="li_id",
     *         in="path",
     *         description="身份",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         example=0
     *     ),
     *     @OA\Parameter(
     *         name="lei_id",
     *         in="path",
     *         description="額外身份",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         example=0
     *     ),
     *     @OA\Parameter(
     *         name="ls_id",
     *         in="path",
     *         description="補助",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         example=0
     *     ),
     *     @OA\Parameter(
     *         name="lq_id",
     *         in="path",
     *         description="資格",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         example=0
     *     ),
     *     @OA\Response(
     *         response=200, 
     *         description="請求成功。",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
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
    public function getLaborInsurance(Request $request);
}
