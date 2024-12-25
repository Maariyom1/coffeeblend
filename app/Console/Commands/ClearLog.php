<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the Laravel log file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            File::put(storage_path('logs/laravel.log'), '');

            // Only call $this->info() if the output is available
            if ($this->output) {
                $this->info('Logs have been cleared!');
            }
        } catch (\Exception $e) {
            // Only call $this->error() if the output is available
            if ($this->output) {
                $this->error('Failed to clear logs: ' . $e->getMessage());
            }
        }
    }
}
