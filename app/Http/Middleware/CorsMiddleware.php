<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware{
  public function handle($request, Closure $next){
    $headers = [
      'Access-Control-Allow-Origin'       => '*',
      'Access-Control-Allow-Methods'      => 'POST, PATCH, GET, DELETE, OPTIONS, PUT',
      'Access-Control-Allow-Credentials'  => 'true',
      'Access-Control-Allow-Headers'      => 'Content-Type, Authorization, X-Requested-With'
    ];
    
    if($request->isMethod('OPTIONS'))
      return response()->json('{"method":"OPTIONS"}', 200, $headers);

    $response = $next($request);

    foreach($headers as $key => $value)
      $response->header($key, $value);

    return $response;
  }
}