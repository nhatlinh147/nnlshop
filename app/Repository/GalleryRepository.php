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
class GalleryRepository extends BaseRepository implements GalleryInterface
{
    public function getModel()
    {
        return \App\Model\GalleryModel::class;
    }
    public function newModel()
    {
        return $this->model = new \App\Model\GalleryModel();
    }
    public function findByProduct($product_id)
    {
        return $this->model::where('Product_ID', $product_id)->get();
    }
    public function findInProduct($product_id)
    {
        return $this->model::whereIn('Product_ID', $product_id)->get();
    }
    public function deleteInProduct($product_id)
    {
        return $this->model::whereIn('Product_ID', $product_id)->delete();
    }
    public function findInGallery($gallery_id)
    {
        return $this->model::whereIn('Gallery_ID', $gallery_id)->get();
    }
    public function deleteInGallery($gallery_id)
    {
        return $this->model::whereIn('Gallery_ID', $gallery_id)->delete();
    }
}