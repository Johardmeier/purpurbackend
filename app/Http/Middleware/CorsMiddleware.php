<?php
/**
 * Created by IntelliJ IDEA.
 * User: Johannes
 * Date: 22.12.2018
 * Time: 11:25
 */

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Http\Request;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // TODO:: Check this and ev. use spatie CORS Middleware
        $allowedOrigins = explode(',', env('CORS_PATHS'));
        $AOHeader='http://localhost:8080';
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            $origin = $_SERVER['HTTP_ORIGIN'];
            if (in_array($origin, $allowedOrigins)) {
                $AOHeader=$origin;
            }
        } else $AOHeader="*";
        //$AOHeader='localhost:8080';
        $headers = [
            'Access-Control-Allow-Origin'      => $AOHeader,
            'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE, PATCH',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age'           => '86400',
            'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With',
            'Access-Control-Expose-Headers'    => 'Authorization'
        ];

        if ($request->isMethod('OPTIONS'))
        {
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }

        $response = $next($request);
        foreach($headers as $key => $value)
        {
            $response->header($key, $value);
        }

        return $response;
    }

}