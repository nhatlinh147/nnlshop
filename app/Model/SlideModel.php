<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SlideModel extends Model
{
    public $timestamp = false;
    protected $fillable = ['Slide_Title', 'Slide_Status', 'Slide_Image', 'Slide_Desc', 'Slide_More', 'Meta_Keywords_Slide'];
    protected $table = 'tbl_slide';
    protected $primaryKey = 'Slide_ID';
}