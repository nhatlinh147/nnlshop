<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoModel extends Model
{
    public $timestamp = false;
    protected $fillable = [
        'Video_Name', 'Video_Title', 'Video_Slug',
        'Video_Link', 'Video_Desc', 'Video_Image'
    ];
    protected $table = 'tbl_video';
    protected $primaryKey = 'Video_ID';
}