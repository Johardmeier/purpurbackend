<?php
/**
 * Created by IntelliJ IDEA.
 * User: Johannes
 * Date: 08.12.2018
 * Time: 14:54
 */

use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;


class UsersTableSeeder extends BaseSeeder
{
    private $roleVars=[
        ['name'=>'Administrator', 'slug'=>'admin','permissions'=>['view','create','edit','delete']],
        ['name'=>'Buero', 'slug'=>'buero','permissions'=>['view','create','edit']],
        ['name'=>'Kasse', 'slug'=>'kasse','permissions'=>['view']],
    ];

    private $uservars=[
        ['item'=>['username'=>'Admin','fullname'=>'Jo','password' =>'abc','email'=>'admin@theater-purpur.ch','image'=>'jo_avatar.jpg'],'roles'=>['admin','buero']],
        ['item'=>['username'=>'Johannes','fullname'=>'Johannes Hardmeier','password' =>'xyz','email'=>'jo@theater-purpur.ch'],'roles'=>['admin']],
        ['item'=>['username'=>'Claudia','fullname'=>'Claudia Seeberger','password' =>'abc','email'=>'claudia@theater-purpur.ch'],'roles'=>['kasse']],
    ];

    public function run(){
        Role::query()->delete();
        foreach($this->roleVars as $role) {
            Role::create($role);
        }
        User::query()->delete();
        foreach($this->uservars as $user) {
            $user['item']['password']=Hash::make($user['item']['password']);
            $userItem=User::create($user['item']);
            foreach($user['roles'] as $userRole){
                $userItem->roles()->attach(Role::where('slug',$userRole)->first()->id);
            }
        }
    }
}