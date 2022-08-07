<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultaController extends Controller
{
    public function consultaEdades()
    {
        return DB::select("SELECT edad,count(*) as cantidad FROM producers GROUP BY edad ORDER BY cantidad");
    }
    public function consultaUsers()
    {
        return DB::select("SELECT u.name,count(*) as cantidad FROM producers p INNER JOIN users u ON p.user_id=u.id GROUP BY u.name ORDER BY cantidad");
    }
}
