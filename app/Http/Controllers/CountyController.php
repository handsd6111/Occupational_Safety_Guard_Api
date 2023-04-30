<?php

namespace App\Http\Controllers;

use App\Models\County;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Interfaces\IStatusCode;
use App\Models\Town;
use Exception;

class CountyController extends Controller
{
    /**
     * 取得多筆的縣市資料。
     * 
     * @param Request $request 請求
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getCounty(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                
            ]);

            // 驗證錯誤時
            if ($validator->fails()) {
                return $this->sendResponse($validator->errors(), IStatusCode::BAD_REQUEST);
            }

            $skip = $request['page'] * $request['count'];
            $take = $request['count'];
            $counties = County::skip($skip)->take($take)->get();
            $countOfData = County::count();
            $countOfPage = ceil($countOfData / $take);

            return $this->sendResponse($counties, 200, $countOfData, $countOfPage);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * 取得多筆鄉政市區的資料。
     * 
     * @param Request $request 使用者請求。
     * @param int $countyCode 要請求哪一個縣市的鄉政市區功能。
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getTown(Request $request, string $countyCode) {
        try {
            $request['countyCode'] = $countyCode;
            $validator = Validator::make($request->all(), [
                'countyCode' => 'required|string|exists:counties,code'
            ]);

            // 驗證錯誤時
            if ($validator->fails()) {
                return $this->sendResponse($validator->errors(), IStatusCode::BAD_REQUEST);
            }

            $skip = $request['page'] * $request['count'];
            $take = $request['count'];
            $query = Town::where('county_code', $countyCode);
            $countOfData = $query->count();
            $countOfPage = ceil($countOfData / $take);

            $towns = $query->skip($skip)->take($take)->get();

            return $this->sendResponse($towns, 200, $countOfData, $countOfPage);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
