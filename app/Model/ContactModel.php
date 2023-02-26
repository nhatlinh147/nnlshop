<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactModel extends Model
{
    public $timestamps = false;
    protected $fillable = ['Contact_Info', 'Contact_Map', 'Contact_Logo', 'Slogan_Logo', 'Contact_FanPage'];
    protected $table = 'tbl_contact';
    protected $primaryKey = 'Contact_ID';
}