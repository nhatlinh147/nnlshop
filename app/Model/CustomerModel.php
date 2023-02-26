<?php

namespace App\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CustomerModel extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;
    protected $fillable = [
        'Customer_Name',
        'Customer_Email',
        'Customer_Password',
        'Customer_Classify',
        'Customer_Phone',
        'Customer_Address',
        'Customer_Login',
        'Customer_Image'
    ];
    protected $primaryKey = 'Customer_ID';
    protected $table = 'tbl_customer';
    public function getAuthPassword()
    {
        return $this->Customer_Password; // Hiểu là trả về cột password trong authentication
    }
}