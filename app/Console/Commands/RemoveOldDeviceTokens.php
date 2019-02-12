<?php

namespace App\Console\Commands;

use App\Models\DeviceToken;
use Illuminate\Console\Command;

class RemoveOldDeviceTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'device-tokens:clear-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear old device tokens from database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        DeviceToken::query()
            ->where('updated_at', '<', now()->minute(0)->second(0)->subMonth())
            ->forceDelete();
    }
}
