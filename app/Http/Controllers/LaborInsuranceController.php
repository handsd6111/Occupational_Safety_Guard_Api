<?php

namespace App\Http\Controllers;

use App\Models\LaborExtraIdentity;
use App\Models\LaborExtraIdentitySubsidy;
use App\Models\LaborIdentity;
use App\Models\LaborQualify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaborInsuranceController extends Controller
{

    public function getLaborInsurance(Request $request, $identity = 0, $extraIdentity = 0, $subsidy = 0, $qualify = 0)
    {
        $result = null;

        if ($identity == 0) {
            $result = LaborIdentity::all();
        }

        if ($identity > 0) {
            $result = LaborExtraIdentity::where('li_id', $identity)->get();
        }

        if ($extraIdentity > 0) {
            $result = DB::table('labor_extra_identity_subsidies')
                ->select('ls.id as id', 'ls.name as name')
                ->join('labor_subsidies as ls', 'ls.id', '=', 'ls_id')
                ->where('lei_id', $extraIdentity)
                ->get();
        }

        if($subsidy > 0) {
            $result = LaborQualify::where('ls_id', $subsidy)->get();
        }

        if($qualify > 0) {
            $result = [];
            $result['labor_qualify'] = LaborQualify::find($qualify);
            $laborFiles = DB::table('labor_qualify_files')
                ->select('lf.id as id', 'lf.name as name')
                ->join('labor_files as lf', 'lf.id', '=', 'lf_id')
                ->where('lq_id', $qualify)
                ->get();
            $result['labor_files'] = $laborFiles;
        }

        return $this->sendResponse($result, 200);
    }
}
