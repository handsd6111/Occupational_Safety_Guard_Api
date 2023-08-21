<?php

namespace App\Http\Controllers;

use App\Models\AccidentRecord;
use App\Models\Interfaces\IStatusCode;
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
        if ($id != 0) {

            $record = AccidentRecord::find($id);
            if (!empty($record)) {
                $record = $this->linkAll($record);
            }
            return $this->sendResponse($record, 200);
        }

        $records = AccidentRecord::all();
        $countOfData = AccidentRecord::count();

        return $this->sendResponse($records, 200, $countOfData);
    }

    public function createRecord(Request $request)
    {
        $record = AccidentRecord::create();
        $victim = Victim::create(['ar_id' => $record->id]);
        $record->victims()->save($victim);
        $result = AccidentRecord::find($record->id);
        $result = $this->linkAll($result);

        return $this->sendResponse($result, 200, 1, 1);
    }


    public function updateRecord(Request $request, $id)
    {
        // 建立Validation規則。
        // $validator = Validator::make($request->all(), [
        // ]);

        // if ($validator->fails()) {
        //     return $this->sendResponse($validator->errors(), IStatusCode::BAD_REQUEST);
        // }
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
        $record = AccidentRecord::find($id);
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
        $record = AccidentRecord::find($id);
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
        foreach ($request['victims'] as $victim) {
            $victim = (object)$victim;
            $table->addRow();
            $textRun = $table->addCell(9000)->addTextRun();
            $textRun->addText("姓名：", $tableContentStyle);
            $textRun->addText("   $victim->name     ", $underlinStyle);
            $textRun->addText("  身分證字號：", $tableContentStyle);
            $textRun->addText("   $victim->id_number     ", $underlinStyle);
            $textRun->addText("  服務單位：", $tableContentStyle);
            $textRun->addText("    $victim->service_unit    ", $underlinStyle);
            $textRun->addText("  出生日期：", $tableContentStyle);
            $textRun->addText("    $victim->birthday    ", $underlinStyle);
            $textRun->addText("  到職日期：", $tableContentStyle);
            $textRun->addText("    $victim->employment_date    ", $underlinStyle);
            $textRun->addText("  聯絡電話：", $tableContentStyle);
            $textRun->addText("    $victim->phone    ", $underlinStyle);
            $textRun->addText("  地(住)址：", $tableContentStyle);
            $textRun->addText("    $victim->address    ", $underlinStyle);
            $textRun->addText("  受傷程度：", $tableContentStyle);
            $textRun->addText("    $victim->degree_of_injury    ", $underlinStyle);
        }

        // 公司資訊
        $table->addRow();
        $table->addCell(9000)->addText("二、" . $request['business_name'] . "基本資料", $tableTitleStyle);
        $table->addRow();
        $textRun = $table->addCell(9000)->addTextRun();
        $textRun->addText("行業別：", $tableContentStyle);
        $textRun->addText("     $datas->business_industry     ", $underlinStyle);
        $textRun->addText("  勞工人數：", $tableContentStyle);
        $textRun->addText("     $datas->number_of_labor     ", $underlinStyle);
        $textRun->addText("  代表人姓名：", $tableContentStyle);
        $textRun->addText("     $datas->business_owner    ", $underlinStyle);
        $textRun->addText("  地址：", $tableContentStyle);
        $textRun->addText("     $datas->business_address    ", $underlinStyle);
        $textRun->addText("  聯絡電話：", $tableContentStyle);
        $textRun->addText("     $datas->business_phone    ", $underlinStyle);

        // 承攬關係
        $table->addRow();
        $table->addCell(9000)->addText("三、承攬關係(含承攬關係圖)：", $tableTitleStyle);
        $table->addRow();
        $textRun = $table->addCell(9000)->addTextRun();
        $textRun->addText($datas->contract_relationship_description, $tableContentStyle);
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
                $textRun->addImage($image, [
                    'width' => 400,
                    'alignment' => Jc::CENTER
                ]);
            }
        }
        // 事發經過
        $table->addRow();
        $table->addCell(9000)->addText("四、事故發生經過情形：", $tableTitleStyle);
        $table->addRow();
        $textRun = $table->addCell(9000)->addTextRun();
        $textRun->addText($datas->accident_happen_description, $tableContentStyle);

        // 事故發生原因
        $table->addRow();
        $table->addCell(9000)->addText("五、事故發生原因(含顯示災害現場照片及肇災原因分析)：", $tableTitleStyle);
        $table->addRow();
        $textRun = $table->addCell(9000)->addTextRun();
        $textRun->addText($datas->cause_of_accident_description, $tableContentStyle);
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
                // return ($image);
                $textRun->addImage($image, [
                    'width' => 400,
                    'alignment' => Jc::CENTER
                ]);
            }
        }

        // 六、改善對策
        $table->addRow();
        $table->addCell(9000)->addText("六、改善對策(含改善照片或改善圖說)：", $tableTitleStyle);
        $table->addRow();
        $textRun = $table->addCell(9000)->addTextRun();
        $textRun->addText($datas->improve_strategy_desciption, $tableContentStyle);
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
                // return ($image);
                $textRun->addImage($image, [
                    'width' => 400,
                    'alignment' => Jc::CENTER
                ]);
            }
        }

        // 七、撫恤情形：
        $table->addRow();
        $table->addCell(9000)->addText("七、撫恤情形：", $tableTitleStyle);
        $table->addRow();
        $textRun = $table->addCell(9000)->addTextRun();
        $textRun->addText($datas->pension_situation_description, $tableContentStyle);

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
}
