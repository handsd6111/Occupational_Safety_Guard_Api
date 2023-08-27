<?php

namespace App\Docs;

define('L5_SWAGGER_BASE_PATH', env('L5_SWAGGER_BASE_PATH')); // Define a runtime constant


/**
 * @OA\OpenApi(
 *  @OA\Info(
 *      title="Occupational Safety Guard Api",
 *      version="1.0.0",
 *      description="用於資料創新應用競賽-職場安全創新應用組的後端API",
 *      @OA\Contact(
 *          email="s20313116@stu.edu.tw"
 *      )
 *  ),
 *  @OA\Server(
 *      description="正式區",
 *      url=L5_SWAGGER_BASE_PATH
 *  ),
 *  @OA\PathItem(
 *      path="/"
 *  )
 * )
 */
interface Info
{
}