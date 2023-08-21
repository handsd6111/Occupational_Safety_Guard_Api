<?php

namespace App\Http\Controllers;

use App\Models\AccidentRecord;
use App\Models\Interfaces\IStatusCode;
use App\Models\Victim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VictimController extends Controller
{
    public function createVictim(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ar_id' => 'required|exists:accident_records,id'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), IStatusCode::BAD_REQUEST);
        }

        $columns = [
            "name",
            "id_number",
            "service_unit",
            "phone",
            "employment_date",
            "birthday",
            "address",
            "degree_of_injury",
            "ar_id"
        ];

        $victim = new Victim;
        foreach ($columns as $column) {
            if ($request->has($column)) {
                $victim->$column = $request[$column];
            }
        }
        $record = AccidentRecord::find($request['ar_id']);
        $record->victims()->save($victim);
        $record = AccidentRecordController::linkAll($record);
        return $this->sendResponse($record, 200, 1, 1);
    }

    public function updateVictim(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'ar_id' => 'required|exists:accident_records,id'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), IStatusCode::BAD_REQUEST);
        }

        $columns = [
            "name",
            "id_number",
            "service_unit",
            "phone",
            "employment_date",
            "birthday",
            "address",
            "degree_of_injury",
            "ar_id"
        ];
        $victim = Victim::find($id);
        foreach ($columns as $column) {
            if ($request->has($column)) {
                $victim->$column = $request[$column];
            }
        }
        $record = AccidentRecord::find($request['ar_id']);
        $record->victims()->save($victim);
        $record = AccidentRecordController::linkAll($record);
        return $this->sendResponse($record, 200, 1, 1);
    }

    public function deleteVictim(Request $request, $id)
    {
        $victim = Victim::find($id);
        $record = $victim->accidentRecord;
        $victim->delete();
        $record = AccidentRecordController::linkAll($record);
        return $this->sendResponse($record, 200, 1, 1);
    }
}
