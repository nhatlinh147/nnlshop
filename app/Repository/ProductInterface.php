<?php

namespace App\Repository;

use App\Repository\BaseInterface;

interface ProductInterface  extends BaseInterface
{
    public function findBySlug($slug);
}