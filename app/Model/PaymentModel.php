<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PaymentModel extends Model
{
    public $timestamps = false;
    protected $fillable = ['Payment_Method', 'Payment_Status'];
    protected $primaryKey = 'Payment_ID ';
    protected $table = "tbl_payment";
}