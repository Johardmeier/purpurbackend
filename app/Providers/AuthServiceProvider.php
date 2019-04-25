<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Request;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function registerPolicies()
    {
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        Gate::define('hasPermission', function(User $user, ...$permissions) {
            return $user->hasAccess($permissions);
        });

/*        Gate::define('canRead', function(User $user, ...$permissions) {
            return $user->hasAccess($permissions);
        });*/

        /*
         * not tested:
        Gate::define('delete', function(User $user, $class) {
            return true if user amy delete this class
        });
         */

        $this->app['auth']->viaRequest('api', function (Request $request) {
            if (!$token = $request->bearerToken())
                return response()->json(['error' => 'Not authorized', 400]);
            try {
                $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
            } catch(ExpiredException $e) {
                return response()->json(['error' => 'Provided token is expired.', 400]);
            } catch(\Exception $e) {
                return response()->json(['error' => 'An error while decoding token.', 400]);
            }
            return User::find($credentials->sub);
        });
    }
}
