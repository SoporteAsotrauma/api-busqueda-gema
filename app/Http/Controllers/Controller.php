<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="API de Búsqueda GEMA",
 *     version="1.0.0",
 *     description="Documentación de la API para la búsqueda en FoxPro",
 *     @OA\Contact(
 *         email="soporte@asotrauma.com.co"
 *     )
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
