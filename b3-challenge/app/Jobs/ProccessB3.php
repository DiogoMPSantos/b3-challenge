<?php

namespace App\Jobs;

use App\Http\Controllers\B3Controller;
use App\Models\B3;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProccessB3 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filename;

    /**
     * Create a new job instance.
     */
    public function __construct(String $filename)
    {
        $this->filename  = $filename;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {   
        $path = Storage::disk('public')->path("data/{$this->filename}.csv");
        $file = fopen($path, "r");

        $first_row = true;
        
        while (!feof($file)) {
            $row = fgetcsv($file, 0, ";");

            if($first_row) { 
                $first_row = false; 
                continue; 
            }

            if ($row) {    
                B3::create([
                    "rpttd" => Carbon::parse($row[0]),
                    "tckrsymb" => $row[1],
                    "isin" => $row[2],
                    "asst" => $row[3],
                    "balqty" => intval($row[4]),
                    "tradavrgpric" => floatval($row[5]),
                    "pricfctr" => intval($row[6]),
                    "balval" => floatval($row[7]),
                ]);
            }
        }   

        //Remove o arquivo apos inserir as linhas
        if (Storage::disk('public')->exists("data/{$this->filename}.csv")) {
            Storage::disk('public')->delete("data/{$this->filename}.csv");
        }
    }
}
