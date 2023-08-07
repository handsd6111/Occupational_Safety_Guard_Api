<?php

namespace App\Console\Commands;

use App\Http\Controllers\Controller;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateRsaKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate-rsa-key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '產生 JWT 加密所需要的 RSA Key。';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 先刪除 Private Key 和 Public Key
        Storage::delete('access_rsa');
        Storage::delete('access_rsa.pub');
        $output = null;
        $returnValue = null; 
        $storageDirectory = "storage/app"; // 儲存 Key 的目錄
        /*
         * 以下這一段做了：
         *      1. 產生 Private key。
         *      2. 產生對應 Private Key 的 Public Key。
         *      3. 將兩把 Key 的群組都設成 www-data。
         *      4. 將兩把 Key 的群組權限設定成可讀，防止無法存取而導致的錯誤。
         */
        $command = "openssl genrsa -out $storageDirectory/access_rsa 4096;
                    openssl rsa -pubout -in $storageDirectory/access_rsa -out $storageDirectory/access_rsa.pub;
                    chgrp www-data $storageDirectory/access_rsa;
                    chgrp www-data $storageDirectory/access_rsa.pub;
                    chmod 640 $storageDirectory/access_rsa;
                    chmod 640 $storageDirectory/access_rsa.pub";

        exec($command, $output, $returnValue);
        $jsonOutput = json_encode($output);
        if ($returnValue === 0) {
            print("Output: $jsonOutput, Message: SSH Key 建立成功");
        } else {
            print("Output: $jsonOutput, Message: SSH Key 建立失敗");
        }
    }
}
