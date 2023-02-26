<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CatePostModel extends Model
{
    public $timestamp = false;
    protected $fillable = ['Cate_Post_Name', 'Cate_Post_Slug', 'Cate_Post_Desc', 'Cate_Post_Status', 'Meta_Keywords_Cate_Post'];
    protected $table = 'tbl_cate_post';
    protected $primaryKey = 'Cate_Post_ID';
}