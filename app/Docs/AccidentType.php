<?php

namespace App\Docs;

use Illuminate\Http\Request;

interface AccidentType extends Info
{
    /**
     * @OA\Get(
     *     tags={"災害類型"},
     *     path="/api/accident_types/{code}",
     *     summary="災害類型",
     *     description="查詢特定的災害類型",
     *     @OA\Parameter(
     *          name="code",
     *          description="可不帶，則為查詢所有災害類型",
     *          required=false,
     *          in="path",
     *          @OA\Schema(
     *              default="0001",
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
    public function getAccidentType(Request $request, string $code = '');
}
