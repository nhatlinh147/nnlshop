<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repository;

use App\Model\Product;
use Illuminate\Support\Facades\File;
use App\Repository\BaseRepository;

/**
 * Description of AdminUserRepository
 *
 * @author nnlinh
 */
class SpecialOfferRepository extends BaseRepository implements SpecialOfferInterface
{
    public function getModel()
    {
        return \App\Model\Product::class;
    }
    public function combineSearchWithSort($query, $condition)
    {
        if ($condition == 1) {
            $products =  $query->orderby('Product_Name', 'ASC')->get();
        } else if ($condition == 2) {
            $products =  $query->orderby('Product_Name', 'DESC')->get();
        } else if ($condition == 3) {
            $products =  $query->orderby('Product_Price', 'ASC')->get();
        } else if ($condition == 4) {
            $products =  $query->orderby('Product_Price', 'DESC')->get();
        } else {
            $products =  $query->get();
        }
        return $products;
    }
}