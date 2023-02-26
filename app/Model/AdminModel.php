<?php

namespace App\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AdminModel extends Authenticatable
{

    use Notifiable;

    protected $guard = 'admin';

    public $timestamp = false;
    protected $primaryKey = 'Admin_ID';
    protected $fillable = ['Admin_Email', 'Admin_Name', 'Admin_Password', 'Admin_Phone', 'Admin_Gender', 'remember_token'];
    protected $table = 'tbl_table';


    public function roles()
    {
        return $this->belongsToMany('App\Models\RoleModel');
    }
    public function getAuthPassword()
    {
        return $this->Admin_Password; // Hiểu là trả về cột password trong authentication
    }
    public function hasAnyRoles($roles)
    {
        return null !==  $this->roles()->whereIn('Name_Middleware', $roles)->first();
    }
    public function hasRole($role)
    {
        return null !== $this->roles()->where('Name_Middleware', $role)->first();
    }
}