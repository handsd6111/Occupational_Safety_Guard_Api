<?php

namespace App\Docs;

use Illuminate\Http\Request;

interface Image extends Info
{
    /**
     * @OA\Post(
     *     tags={"災害紀錄"},
     *     path="/api/images",
     *     summary="新增照片",
     *     description="新增一張照片至災害紀錄",
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
     *                     format="json",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="cause_of_accident_images[]",
     *                     description="承攬關係的圖片",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string",
     *                         format="binary"
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="improve_strategy_images[]",
     *                     description="事故原因的圖片",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string",
     *                         format="binary"
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="contract_relationship_images[]",
     *                     description="改善對策的圖片",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string",
     *                         format="binary"
     *                     )
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
    public function createImage(Request $request);



    // /**
    //  * @OA\Put(
    //  *     tags={"災害紀錄"},
    //  *     path="/api/records/{id}",
    //  *     summary="修改災害紀錄",
    //  *     description="修改自己的單筆災害紀錄",
    //  *     security={{"api_jwt_security": {}}},
    //  *     @OA\Parameter(
    //  *          name="id",
    //  *          description="欲修改的災害紀錄Id",
    //  *          required=true,
    //  *          in="path",
    //  *          @OA\Schema(
    //  *              default=1,
    //  *              type="integer"
    //  *          )
    //  *     ),
    //  *     @OA\Parameter(
    //  *          name="business_industry_code",
    //  *          description="行業代碼",
    //  *          required=false,
    //  *          in="query",
    //  *          @OA\Schema(
    //  *              type="string"
    //  *          )
    //  *     ),
    //  *     @OA\Parameter(
    //  *          name="business_name",
    //  *          description="企業名稱",
    //  *          required=false,
    //  *          in="query",
    //  *          @OA\Schema(
    //  *              type="string"
    //  *          )
    //  *     ),
    //  *     @OA\Parameter(
    //  *          name="number_of_labor",
    //  *          description="勞工人數",
    //  *          required=false,
    //  *          in="query",
    //  *          @OA\Schema(
    //  *              type="string"
    //  *          )
    //  *     ),
    //  *     @OA\Parameter(
    //  *          name="business_owner",
    //  *          description="企業擁有者",
    //  *          required=false,
    //  *          in="query",
    //  *          @OA\Schema(
    //  *              type="string"
    //  *          )
    //  *     ),
    //  *     @OA\Parameter(
    //  *          name="business_address",
    //  *          description="企業地址",
    //  *          required=false,
    //  *          in="query",
    //  *          @OA\Schema(
    //  *              type="string"
    //  *          )
    //  *     ),
    //  *     @OA\Parameter(
    //  *          name="business_phone",
    //  *          description="企業電話",
    //  *          required=false,
    //  *          in="query",
    //  *          @OA\Schema(
    //  *              type="string"
    //  *          )
    //  *     ),
    //  *     @OA\Parameter(
    //  *          name="contract_relationship_description",
    //  *          description="合約關係說明",
    //  *          required=false,
    //  *          in="query",
    //  *          @OA\Schema(
    //  *              type="string"
    //  *          )
    //  *     ),
    //  *     @OA\Parameter(
    //  *          name="accident_happen_description",
    //  *          description="事故發生說明",
    //  *          required=false,
    //  *          in="query",
    //  *          @OA\Schema(
    //  *              type="string"
    //  *          )
    //  *     ),
    //  *     @OA\Parameter(
    //  *          name="cause_of_accident_description",
    //  *          description="事故原因說明",
    //  *          required=false,
    //  *          in="query",
    //  *          @OA\Schema(
    //  *              type="string"
    //  *          )
    //  *     ),
    //  *     @OA\Parameter(
    //  *          name="improve_strategy_desciption",
    //  *          description="改善策略說明",
    //  *          required=false,
    //  *          in="query",
    //  *          @OA\Schema(
    //  *              type="string"
    //  *          )
    //  *     ),
    //  *     @OA\Parameter(
    //  *          name="pension_situation_description",
    //  *          description="退休金情況說明",
    //  *          required=false,
    //  *          in="query",
    //  *          @OA\Schema(
    //  *              type="string"
    //  *          )
    //  *     ),
    //  *     @OA\Response(
    //  *         response=200, 
    //  *         description="請求成功。",
    //  *         @OA\JsonContent(
    //  *             @OA\Property(
    //  *                 property="data",
    //  *                 type="object",
    //  *                 @OA\Property(property="id", type="integer"),
    //  *                 @OA\Property(property="business_industry_code", type="string", nullable=true),
    //  *                 @OA\Property(property="business_name", type="string", nullable=true),
    //  *                 @OA\Property(property="number_of_labor", type="integer", nullable=true),
    //  *                 @OA\Property(property="business_owner", type="string", nullable=true),
    //  *                 @OA\Property(property="business_address", type="string", nullable=true),
    //  *                 @OA\Property(property="business_phone", type="string", nullable=true),
    //  *                 @OA\Property(property="contract_relationship_description", type="string", nullable=true),
    //  *                 @OA\Property(property="accident_happen_description", type="string", nullable=true),
    //  *                 @OA\Property(property="cause_of_accident_description", type="string", nullable=true),
    //  *                 @OA\Property(property="improve_strategy_desciption", type="string", nullable=true),
    //  *                 @OA\Property(property="pension_situation_description", type="string", nullable=true),
    //  *                 @OA\Property(property="user_id", type="integer"),
    //  *                 @OA\Property(property="created_at", type="string", format="date-time"),
    //  *                 @OA\Property(property="updated_at", type="string", format="date-time"),
    //  *                 @OA\Property(property="victims", type="array",
    //  *                     @OA\Items(
    //  *                         @OA\Property(property="id", type="integer"),
    //  *                         @OA\Property(property="name", type="string", nullable=true),
    //  *                         @OA\Property(property="id_number", type="string", nullable=true),
    //  *                         @OA\Property(property="service_unit", type="string", nullable=true),
    //  *                         @OA\Property(property="phone", type="string", nullable=true),
    //  *                         @OA\Property(property="employment_date", type="string", format="date", nullable=true),
    //  *                         @OA\Property(property="birthday", type="string", format="date", nullable=true),
    //  *                         @OA\Property(property="address", type="string", nullable=true),
    //  *                         @OA\Property(property="degree_of_injury", type="string", nullable=true),
    //  *                         @OA\Property(property="ar_id", type="integer")
    //  *                     )
    //  *                 ),
    //  *                 @OA\Property(property="cause_of_accident_images", type="array",
    //  *                     @OA\Items(
    //  *                         @OA\Property(property="id", type="integer"),
    //  *                         @OA\Property(property="url", type="string"),
    //  *                         @OA\Property(property="ar_id", type="integer")
    //  *                     )
    //  *                 ),
    //  *                 @OA\Property(property="contract_relationship_images", type="array",
    //  *                     @OA\Items(
    //  *                         @OA\Property(property="id", type="integer"),
    //  *                         @OA\Property(property="url", type="string"),
    //  *                         @OA\Property(property="ar_id", type="integer")
    //  *                     )
    //  *                 ),
    //  *                 @OA\Property(property="improve_strategy_images", type="array",
    //  *                     @OA\Items(
    //  *                         @OA\Property(property="id", type="integer"),
    //  *                         @OA\Property(property="url", type="string"),
    //  *                         @OA\Property(property="ar_id", type="integer")
    //  *                     )
    //  *                 )
    //  *             ),
    //  *             @OA\Property(
    //  *                 property="statusCode",
    //  *                 type="integer"
    //  *             ),
    //  *             @OA\Property(
    //  *                 property="message",
    //  *                 type="string"
    //  *             ),
    //  *             @OA\Property(
    //  *                 property="countOfData",
    //  *                 type="integer"
    //  *             ),
    //  *             @OA\Property(
    //  *                 property="countOfPage",
    //  *                 type="integer"
    //  *             )
    //  *         )
    //  *     )
    //  * )
    //  */
    // public function updateImage(Request $request, $id);

