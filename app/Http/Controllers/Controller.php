<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(title="CMS-APP REST APIS", version="1.0")
 * 
 * @OA\Server(url="http://localhost:8000")
 * 
 * @OA\SecurityScheme(
 *    securityScheme="sanctum",
 *    in="header",
 *    name="Authorization",
 *    type="http",
 *    scheme="bearer",
 *    bearerFormat="JWT",
 * )
 */

class Controller extends BaseController
{
    use DispatchesJobs, AuthorizesRequests, ValidatesRequests;
}
