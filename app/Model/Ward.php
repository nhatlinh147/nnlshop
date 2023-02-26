<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    public $timestamps = false;
    protected $fillable = ['Ward_Name', 'Ward_Type', 'Ward_District_ID'];
    protected $primaryKey = 'Ward_ID';
    protected $table = "tbl_xaphuongthitran";
}