    // /**
    //  * @OA\Delete(
    //  *     tags={"災害紀錄"},
    //  *     path="/api/records/{id}",
    //  *     summary="刪除一張照片",
    //  *     description="刪除自己一筆災害紀錄中的一張照片",
    //  *     security={{"api_jwt_security": {}}},
    //  *     @OA\Parameter(
    //  *          name="id",
    //  *          description="欲刪除的災害紀錄Id",
    //  *          required=true,
    //  *          in="path",
    //  *          @OA\Schema(
    //  *              default=1,
    //  *              type="integer"
    //  *          )
    //  *     ),
    //  *     @OA\Response(
    //  *         response=200, 
    //  *         description="請求成功。",
    //  *         @OA\JsonContent(
    //  *             @OA\Property(
    //  *                 property="data",
    //  *                 type="object",
    //  *                 @OA\Property(property="id", type="integer"),
    //  *                 @OA\Property(property="business_industry_code", type="string", nullable=true),
    //  *                 @OA\Property(property="business_name", type="string", nullable=true),
    //  *                 @OA\Property(property="number_of_labor", type="integer", nullable=true),
    //  *                 @OA\Property(property="business_owner", type="string", nullable=true),
    //  *                 @OA\Property(property="business_address", type="string", nullable=true),
    //  *                 @OA\Property(property="business_phone", type="string", nullable=true),
    //  *                 @OA\Property(property="contract_relationship_description", type="string", nullable=true),
    //  *                 @OA\Property(property="accident_happen_description", type="string", nullable=true),
    //  *                 @OA\Property(property="cause_of_accident_description", type="string", nullable=true),
    //  *                 @OA\Property(property="improve_strategy_desciption", type="string", nullable=true),
    //  *                 @OA\Property(property="pension_situation_description", type="string", nullable=true),
    //  *                 @OA\Property(property="user_id", type="integer"),
    //  *                 @OA\Property(property="created_at", type="string", format="date-time"),
    //  *                 @OA\Property(property="updated_at", type="string", format="date-time"),
    //  *                 @OA\Property(property="victims", type="array",
    //  *                     @OA\Items(
    //  *                         @OA\Property(property="id", type="integer"),
    //  *                         @OA\Property(property="name", type="string", nullable=true),
    //  *                         @OA\Property(property="id_number", type="string", nullable=true),
    //  *                         @OA\Property(property="service_unit", type="string", nullable=true),
    //  *                         @OA\Property(property="phone", type="string", nullable=true),
    //  *                         @OA\Property(property="employment_date", type="string", format="date", nullable=true),
    //  *                         @OA\Property(property="birthday", type="string", format="date", nullable=true),
    //  *                         @OA\Property(property="address", type="string", nullable=true),
    //  *                         @OA\Property(property="degree_of_injury", type="string", nullable=true),
    //  *                         @OA\Property(property="ar_id", type="integer")
    //  *                     )
    //  *                 ),
    //  *                 @OA\Property(property="cause_of_accident_images", type="array",
    //  *                     @OA\Items(
    //  *                         @OA\Property(property="id", type="integer"),
    //  *                         @OA\Property(property="url", type="string"),
    //  *                         @OA\Property(property="ar_id", type="integer")
    //  *                     )
    //  *                 ),
    //  *                 @OA\Property(property="contract_relationship_images", type="array",
    //  *                     @OA\Items(
    //  *                         @OA\Property(property="id", type="integer"),
    //  *                         @OA\Property(property="url", type="string"),
    //  *                         @OA\Property(property="ar_id", type="integer")
    //  *                     )
    //  *                 ),
    //  *                 @OA\Property(property="improve_strategy_images", type="array",
    //  *                     @OA\Items(
    //  *                         @OA\Property(property="id", type="integer"),
    //  *                         @OA\Property(property="url", type="string"),
    //  *                         @OA\Property(property="ar_id", type="integer")
    //  *                     )
    //  *                 )
    //  *             ),
    //  *             @OA\Property(
    //  *                 property="statusCode",
    //  *                 type="integer"
    //  *             ),
    //  *             @OA\Property(
    //  *                 property="message",
    //  *                 type="string"
    //  *             ),
    //  *             @OA\Property(
    //  *                 property="countOfData",
    //  *                 type="integer"
    //  *             ),
    //  *             @OA\Property(
    //  *                 property="countOfPage",
    //  *                 type="integer"
    //  *             )
    //  *         )
    //  *     )
    //  * )
    //  */
    // public function deleteImage(Request $request, $id);
}
