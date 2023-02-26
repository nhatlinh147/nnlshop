<?php

namespace App\Repository;

use App\Repository\BaseInterface;

interface GalleryInterface  extends BaseInterface
{
    public function findByProduct($product_id);
    public function findInProduct($product_id);
    public function deleteInProduct($product_id);
    public function findInGallery($gallery_id);
    public function deleteInGallery($gallery_id);
    public function newModel();
}