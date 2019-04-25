<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Laravel\Lumen\Routing\Controller as BaseController;

/*
    https://medium.com/tech-tajawal/jwt-authentication-for-lumen-5-6-2376fd38d454
*/
use Validator;
use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    //

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;
    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }

    private function getRoles(User $user){
        $ret=[];
        $username=$user->username;
        $userroles=$user->roles;
        foreach ($user->roles as $role){
            $ret[]=$role->slug;
        }
        return $ret;
    }

    /**
     * Create a new token.
     *
     * @param  \App\User   $user
     * @return string
     */
    protected function jwt(User $user) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'roles' => $this->getRoles($user),
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60*60 // Expiration time
        ];

        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    }
    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     *
     * @param  \App\User   $user
     * @return mixed
     */
    public function authenticate(User $user) {
        $email=$this->request->getUser();
        $password=$this->request->getPassword();
        // Find the user by email
        $user = User::where('email', $email)->first();
        if (!$user) {
            // You wil probably have some sort of helpers or whatever
            // to make sure that you have the same response format for
            // differents kind of responses. But let's return the
            // below respose for now.
            return response()->json([
                'error' => 'Email does not exist.'
            ], 400);
        }
        // Verify the password and generate the token
        if (Hash::check($password, $user->password)) {
            return response()->json([
                'token' => $this->jwt($user),
                'name' => $user->username,
                'fullname' => $user->fullname,
                'image' => $this->img_base64($user->image),
            ], 200);
        }
        // Bad Request response
        return response()->json([
            'error' => 'Email or password is wrong.'
        ], 400);
    }

    private function img_base64(string $filename) {
        //$filename=storage_path("pics/user/".$filename);
        $filename="pics/user/".$filename;
        $pic = Storage::get($filename);
        return base64_encode($pic);
    }

}
