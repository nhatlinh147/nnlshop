<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_post';
    protected $fillable = [
        'Post_Title', 'Post_Slug', 'Post_Views', 'Post_Desc',
        'Post_Content', 'Meta_Keywords_Post', 'Meta_Desc_Post',
        'Post_Status', 'Post_Image', 'Cate_Post_ID'
    ];
    protected $primaryKey = 'Post_ID';
    public function cate_post()
    {
        return $this->belongsTo('App\Model\CatePostModel', 'Cate_Post_ID');
    }
}