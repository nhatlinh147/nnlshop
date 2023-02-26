<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repository;

use App\Model\GalleryModel;
use App\Model\Product;
use Illuminate\Support\Facades\File;
use App\Repository\BaseRepository;

/**
 * Description of AdminUserRepository
 *
 * @author nnlinh
 */
class ProductRepository extends BaseRepository implements ProductInterface
{

    public function getModel()
    {
        return \App\Model\Product::class;
    }
    public function findBySlug($slug)
    {
        return $this->model::where('Product_Slug', $slug)->first();
    }
}