<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public $timestamps = false;
    protected $fillable = ['District_Name', 'District_Type', 'District_Province_ID'];
    protected $primaryKey = 'District_ID';
    protected $table = "tbl_quanhuyen";
}