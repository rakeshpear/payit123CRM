<?php

namespace App\Console\Commands;

use App\Jobs\GenerateClientExcel;
use function Laravel\Prompts\alert;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateExcelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:excel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Weekly Reports every Monday for all Clients';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        GenerateClientExcel::dispatch();
        $this->info('Weekly Report generation job dispatched!');
    }
}
