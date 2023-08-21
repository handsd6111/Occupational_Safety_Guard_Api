<?php

namespace App\Http\Controllers;

use App\Models\AccidentRecord;
use App\Models\CauseOfAccidentImage;
use App\Models\ContractRelationshipImage;
use App\Models\ImproveStrategyImage;
use App\Models\Interfaces\IStatusCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    public function createImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ar_id' => 'required|exists:accident_records,id'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), IStatusCode::BAD_REQUEST);
        }

        $record = AccidentRecord::find($request['ar_id']);

        if ($request->hasFile('contract_relationship_images')) {
            foreach ($request->file('contract_relationship_images') as $image) {
                $filePath = $image->store('contract_relationship', 'public');
                $coai = new ContractRelationshipImage;
                $coai->url = asset("storage/$filePath");
                $coai->ar_id = $request['ar_id'];
                $record->contractRelationshipImages()->save($coai);
            }
        }

        if ($request->hasFile('cause_of_accident_images')) {
            foreach ($request->file('cause_of_accident_images') as $image) {
                $filePath = $image->store('cause_of_accident', 'public');
                $coai = new CauseOfAccidentImage;
                $coai->url = asset("storage/$filePath");
                $coai->ar_id = $request['ar_id'];
                $record->causeOfAccidentImages()->save($coai);
            }
        }

        if ($request->hasFile('improve_strategy_images')) {
            foreach ($request->file('improve_strategy_images') as $image) {
                $filePath = $image->store('improve_strategy', 'public');
                $coai = new ImproveStrategyImage;
                $coai->url = asset("storage/$filePath");
                $coai->ar_id = $request['ar_id'];
                $record->improveStrategyImages()->save($coai);
            }
        }

        $record = AccidentRecordController::linkAll($record);
        return $this->sendResponse($record, 200, 1, 1);
    }

    public function updateImage(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'ar_id' => 'required|exists:accident_records,id'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), IStatusCode::BAD_REQUEST);
        }

        $record = AccidentRecord::find($request['ar_id']);

        if ($request->hasFile('contract_relationship_image')) {
            $cri = ContractRelationshipImage::find($id);
            if (empty($isi)) {
                return $this->sendResponse('圖片 ID 錯誤', 400);
            }
            if (!empty($cri)) {
                $filePath = $request->file('contract_relationship_image')->store('contract_relationship', 'public');
                Storage::disk('public')->delete(explode('storage/', $cri->url)[1]);
                $cri->url = asset("storage/$filePath");
                $cri->save();
            }
            // $record->contractRelationshipImages()->save($cri);
        }

        if ($request->hasFile('cause_of_accident_image')) {
            $coai = CauseOfAccidentImage::find($id);
            if (empty($isi)) {
                return $this->sendResponse('圖片 ID 錯誤', 400);
            }
            if (!empty($coai)) {
                $filePath = $request->file('cause_of_accident_image')->store('cause_of_accident', 'public');;
                Storage::disk('public')->delete(explode('storage/', $coai->url)[1]);
                $coai->url = asset("storage/$filePath");
                $coai->save();
            }
        }

        if ($request->hasFile('improve_strategy_image')) {
            $isi = ImproveStrategyImage::find($id);
            if (empty($isi)) {
                return $this->sendResponse('圖片 ID 錯誤', 400);
            }
            $filePath = $request->file('improve_strategy_image')->store('improve_strategy', 'public');
            Storage::disk('public')->delete(explode('storage/', $isi->url)[1]);
            $isi->url = asset("storage/$filePath");
            $isi->save();
        }

        $record = AccidentRecordController::linkAll($record);
        return $this->sendResponse($record, 200, 1, 1);
    }

    public function deleteImage(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'ar_id' => 'required|exists:accident_records,id',
            'type' => 'string|required'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), IStatusCode::BAD_REQUEST);
        }

        $types = ['coa', 'cr', 'is'];

        $record = AccidentRecord::find($request['ar_id']);
        $succssType = false;
        foreach ($types as $type) {
            if ($type == $request['type']) {
                $succssType = true;
            }
        }

        if (!$succssType) {
            return $this->sendResponse('type 錯誤', 400);
        }
        $image = null;
        if ($request['type'] == 'cr') {
            $image = $record->contractRelationshipImages()->find($id);
        } else if ($request['type'] == 'coa') {
            $image = $record->causeOfAccidentImages()->find($id);
        } else if ($request['type'] == 'is') {
            $image = $record->improveStrategyImages()->find($id);
        }

        if (empty($image)) {
            return $this->sendResponse('查無此圖片', 400);
        }
        Storage::disk('public')->delete(explode('storage/', $image->url)[1]);
        $image->delete();

        $record = AccidentRecordController::linkAll($record);
        return $this->sendResponse($record, 200, 1, 1);
    }
}
