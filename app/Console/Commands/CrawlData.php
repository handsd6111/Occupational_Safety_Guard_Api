<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CrawlData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '爬取所有的資料';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $output = null;
        $returnValue = null; 
        $now = date('Y_m_d-H_i_s', time());
        $command = "cd /home/song/project/Occupational_Safety_Guard_Api/crawler;
                    mkdir -p /home/song/crawl-data;
                    mkdir -p /home/song/crawl-data/log;
                    sh execAll.sh >> /home/song/crawl-data/log/$now.log 2 >&1 &";

        exec($command, $output, $returnValue);

        $jsonOutput = json_encode($output);
        if ($returnValue === 0) {
            print("Output: $jsonOutput, Message: 成功");
        } else {
            print("Output: $jsonOutput, Message: 失敗");
        }
    }
}
