<?php

namespace App\Console\Commands;

use App\Models\RefreshToken;
use Illuminate\Console\Command;

class RemoveIfRefreshTokenExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove-if-refresh-token-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '刪除 SQL 中過期的 RefreshToken ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        RefreshToken::where('expired_time', '<', now())->delete();
    }
}
