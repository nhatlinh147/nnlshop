<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginModel extends Model
{
    public $timestamps = false;
    protected $fillable = ['Admin_Email', 'Admin_Password', 'Admin_Name', 'Admin_Phone'];
    protected $primaryKey = 'Admin_ID';
    protected $table = "tbl_table";

    // public function Social()
    // {
    //     return $this->hasOne('App\Models\SocialModel', 'Admin_ID','User');
    // }

}