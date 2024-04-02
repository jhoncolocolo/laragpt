<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="Mi System Laragpt",
 *         version="1.0",
 *         description="Descripción de mi API"
 *     ),
 *     @OA\Server(url="http://127.0.0.1:8000")
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
