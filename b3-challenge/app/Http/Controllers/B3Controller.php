<?php

namespace App\Http\Controllers;

use App\Jobs\ProccessB3;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class B3Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ativos = DB::table('b3')
            ->select('tckrsymb')
            ->groupBy('tckrsymb')
            ->get()
            ->toArray();

        $ativos = collect($ativos)->pluck('tckrsymb')->all();

        $current_ativo = $request->input('ativo') ? $request->input('ativo') : "A1DM34"; //Default chart

        $data_ativo = DB::table('b3')
            ->select('rpttd', 'balqty', 'tradavrgpric')        
            ->where('tckrsymb', $current_ativo)
            ->get()
            ->toArray();

        $dataset_balqty = collect($data_ativo)->pluck('balqty')->all();
        $dataset_tradavrgpric = collect($data_ativo)->pluck('tradavrgpric')->all();
        $labels = collect($data_ativo)->sort()->pluck('rpttd')->all();

        return Inertia::render('Dashboard/B3', [
            'current_ativo' => $current_ativo,
            'ativos' => $ativos,
            'dataset_balqty' => $dataset_balqty,
            'dataset_tradavrgpric' => $dataset_tradavrgpric,
            'labels' => $labels,            
        ]);
    }

    /**
     * Import B3 Posições em Aberto de Empréstimo into database.
    */
    public function import($datas)
    {        
        if ($datas[0] == "latest") {
            $datas = array(Carbon::yesterday()->format('Y-m-d')); // Pego o ultimo porque o dia de hoje pode nao ter mais o de ontem geralmente ja tem o arquivo
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
                //Add File to queue
                dispatch(new ProccessB3($response->file->name));
            } catch (Exception $e) {
                return 'Erro na request ou o arquivo ainda não existe '.$e->getMessage();
            }
        }

        return 'Importação de arquivos concluída';

    }
}
