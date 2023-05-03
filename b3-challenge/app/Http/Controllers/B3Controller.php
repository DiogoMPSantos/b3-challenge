<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

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
    public function import()
    {        
        return 'opa aqui vai importar depois';
    }
}
