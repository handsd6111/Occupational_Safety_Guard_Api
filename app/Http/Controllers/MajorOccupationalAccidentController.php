<?php

namespace App\Http\Controllers;

use App\Mail\MajorOccupationalAccidentMail;
use App\Models\AccidentType;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Interfaces\IStatusCode;
use App\Models\MajorOccupationalAccident;
use App\Models\NotifyingAgency;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class MajorOccupationalAccidentController extends Controller
{
    public function sendMail($id)
    {
        $users = User::where('subscribe', true)->get();
        $mailUsers = [];
        foreach ($users as $user) {
            $mailUsers[] = [
                'email' => $user->email,
                'name' => $user->name,
            ];
        }
        $moa = MajorOccupationalAccident::find($id);
        $accidentType = AccidentType::where('code', $moa->accident_type)->get()[0];
        $industry = Industry::where('code', $moa->industry)->get()[0];
        $notifyingAgency = NotifyingAgency::find($moa->notifying_agency);
        unset($moa['id']);
        $moa['occurrence_date'] = date('Y/m/d', strtotime($moa['occurrence_date']));
        $moa['industry'] = $industry->name;
        $moa['accident_type'] = $accidentType->name;
        $moa['notifying_agency'] = $notifyingAgency->agency_name;
        $moa['scan_time'] = date('Y/m/d H:i:s', now()->timestamp);
        // return $moa;
        Mail::to($mailUsers)->send(new MajorOccupationalAccidentMail($moa));
    }

    public function getMajorOccupationalAccidents(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'industryCode' => 'string|exists:industries,code',
            'accidentTypeCode' => 'string|exists:accident_types,code',
            'notifyingAgencyId' => 'integer|exists:notifying_agencies,id',
            'startOccurrenceDate' => 'date',
            'endOccurrenceDate' => 'date'
        ]);

        // 驗證錯誤時
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), IStatusCode::BAD_REQUEST);
        }

        $whereArray = [
            'industry' => 'industryCode',
            'accident_type' => 'accidentTypeCode',
            'notifying_agency' => 'notifyingAgencyId'
        ];

        $query = MajorOccupationalAccident::query();

        foreach ($whereArray as $key => $val) {
            $value = $request[$val];
            if (!empty($value)) {
                $query->where($key, $value);
            }
        }

        if (!empty($request['startOccurrenceDate'])) {
            $query->where('occurrence_date', '>=', $request['startOccurrenceDate']);
        }

        if (!empty($request['endOccurrenceDate'])) {
            $query->where('occurrence_date', '<=', $request['endOccurrenceDate']);
        }

        $skip = $request['page'] * $request['count'];
        $take = $request['count'];
        $industries = $query->skip($skip)->take($take)->orderBy('occurrence_date', 'desc')->get();
        $countOfData = $query->count();
        $countOfPage = ceil($countOfData / $take);

        return $this->sendResponse($industries, 200, $countOfData, $countOfPage);
    }

    public function getAccidentTypeStatistics(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'industryCode' => 'string|exists:industries,code|required',
            'startOccurrenceDate' => 'date',
            'endOccurrenceDate' => 'date'
        ]);

        // 驗證錯誤時
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), IStatusCode::BAD_REQUEST);
        }
        $accidentTypes = AccidentType::all();

        $results = [];

        foreach ($accidentTypes as $accidentType) {
            $query = DB::table('major_occupational_accidents')
                ->select(DB::raw('ats.name as accident_type, count(id) as count_of_accident_type'))
                ->join('accident_types as ats', 'ats.code', '=', 'accident_type')
                ->where('accident_type', $accidentType['code'])
                ->where('industry', $request['industryCode'])
                ->groupBy(['ats.name']);
            if (!empty($request['startOccurrenceDate'])) {
                $query->where('occurrence_date', '>=', $request['startOccurrenceDate']);
            }
            if (!empty($request['endOccurrenceDate'])) {
                $query->where('occurrence_date', '<=', $request['endOccurrenceDate']);
            }

            $result = $query->get();

            if (count($result)) {
                $results[] = $result[0];
            }
        }

        usort($results, function ($item1, $item2) {
            if ($item1->count_of_accident_type == $item2->count_of_accident_type) return 0;
            return ($item1->count_of_accident_type < $item2->count_of_accident_type) ? 1 : -1;
        });

        return $this->sendResponse($results, 200);
    }

    public function getIndustryStatistics(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'accidentTypeCode' => 'string|exists:accident_types,code|required',
            'startOccurrenceDate' => 'date',
            'endOccurrenceDate' => 'date'
        ]);

        // 驗證錯誤時
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), IStatusCode::BAD_REQUEST);
        }
        $industries = Industry::all();

        $results = [];

        foreach ($industries as $industry) {
            $query = DB::table('major_occupational_accidents')
                ->select(DB::raw('industries.name as industry, count(id) as count_of_industry'))
                ->join('industries', 'industries.code', '=', 'industry')
                ->where('industry', $industry['code'])
                ->where('accident_type', $request['accidentTypeCode'])
                ->groupBy(['industries.name']);

            if (!empty($request['startOccurrenceDate'])) {
                $query->where('occurrence_date', '>=', $request['startOccurrenceDate']);
            }
            if (!empty($request['endOccurrenceDate'])) {
                $query->where('occurrence_date', '<=', $request['endOccurrenceDate']);
            }

            $result = $query->get();

            if (count($result)) {
                $results[] = $result[0];
            }
        }

        usort($results, function ($item1, $item2) {
            if ($item1->count_of_industry == $item2->count_of_industry) return 0;
            return ($item1->count_of_industry < $item2->count_of_industry) ? 1 : -1;
        });

        return $this->sendResponse($results, 200);
    }
}
