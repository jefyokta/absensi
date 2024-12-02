<?php

namespace App\Console\Commands;

use App\Imports\User;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class UserImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->output->title("Starting import.....");

       (new User())->withOutput($this->output)->import(storage_path('/app/importusers.xlsx'));
        $this->output->success('Import successful');

    }
}
