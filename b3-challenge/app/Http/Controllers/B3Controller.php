<?php

namespace App\Http\Controllers;

use App\Models\B3;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Storage;

class B3Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'chart aqui';
    }

    /**
     * Import B3 Posições em Aberto de Empréstimo into database.
    */
    public function import($datas)
    {        
        if ($datas[0] == "latest") {
            $datas = array(Carbon::now()->format('Y-m-d'));
        }

        foreach ($datas as $key => $data) {
            $url = "https://arquivos.b3.com.br/api/download/requestname?fileName=LendingOpenPosition&date={$data}";

            try {
                $response = json_decode(file_get_contents($url));

                $base_url_download = "https://arquivos.b3.com.br/api/download?token={$response->token}";

                // Baixa o arquivo caso nao exista
                if (! Storage::disk('public')->exists("data/{$response->file->name}.csv")) {
                    try {
                        Storage::disk('public')->put("data/{$response->file->name}.csv", file_get_contents($base_url_download));
                    } catch (Exception $e) {
                        return $e->getMessage();
                    }
                }
    
                $path = Storage::disk('public')->path("data/{$response->file->name}.csv");
                $file = fopen($path, "r");
    
                $first_row = true;
                
                while (!feof($file)) {
                    $row = fgetcsv($file, 0, ";");
    
                    if($first_row) { 
                        $first_row = false; 
                        continue; 
                    }
    
                    if ($row) {    
                        try {
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
                        } catch (\Exception $e) {
                            return 'Erro na inserção da linha '.$e->getMessage();
                        }
                    }
                }   
    
                //Remove o arquivo apos inserir as linhas
                if (Storage::disk('public')->exists("data/{$response->file->name}.csv")) {
                    Storage::disk('public')->delete("data/{$response->file->name}.csv");
                }
            } catch (Exception $e) {
                return 'Erro na request ou o arquivo ainda não existe '.$e->getMessage();
            }
        }

        return 'Importação de arquivos concluída';

    }
}
