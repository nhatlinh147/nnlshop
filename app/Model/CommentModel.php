<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentModel extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'Comment_Content', 'Comment_Name',
        'Comment_Date', 'Comment_Product_ID',
        'Comment_Parent_ID', 'Comment_Status'
    ];
    protected $table = 'tbl_comment';
    protected $primaryKey = 'Comment_ID';
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'Comment_Product_ID');
    }
}