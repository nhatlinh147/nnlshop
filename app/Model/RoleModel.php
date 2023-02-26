<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    public $timestamp = false;
    protected $fillable = ['Name_Middleware'];
    protected $table = 'tbl_author';
    protected $primaryKey = 'ID_Role_User';
    public function admin()
    {
        return $this->belongsToMany('App\Models\AdminModel');
    }
}