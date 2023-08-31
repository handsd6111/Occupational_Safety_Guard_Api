<?php

namespace App\Docs;

use Illuminate\Http\Request;

interface Image extends Info
{
    /**
     * @OA\Post(
     *     tags={"災害紀錄 - 照片"},
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
     *                     description="事故原因的圖片",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string",
     *                         format="binary"
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="improve_strategy_images[]",
     *                     description="改善對策的圖片",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string",
     *                         format="binary"
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="contract_relationship_images[]",
     *                     description="承攬關係的圖片",
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



    /**
     * @OA\Post(
     *     tags={"災害紀錄 - 照片"},
     *     path="/api/images/{id}",
     *     summary="修改紀錄照片",
     *     description="修改單筆屬於自己災害紀錄的照片，三種照片選一種填。",
     *     security={{"api_jwt_security": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="要修改的照片id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              default=1,
     *              type="integer"
     *          )
     *     ),
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
     *                     property="cause_of_accident_image",
     *                     description="事故原因的圖片(三選一)",
     *                     type="string",
     *                     format="binary"
     *                 ),
     *                 @OA\Property(
     *                     property="improve_strategy_image",
     *                     description="改善對策的圖片(三選一)",
     *                     type="string",
     *                     format="binary"
     *                 ),
     *                 @OA\Property(
     *                     property="contract_relationship_image",
     *                     description="承攬關係的圖片(三選一)",
     *                     type="string",
     *                     format="binary"
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
    public function updateImage(Request $request, $id);

    /**
     * @OA\Delete(
     *     tags={"災害紀錄 - 照片"},
     *     path="/api/images/{id}",
     *     summary="刪除一張照片",
     *     description="刪除自己一筆災害紀錄中的一張照片",
     *     security={{"api_jwt_security": {}}},
     *     @OA\Parameter(
     *          name="id",
     *          description="要修改的照片id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              default=1,
     *              type="integer"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="ar_id",
     *          description="圖片在哪個災害紀錄",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              default=1,
     *              type="integer"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="type",
     *          description="圖片在哪個災害紀錄(coa / cr / is)",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              default="coa",
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
    public function deleteImage(Request $request, $id);
}
