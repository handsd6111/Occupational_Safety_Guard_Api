<?php

namespace App\Docs;

use Illuminate\Http\Request;

interface Notifying extends Info
{
    /**
     * @OA\Get(
     *     tags={"線上通報資料"},
     *     path="/api/notifying",
     *     summary="通報選擇欄位資料",
     *     description="取得職災網路通報資料所有 Select 的欄位",
     *     @OA\Response(
     *         response=200, 
     *         description="請求成功。",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                      property="accident_types",
     *                      type="array",
     *                      @OA\Items(
     *                          @OA\Property(property="code", type="string"),
     *                          @OA\Property(property="name", type="string"),
     *                      )
     *                 ),
     *                 @OA\Property(
     *                      property="degree_of_injuries",
     *                      type="array",
     *                      @OA\Items(
     *                          @OA\Property(property="code", type="string"),
     *                          @OA\Property(property="name", type="string"),
     *                          @OA\Property(property="need_hospital", type="array", @OA\Items(
     *                              @OA\Property(property="code", type="string"),
     *                              @OA\Property(property="name", type="string"),
     *                          )),
     *                      )
     *                 ),
     *                 @OA\Property(
     *                      property="insurances",
     *                      type="array",
     *                      @OA\Items(
     *                          @OA\Property(property="code", type="string"),
     *                          @OA\Property(property="name", type="string"),
     *                      )
     *                 ),
     *                 @OA\Property(
     *                      property="victim_identites",
     *                      type="array",
     *                      @OA\Items(
     *                          @OA\Property(property="code", type="string"),
     *                          @OA\Property(property="name", type="string"),
     *                      )
     *                 ),
     *                 @OA\Property(
     *                      property="counties",
     *                      type="array",
     *                      @OA\Items(
     *                          @OA\Property(property="code", type="string"),
     *                          @OA\Property(property="name", type="string"),
     *                          @OA\Property(property="towns", type="array", @OA\Items(
     *                              @OA\Property(property="code", type="string"),
     *                              @OA\Property(property="name", type="string"),
     *                          )),
     *                      )
     *                 ),
     *                 
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
    public function getNotifying(Request $request);
}
