<?php

namespace App\Http\Controllers;

use App\Models\CauseOfAccidentImage;
use App\Models\Interfaces\IStatusCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CauseOfAccidentImageController extends Controller
{
    public function createImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ar_id' => 'required|exists:accident_records,id'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), IStatusCode::BAD_REQUEST);
        }

        if ($request->hasFile('cause_of_accident_images')) {
            foreach($request->files('cause_of_accident_images') as $image) {
                $filePath = $image->store('cause_of_accident', 'public');
                return asset($filePath);
                // $coai = new CauseOfAccidentImage;
                // $coai->url = asset($filePath);
                // $coai->ar_id = $request['ar_id'];
            }
        }
    }
}
