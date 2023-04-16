<?php

namespace App\Models\Interfaces;

interface IStatusCode
{
    const OK = 200; //請求成功。
    const CREATED = 201; //成功建立一筆資料。
    const BAD_REQUEST = 400; //使用者輸入錯誤或不合法的要求。
    const UNAUTHORIZED = 401; //表示無法存取此資源，Jwt過期也包含在內。
    const FORBIDDEN = 403; //禁止訪問，知道使用者是誰，但他無權存取這個資源。
    const INTERNAL_SERVER_ERROR = 500; //伺服器內部錯誤。
    const Message = [
        200 => '請求成功。',
        201 => '建立資料成功。',
        400 => '您的輸入有錯誤。',
        401 => "您無憑證或者已過期。",
        403 => "您沒有權限存取此資源。",
        500 => '伺服器可能出了點問題。',
    ];
}