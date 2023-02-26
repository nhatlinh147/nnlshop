<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VisitorModel extends Model
{
    public $timestamp = false;
    protected $fillable = ['Visitor_Ip_Address', 'Visitor_Date'];
    protected $table = 'tbl_visitor';
    protected $primaryKey = 'Visitor_ID';
}