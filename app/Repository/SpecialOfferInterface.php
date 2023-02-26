<?php

namespace App\Repository;

use App\Repository\BaseInterface;

interface SpecialOfferInterface  extends BaseInterface
{
    public function combineSearchWithSort($query, $condition);
}