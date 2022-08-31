<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Base64Controller extends Controller
{
    public function base64(Request $request){
        if ($request->imagen==''){
            return '';
        }
        $path = 'imagenes/'.$request->imagen;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }
}
