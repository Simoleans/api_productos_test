<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Productos extends Model
{
    use HasFactory;

    protected $table = "productos";

    public $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'imagen',
    ];

    /* 
        metodo para guardar imagen
        @return url de la foto
    */
    public function storeImagen($imagen)
    {
        $filenameWithExt = $imagen->getClientOriginalName();
        $nameFile = time().'.'.$filenameWithExt;

        $url = $imagen->storeAs('productos/imagenes', $nameFile,'public');

        return $url;
    }
}
