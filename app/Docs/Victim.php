<?php

namespace App\Docs;

use Illuminate\Http\Request;

interface Victim extends Info
{
    /**
     * @OA\Post(
     *     tags={"災害紀錄 - 罹災者"},
     *     path="/api/victims",
     *     summary="新增罹災者",
     *     description="新增自己災害紀錄中的一筆罹災者",
     *     security={{"api_jwt_security": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"ar_id"},
     *                 @OA\Property(
     *                     property="ar_id",
     *                     description="要填入的職災紀錄中",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     description="姓名",
     *                     type="string",
     *                     example="王大明"
     *                 ),
     *                 @OA\Property(
     *                     property="id_number",
     *                     description="身分證字號",
     *                     type="string",
     *                     example="S123457890"
     *                 ),
     *                 @OA\Property(
     *                     property="service_unit",
     *                     description="服務單位",
     *                     type="string",
     *                     example="某家公司"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     description="電話",
     *                     type="string",
     *                     example="0987654321"
     *                 ),
     *                 @OA\Property(
     *                     property="employment_date",
     *                     description="到職日期",
     *                     type="date",
     *                     example="2012-01-24"
     *                 ),
     *                 @OA\Property(
     *                     property="birthday",
     *                     description="出生日期",
     *                     type="date",
     *                     example="1997-02-14"
     *                 ),
     *                 @OA\Property(
     *                     property="address",
     *                     description="地址",
     *                     type="string",
     *                     example="高雄市左營區左營路左營里87號"
     *                 ),
     *                 @OA\Property(
     *                     property="degree_of_injury",
     *                     description="罹災程度",
     *                     type="string",
     *                     example="重傷"
     *                 ),
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
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="business_industry_code", type="string", nullable=true),
     *                 @OA\Property(property="business_name", type="string", nullable=true),
     *                 @OA\Property(property="number_of_labor", type="integer", nullable=true),
     *                 @OA\Property(property="business_owner", type="string", nullable=true),
     *                 @OA\Property(property="business_address", type="string", nullable=true),
     *                 @OA\Property(property="business_phone", type="string", nullable=true),
     *                 @OA\Property(property="contract_relationship_description", type="string", nullable=true),
     *                 @OA\Property(property="accident_happen_description", type="string", nullable=true),
     *                 @OA\Property(property="cause_of_accident_description", type="string", nullable=true),
     *                 @OA\Property(property="improve_strategy_desciption", type="string", nullable=true),
     *                 @OA\Property(property="pension_situation_description", type="string", nullable=true),
     *                 @OA\Property(property="user_id", type="integer"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 @OA\Property(property="victims", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="name", type="string", nullable=true),
     *                         @OA\Property(property="id_number", type="string", nullable=true),
     *                         @OA\Property(property="service_unit", type="string", nullable=true),
     *                         @OA\Property(property="phone", type="string", nullable=true),
     *                         @OA\Property(property="employment_date", type="string", format="date", nullable=true),
     *                         @OA\Property(property="birthday", type="string", format="date", nullable=true),
     *                         @OA\Property(property="address", type="string", nullable=true),
     *                         @OA\Property(property="degree_of_injury", type="string", nullable=true),
     *                         @OA\Property(property="ar_id", type="integer")
     *                     )
     *                 ),
     *                 @OA\Property(property="cause_of_accident_images", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="url", type="string"),
     *                         @OA\Property(property="ar_id", type="integer")
     *                     )
     *                 ),
     *                 @OA\Property(property="contract_relationship_images", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="url", type="string"),
     *                         @OA\Property(property="ar_id", type="integer")
     *                     )
     *                 ),
     *                 @OA\Property(property="improve_strategy_images", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="url", type="string"),
     *                         @OA\Property(property="ar_id", type="integer")
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
    public function createVictim(Request $request);

    /**
     * @OA\Put(
     *     tags={"災害紀錄 - 罹災者"},
     *     path="/api/victims/{id}",
     *     summary="修改罹災者",
     *     description="修改自己的單筆災害紀錄",
     *     security={{"api_jwt_security": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="欲修改的罹災者Id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              default=1,
     *              type="integer"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="ar_id",
     *          description="要填入的職災紀錄中",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              default=1,
     *              type="integer"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="name",
     *          description="姓名",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="id_number",
     *          description="身分證字號",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="service_unit",
     *          description="服務單位",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="phone",
     *          description="電話",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="employment_date",
     *          description="到職日期",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="date"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="birthday",
     *          description="出生日期",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="date"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="address",
     *          description="地址",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="degree_of_injury",
     *          description="罹災程度",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *         response=200, 
     *         description="請求成功。",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="business_industry_code", type="string", nullable=true),
     *                 @OA\Property(property="business_name", type="string", nullable=true),
     *                 @OA\Property(property="number_of_labor", type="integer", nullable=true),
     *                 @OA\Property(property="business_owner", type="string", nullable=true),
     *                 @OA\Property(property="business_address", type="string", nullable=true),
     *                 @OA\Property(property="business_phone", type="string", nullable=true),
     *                 @OA\Property(property="contract_relationship_description", type="string", nullable=true),
     *                 @OA\Property(property="accident_happen_description", type="string", nullable=true),
     *                 @OA\Property(property="cause_of_accident_description", type="string", nullable=true),
     *                 @OA\Property(property="improve_strategy_desciption", type="string", nullable=true),
     *                 @OA\Property(property="pension_situation_description", type="string", nullable=true),
     *                 @OA\Property(property="user_id", type="integer"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 @OA\Property(property="victims", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="name", type="string", nullable=true),
     *                         @OA\Property(property="id_number", type="string", nullable=true),
     *                         @OA\Property(property="service_unit", type="string", nullable=true),
     *                         @OA\Property(property="phone", type="string", nullable=true),
     *                         @OA\Property(property="employment_date", type="string", format="date", nullable=true),
     *                         @OA\Property(property="birthday", type="string", format="date", nullable=true),
     *                         @OA\Property(property="address", type="string", nullable=true),
     *                         @OA\Property(property="degree_of_injury", type="string", nullable=true),
     *                         @OA\Property(property="ar_id", type="integer")
     *                     )
     *                 ),
     *                 @OA\Property(property="cause_of_accident_images", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="url", type="string"),
     *                         @OA\Property(property="ar_id", type="integer")
     *                     )
     *                 ),
     *                 @OA\Property(property="contract_relationship_images", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="url", type="string"),
     *                         @OA\Property(property="ar_id", type="integer")
     *                     )
     *                 ),
     *                 @OA\Property(property="improve_strategy_images", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="url", type="string"),
     *                         @OA\Property(property="ar_id", type="integer")
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
    public function updateVictim(Request $request, $id);

    /**
     * @OA\Delete(
     *     tags={"災害紀錄 - 罹災者"},
     *     path="/api/victims/{id}",
     *     summary="刪除罹災者資訊",
     *     description="刪除自己紀錄中的一筆罹災者資訊",
     *     security={{"api_jwt_security": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="欲刪除的罹災者Id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              default=1,
     *              type="integer"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="ar_id",
     *          description="要刪除的罹災者屬於的職災紀錄Id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              default=1,
     *              type="integer"
     *          )
     *     ),
     *     @OA\Response(
     *         response=200, 
     *         description="請求成功。",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="business_industry_code", type="string", nullable=true),
     *                 @OA\Property(property="business_name", type="string", nullable=true),
     *                 @OA\Property(property="number_of_labor", type="integer", nullable=true),
     *                 @OA\Property(property="business_owner", type="string", nullable=true),
     *                 @OA\Property(property="business_address", type="string", nullable=true),
     *                 @OA\Property(property="business_phone", type="string", nullable=true),
     *                 @OA\Property(property="contract_relationship_description", type="string", nullable=true),
     *                 @OA\Property(property="accident_happen_description", type="string", nullable=true),
     *                 @OA\Property(property="cause_of_accident_description", type="string", nullable=true),
     *                 @OA\Property(property="improve_strategy_desciption", type="string", nullable=true),
     *                 @OA\Property(property="pension_situation_description", type="string", nullable=true),
     *                 @OA\Property(property="user_id", type="integer"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 @OA\Property(property="victims", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="name", type="string", nullable=true),
     *                         @OA\Property(property="id_number", type="string", nullable=true),
     *                         @OA\Property(property="service_unit", type="string", nullable=true),
     *                         @OA\Property(property="phone", type="string", nullable=true),
     *                         @OA\Property(property="employment_date", type="string", format="date", nullable=true),
     *                         @OA\Property(property="birthday", type="string", format="date", nullable=true),
     *                         @OA\Property(property="address", type="string", nullable=true),
     *                         @OA\Property(property="degree_of_injury", type="string", nullable=true),
     *                         @OA\Property(property="ar_id", type="integer")
     *                     )
     *                 ),
     *                 @OA\Property(property="cause_of_accident_images", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="url", type="string"),
     *                         @OA\Property(property="ar_id", type="integer")
     *                     )
     *                 ),
     *                 @OA\Property(property="contract_relationship_images", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="url", type="string"),
     *                         @OA\Property(property="ar_id", type="integer")
     *                     )
     *                 ),
     *                 @OA\Property(property="improve_strategy_images", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="url", type="string"),
     *                         @OA\Property(property="ar_id", type="integer")
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
    public function deleteVictim(Request $request, $id);
}
