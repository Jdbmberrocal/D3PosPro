<?php

namespace App\Utils;

use Illuminate\Support\Facades\File;

class UnitsUtil
{
    /**
     * Leer un archivo JSON desde una ruta específica
     *
     * @param string $path
     * @return array|null
     */
    public static function leerJson(string $path): ?array
    {
        if (!File::exists($path)) {
            return null;
        }

        $contenido = File::get($path);
        return json_decode($contenido, true);
    }
}
