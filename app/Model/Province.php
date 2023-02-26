<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public $timestamps = false;
    protected $fillable = ['Province_Name', 'Province_Type'];
    protected $primaryKey = 'Province_ID';
    protected $table = "tbl_tinhthanhpho";
}