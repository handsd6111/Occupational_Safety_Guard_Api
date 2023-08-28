<?php

namespace App\Http\Controllers;

use App\Models\AccidentRecord;
use App\Models\Interfaces\IStatusCode;
use App\Models\User;
use App\Models\Victim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\Font;

class AccidentRecordController extends Controller
{
    public function getRecord(Request $request, $id = 0)
    {
        $request['id'] = $id;
        $validator = Validator::make($request->all(), [
            'id' => 'integer',
        ]);

        // 驗證錯誤時
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), IStatusCode::BAD_REQUEST);
        }

        $user = $this->getUserByJwt($request);

        if ($id != 0) {

            $record = AccidentRecord::where('user_id', $user->id)->find($id);
            if (!empty($record)) {
                $record = $this->linkAll($record);
            }
            return $this->sendResponse($record, 200);
        }

        $records = AccidentRecord::where('user_id', $user->id)->get();
        $countOfData = AccidentRecord::count();

        return $this->sendResponse($records, 200, $countOfData, 1);
    }

    public function createRecord(Request $request)
    {
        $user = $this->getUserByJwt($request);
        $record = AccidentRecord::create(['user_id' => $user->id]);
        $victim = Victim::create(['ar_id' => $record->id]);
        $record->victims()->save($victim);
        $result = AccidentRecord::find($record->id);
        $result = $this->linkAll($result);

        return $this->sendResponse($result, 200, 1, 1);
    }


    public function updateRecord(Request $request, $id)
    {
        $request['id'] = $id;
        $validator = Validator::make($request->all(), [
            'id' => 'integer|exists:accident_records,id',
            'business_industry_code' => 'string|exists:industries,code',
            'number_of_labor' => 'integer',
        ]);

        // 驗證錯誤時
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), IStatusCode::BAD_REQUEST);
        }

        $columns = [
            'business_industry_code',
            'business_name',
            'number_of_labor',
            'business_owner',
            'business_address',
            'business_phone',
            'contract_relationship_description',
            'accident_happen_description',
            'cause_of_accident_description',
            'improve_strategy_desciption',
            'pension_situation_description',
        ];
        $user = $this->getUserByJwt($request);
        $record = AccidentRecord::where('user_id', $user->id)->find($id);
        foreach ($columns as $column) {
            if ($request->has($column)) {
                $record->$column = $request[$column];
            }
        }
        $record->save();
        return $this->sendResponse($record, 200);
    }

    public function deleteRecord(Request $request, $id)
    {
        $request['id'] = $id;
        $validator = Validator::make($request->all(), [
            'id' => 'integer|exists:accident_records,id',
        ]);

        // 驗證錯誤時
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), IStatusCode::BAD_REQUEST);
        }

        $user = $this->getUserByJwt($request);
        $record = AccidentRecord::where('user_id', $user->id)->find($id);
        $record->victims()->delete();
        $record->causeOfAccidentImages()->delete();
        $record->contractRelationshipImages()->delete();
        $record->improveStrategyImages()->delete();
        $record->delete();
        return $this->sendResponse(null, 200);
    }


    public function generateWord(Request $request)
    {
        // 建立一個新的 Word 物件
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $header = ['size' => 16, 'bold' => true];
        $spanTableStyleName = 'Colspan Rowspan';
        $fancyTableStyle = ['borderSize' => 6, 'borderColor' => '999999', 'cellMargin' => 75];
        $paragraphStyleName = 'pStyle';
        $tableTitleStyle = 'tableTitleStyle';
        $tableContentStyle = 'tableContentStyle';
        $underlinStyle = 'underlineStyle';
        // 'underline' => \PhpOffice\PhpWord\Style\Font::UNDERLINE_SINGLE
        $phpWord->addFontStyle($tableTitleStyle, ['name' => '標楷體', 'size' => 16]);
        $phpWord->addFontStyle($tableContentStyle, ['name' => '標楷體', 'size' => 14]);
        $phpWord->addFontStyle($underlinStyle, ['name' => '標楷體', 'size' => 14, 'underline' => Font::UNDERLINE_SINGLE]);
        $phpWord->addParagraphStyle($paragraphStyleName, ['alignment' => Jc::CENTER, 'spaceAfter' => 100, 'name' => '標楷體', 'size' => 16]);

        $section->addText($request['business_name'] . "     工作場所職業災害調查結果表", $header, $paragraphStyleName);
        $phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);
        $datas = (object) $request->all();
        $table = $section->addTable($spanTableStyleName);

        // 罹災者資料
        $table->addRow();
        $table->addCell(9000)->addText('一、罹災者資料', $tableTitleStyle);
        if ($request->has('victims') && !empty($request['victims'])) {
            foreach ($request['victims'] as $victim) {
                $victim = json_decode($victim);
                // $victim = (object)$victim;
                $table->addRow();
                $textRun = $table->addCell(9000)->addTextRun();

                $textRun->addText("姓名：", $tableContentStyle);
                $name = empty($victim->name) ? "   " : $victim->name;
                $textRun->addText("   $name      ", $underlinStyle);

                $textRun->addText("  身分證字號：", $tableContentStyle);
                $id_number = empty($victim->id_number) ? "   " : $victim->id_number;
                $textRun->addText("   $id_number     ", $underlinStyle);

                $textRun->addText("  服務單位：", $tableContentStyle);
                $service_unit = empty($victim->service_unit) ? "   " : $victim->service_unit;
                $textRun->addText("    $service_unit    ", $underlinStyle);

                $textRun->addText("  出生日期：", $tableContentStyle);
                $birthday = empty($victim->birthday) ? "   " : $victim->birthday;
                $textRun->addText("    $birthday    ", $underlinStyle);

                $textRun->addText("  到職日期：", $tableContentStyle);
                $employment_date = empty($victim->employment_date) ? "   " : $victim->employment_date;
                $textRun->addText("    $employment_date    ", $underlinStyle);

                $textRun->addText("  聯絡電話：", $tableContentStyle);
                $phone = empty($victim->phone) ? "   " : $victim->phone;
                $textRun->addText("    $phone    ", $underlinStyle);

                $textRun->addText("  地(住)址：", $tableContentStyle);
                $address = empty($victim->address) ? "   " : $victim->address;

                $textRun->addText("    $address    ", $underlinStyle);
                $textRun->addText("  受傷程度：", $tableContentStyle);

                $degree_of_injury = empty($victim->degree_of_injury) ? "   " : $victim->degree_of_injury;
                $textRun->addText("    $degree_of_injury    ", $underlinStyle);
            }
        }
        // 公司資訊
        $table->addRow();
        $table->addCell(9000)->addText("二、" . $request['business_name'] . "基本資料", $tableTitleStyle);
        $table->addRow();
        $textRun = $table->addCell(9000)->addTextRun();

        $textRun->addText("行業別：", $tableContentStyle);
        $business_industry = empty($datas->business_industry) ? "   " : $datas->business_industry;
        $textRun->addText("     $business_industry     ", $underlinStyle);

        $textRun->addText("  勞工人數：", $tableContentStyle);
        $number_of_labor = empty($datas->number_of_labor) ? "   " : $datas->number_of_labor;
        $textRun->addText("     $number_of_labor     ", $underlinStyle);

        $textRun->addText("  代表人姓名：", $tableContentStyle);
        $business_owner = empty($datas->business_owner) ? "   " : $datas->business_owner;
        $textRun->addText("     $business_owner    ", $underlinStyle);

        $textRun->addText("  地址：", $tableContentStyle);
        $business_address = empty($datas->business_address) ? "   " : $datas->business_address;
        $textRun->addText("     $business_address    ", $underlinStyle);

        $textRun->addText("  聯絡電話：", $tableContentStyle);
        $business_phone = empty($datas->business_phone) ? "   " : $datas->business_phone;
        $textRun->addText("     $business_phone    ", $underlinStyle);

        // 承攬關係
        $table->addRow();
        $table->addCell(9000)->addText("三、承攬關係(含承攬關係圖)：", $tableTitleStyle);
        $table->addRow();

        $textRun = $table->addCell(9000)->addTextRun();
        $contract_relationship_description = empty($datas->contract_relationship_description) ? "" : $datas->contract_relationship_description;
        $textRun->addText($contract_relationship_description, $tableContentStyle);
        if ($request->has('contract_relationship_images') && !empty($request['contract_relationship_images'])) {
            if ($request->hasFile('contract_relationship_images')) {
                foreach ($request->file('contract_relationship_images') as $image) {
                    $fileName = $image->store('contract_relationship', 'public');
                    $textRun->addImage(asset("storage/$fileName"), [
                        'width' => 400,
                        'alignment' => Jc::CENTER
                    ]);
                    Storage::disk('public')->delete($fileName);
                }
            } else {
                foreach ($request['contract_relationship_images'] as $image) {
                    if (!empty($image)) {
                        $textRun->addImage($image, [
                            'width' => 400,
                            'alignment' => Jc::CENTER
                        ]);
                    }
                }
            }
        }
        // 事發經過
        $table->addRow();
        $table->addCell(9000)->addText("四、事故發生經過情形：", $tableTitleStyle);
        $table->addRow();
        $textRun = $table->addCell(9000)->addTextRun();
        $accident_happen_description = empty($datas->accident_happen_description) ? "" : $datas->accident_happen_description;
        $textRun->addText($accident_happen_description, $tableContentStyle);

        // 事故發生原因
        $table->addRow();
        $table->addCell(9000)->addText("五、事故發生原因(含顯示災害現場照片及肇災原因分析)：", $tableTitleStyle);
        $table->addRow();

        $textRun = $table->addCell(9000)->addTextRun();
        $cause_of_accident_description = empty($datas->cause_of_accident_description) ? "" : $datas->cause_of_accident_description;
        $textRun->addText($cause_of_accident_description, $tableContentStyle);

        if ($request->has('cause_of_accident_images') && !empty($request['cause_of_accident_images'])) {
            if ($request->hasFile('cause_of_accident_images')) {
                foreach ($request->file('cause_of_accident_images') as $image) {
                    $fileName = $image->store('cause_of_accident', 'public');
                    $textRun->addImage(asset("storage/$fileName"), [
                        'width' => 400,
                        'alignment' => Jc::CENTER
                    ]);
                    Storage::disk('public')->delete($fileName);
                }
            } else {
                foreach ($request['cause_of_accident_images'] as $image) {
                    if (!empty($image)) {
                        $textRun->addImage($image, [
                            'width' => 400,
                            'alignment' => Jc::CENTER
                        ]);
                    }
                }
            }
        }

        // 六、改善對策
        $table->addRow();
        $table->addCell(9000)->addText("六、改善對策(含改善照片或改善圖說)：", $tableTitleStyle);
        $table->addRow();
        $textRun = $table->addCell(9000)->addTextRun();
        $improve_strategy_desciption = empty($datas->improve_strategy_desciption) ? "" : $datas->improve_strategy_desciption;
        $textRun->addText($improve_strategy_desciption, $tableContentStyle);
        if ($request->has('improve_strategy_images') && !empty($request['improve_strategy_images'])) {
            if ($request->hasFile('improve_strategy_images')) {
                foreach ($request->file('improve_strategy_images') as $image) {
                    $fileName = $image->store('improve_strategy', 'public');
                    $textRun->addImage(asset("storage/$fileName"), [
                        'width' => 400,
                        'alignment' => Jc::CENTER
                    ]);
                    Storage::disk('public')->delete($fileName);
                }
            } else {
                foreach ($request['improve_strategy_images'] as $image) {
                    if (!empty($image)) {
                        $textRun->addImage($image, [
                            'width' => 400,
                            'alignment' => Jc::CENTER
                        ]);
                    }
                }
            }
        }

        // 七、撫恤情形：
        $table->addRow();
        $table->addCell(9000)->addText("七、撫恤情形：", $tableTitleStyle);
        $table->addRow();
        $textRun = $table->addCell(9000)->addTextRun();
        $pension_situation_description = empty($datas->pension_situation_description) ? "" : $datas->pension_situation_description;
        $textRun->addText($pension_situation_description, $tableContentStyle);

        // 簽章部分
        $table->addRow();
        $table->addCell(9000)->addText("負責人：            安衛主管：            填表人：
        會同勞工代表：
        ", $tableTitleStyle);

        $filename = now() . '.docx';
        $phpWord->save('../storage/app/' . $filename);
        return response()->download('../storage/app/' . $filename)->deleteFileAfterSend(true);
    }


    public static function linkAll($record)
    {
        $_record = $record;
        $_record->victims;
        $_record->causeOfAccidentImages;
        $_record->contractRelationshipImages;
        $_record->improveStrategyImages;
        return $_record;
    }


    public function getUserByJwt($request)
    {
        // 取得Request的Header。
        $header = $request->header('authorization');

        // 從Header中取得JWT。
        $jwt = str_replace("Bearer ", '', $header);

        // 驗證JWT，若沒問題則取得Payload的部分，內部包含使用者資訊。
        $userInfo = TokenController::verifyAndBase64DecodeJwt($jwt);

        // 驗證失敗。
        if ($userInfo === false) {
            return $this->sendResponse('JWT錯誤', IStatusCode::BAD_REQUEST);
        }

        // 取得指定使用者。
        return User::where('id', $userInfo->userId)->first();
    }
}
