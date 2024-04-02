<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="System Laragpt",
 *         version="1.0",
 *         description="Descripción de mi API"
 *     ),
 *     @OA\Server(
*      url = L5_SWAGGER_CONST_HOST,
 *     description = "My Server",
 *    )
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
