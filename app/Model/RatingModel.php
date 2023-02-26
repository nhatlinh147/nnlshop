<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingModel extends Model
{
    public $timestamps = false;
    protected $fillable = ['Rating_Product_ID', 'Rating_Star'];
    protected $table = 'tbl_star_rating';
    protected $primaryKey = 'Rating_ID';
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'Rating_Product_ID');
    }
}