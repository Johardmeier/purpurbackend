<?php
/**
 * Created by IntelliJ IDEA.
 * User: Johannes
 * Date: 18.12.2018
 * Time: 08:27
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends BaseModelClass
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug','permissions',
    ];

    protected $casts=[
        'permissions'=>'array',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_users');
    }

    public function hasAccess(array $permissions):bool
    {
        foreach ($permissions as $permission){
            if ($this->hasPermission($permission))
                return true;
        }
        return false;
    }

    private function hasPermission(string $permission):bool
    {
        foreach($this->permissions as $grantedPermission)
            if($permission==$grantedPermission)
                return true;
            return false;
    }

}