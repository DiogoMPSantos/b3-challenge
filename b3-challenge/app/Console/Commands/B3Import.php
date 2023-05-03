<?php

namespace App\Console\Commands;

use App\Http\Controllers\B3Controller;
use Illuminate\Console\Command;

class B3Import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'b3-import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Posições em Aberto de Empréstimo de Ativos data into database every day midnight';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $b3 = new B3Controller();
        $this->info($b3->import());
    }
}
