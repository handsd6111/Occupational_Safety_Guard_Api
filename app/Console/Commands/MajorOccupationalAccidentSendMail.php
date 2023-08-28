<?php

namespace App\Console\Commands;

use App\Http\Controllers\MajorOccupationalAccidentController;
use Illuminate\Console\Command;

class MajorOccupationalAccidentSendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'MOA-send-mail {moaId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '寄送新的重大職災事件';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $moaId = $this->argument('moaId');
        (new MajorOccupationalAccidentController)->sendMail($moaId);
    }
}
