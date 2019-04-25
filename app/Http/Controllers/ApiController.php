<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Laravel\Lumen\Routing\Controller as BaseController;

/*
    https://medium.com/tech-tajawal/jwt-authentication-for-lumen-5-6-2376fd38d454
*/
use Validator;
use App\User;
use App\Role;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;

class ApiController extends BaseController
{
    const leaveUntouched=["active"=>true]; // TODO:: explain (or change) why we need an associated array here (updateOrNew -> array_diff

    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

//////////////////////////////////////////////////////////////////////

    // TODO:: Test and Authorize

    private function fullModelName($modelName){
        return "App\\".$modelName;
    }

    private function createModelResponse() {
        $model = $this->request->input('model');
        return response()->json([
            "model" => $model,
            "data" => $this->fullModelName($model)::all()
        ]);
    }

    private function getInstance($model, $id) {
        return $this->fullModelName($model)::find($id);
    }

    public function setModel(Request $request){
        $params=$request->input();
        $data=$params['data'];
        $relation=$params['relation'];
        switch ($params['type']) {
            case 'newModel':
                $this->fullModelName($params['model'])::create($data);
                break;
            case 'updateModel':
                $this->getInstance($params['model'], $data['id'])->fill($data)->save();
                break;
            case 'addBelongsToModels':
                $relModel = call_user_func([
                    $this->getInstance($relation['model'],$relation['id']),
                    $params['model']
                ]);
                $relModel->createMany($data);
                break;
            case 'replaceBelongsToModels':
                $relModel = call_user_func([
                    $this->getInstance($relation['model'],$relation['id']),
                    $params['model']
                ]);
                $relModel->delete();
                $relModel->createMany($data);
                break;
            default:
                return response()->json('no such type', 404);
        }
        return $this->createModelResponse();
    }

    //////////////////////////////////////////////////////////////////////

    public function getModel(Request $request){
        //$this->authorize('canRead',$modelFullName);
        // TODO:: remove brake
        //if ($modelName === "PlayCapacityrow")  sleep(5);
        return $this->createModelResponse();
    }

//////////////////////////////////////////////////////////////////////

    public function getUsers(){
        $users=User::with("roles")->get();
//        $users=User::all();
        $ret=$users->map(function($user){
            return [
                'id'=>$user->id,
                'name' => $user->username,
                'fullname' => $user->fullname,
                'email' => $user->email,
                'image' => $this->img_base64("user/",$user->image),
                'roles' => $user->roles
                ];
        },$users);
        return response()->json($ret);
    }

    public function updateRoles(){
//      $data=$this->request->json()->all();
      $data=$this->request->input();
      $user=User::find($data["id"]);
      $user->roles()->sync($data["roles"]);
        return response()->json("OK");
    }

    public function getOptions(){
        $roles=Role::all();
        $ret=[
            'roles' => $roles
            ];
        return response()->json($ret);
    }

    private function img_base64(string $store, string $filename = null) {
        //$filename=storage_path("pics/user/".$filename);
        if ($filename) {
            $filename="pics/".$store.$filename;
            $pic = Storage::get($filename);
            return "data:image/jpeg;base64," . base64_encode($pic);
        } else return "";
    }
}
