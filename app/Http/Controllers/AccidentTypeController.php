<?php

namespace App\Http\Controllers;

use App\Models\AccidentType;
use App\Models\Interfaces\IStatusCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccidentTypeController extends Controller
{
    public function getAccidentType(Request $request, string $code = '')
    {
        $request['code'] = $code;

        $validator = Validator::make($request->all(), [
            'code' => 'string|max:4|exists:accident_types,code',
            'name' => 'string',
        ]);

        // 驗證錯誤時
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), IStatusCode::BAD_REQUEST);
        }
        if (!empty($code)) {
            return $this->sendResponse(AccidentType::find($code), 200);
        }

        $skip = $request['page'] * $request['count'];
        $take = $request['count'];
        $accidentTypes = AccidentType::skip($skip)->take($take)->get();
        $countOfData = AccidentType::count();
        $countOfPage = ceil($countOfData / $take);

        return $this->sendResponse($accidentTypes, 200, $countOfData, $countOfPage);
    }
}
