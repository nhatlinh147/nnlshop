<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SocialCustomerModel extends Model
{
    public $timestamps = false;
    protected $fillable = ['Provider_User_ID', 'Provider', 'Customer_User'];
    protected $primaryKey = 'Social_Customer_ID';
    protected $table = "tbl_social_customer";
    public function Customer()
    {
        return $this->belongsTo('App\Model\CustomerModel', 'Customer_User');
    }
}