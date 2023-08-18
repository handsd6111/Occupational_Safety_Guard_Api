<?php

namespace App\Http\Controllers;

use App\Models\Interfaces\IStatusCode;
use App\Models\JurisdictionRegion;
use App\Models\NotifyingAgency;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotifyingAgencyController extends Controller
{
    /**
     * 從資料庫取得單筆或多筆通報機構的資料。
     * 
     * @param Request $request 使用者請求。
     * @param int $id 欲請求單筆的id。
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getNotifyingAgencies(Request $request, int $id = 0)
    {
        try {
            $request['id'] = $id;
            $validator = Validator::make($request->all(), [
                'id' => 'integer',
                'jr_id' => 'integer',
            ]);

            // 驗證錯誤時
            if ($validator->fails()) {
                return $this->sendResponse($validator->errors(), IStatusCode::BAD_REQUEST);
            }

            if ($id > 0) {
                $agency = NotifyingAgency::find($id);
                return $this->sendResponse($agency, IStatusCode::OK);
            }

            $skip = $request['page'] * $request['count'];
            $take = $request['count'];
            $agencies = NotifyingAgency::skip($skip)->take($take)->get();
            $countOfData = NotifyingAgency::count();
            $countOfPage = ceil($countOfData / $take);

            return $this->sendResponse($agencies, 200, $countOfData, $countOfPage);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * 從資料庫取得單筆或多筆管轄地區的資料。
     * 
     * @param Request $request 使用者請求。
     * @param int $na_id 要請求哪一筆notifying_agency的管轄地區資料。
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getJurisdictionRegions(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'na_id' => 'required|Integer|exists:notifying_agencies,id',
        // ]);

        // // 驗證錯誤時
        // if ($validator->fails()) {
        //     return $this->sendResponse($validator->errors(), IStatusCode::BAD_REQUEST);
        // }

        $skip = $request['page'] * $request['count'];
        $take = $request['count'];
        $query = JurisdictionRegion::query();
        $countOfData = $query->count();
        $countOfPage = ceil($countOfData / $take);

        $regions = $query->skip($skip)->take($take)->get();
        return $this->sendResponse($regions, 200, $countOfData, $countOfPage);
    }

    public function getNotifyingAgenciesByJrId(Request $request, int $jr_id)
    {
        $request['jr_id'] = $jr_id;
        $validator = Validator::make($request->all(), [
            'jr_id' => 'required|Integer',
        ]);

        // 驗證錯誤時
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), IStatusCode::BAD_REQUEST);
        }

        $skip = $request['page'] * $request['count'];
        $take = $request['count'];
        $query = DB::table('notifying_agency_regions')
            ->select([
                'na.id',
                'agency_name',
                'address',
                'notified_hotline_at_work',
                'notified_hotline_off_work'
            ])
            ->join('notifying_agencies as na', 'na.id', '=', 'na_id')
            ->where('jr_id', $jr_id);
        $countOfData = $query->count();
        $countOfPage = ceil($countOfData / $take);

        $notifyingAgencies = $query->skip($skip)->take($take)->get();

        return $this->sendResponse($notifyingAgencies, 200, $countOfData, $countOfPage);
    }
}
