<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use App\Models\Interfaces\IStatusCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IndustryController extends Controller
{
    public function getIndustry(Request $request, string $code = '')
    {
        $request['code'] = $code;

        $validator = Validator::make($request->all(), [
            'code' => 'string|max:1|exists:industries,code',
            'name' => 'string',
        ]);

        // 驗證錯誤時
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), IStatusCode::BAD_REQUEST);
        }
        if (!empty($code)) {
            // print('aaaaa');
            return $this->sendResponse(Industry::find($code), 200);
        }

        $skip = $request['page'] * $request['count'];
        $take = $request['count'];
        $industries = Industry::skip($skip)->take($take)->get();
        $countOfData = Industry::count();
        $countOfPage = ceil($countOfData / $take);

        return $this->sendResponse($industries, 200, $countOfData, $countOfPage);
    }
}
