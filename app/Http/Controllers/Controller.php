<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Config;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="Mi System Laragpt",
 *         version="1.0",
 *         description="Descripción de mi API"
 *     ),
 *     @OA\Server(url=LaravelConstant::API_URL)
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
