<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialModel extends Model
{
    public $timestamps = false;
    protected $fillable = ['Provider_User_ID', 'Provider', 'User'];
    protected $primaryKey = 'User_ID';
    protected $table = "tbl_social";
    public function Login()
    {
        return $this->belongsTo('App\Models\LoginModel', 'User');
    }
}