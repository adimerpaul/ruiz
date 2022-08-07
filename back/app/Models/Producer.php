<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producer extends Model
{
    use HasFactory;
    protected $fillable= [
        'nombres',
        'apellidos',
        'ci',
        'edad',
        'fechanNacimiento',
        'nroFamilia',
        'varones',
        'mujeres',
        'celular',
        'provincia',
        'departamento',
        'municipio',
        'comunidad',
        'superficie',
        'semilla',
        'abono',
        'maquinaria',
        'riego',
        'quinua',
        'asociacion',
        'mejorar',
        'fecha',
        'hora',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
