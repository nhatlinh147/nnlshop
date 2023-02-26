<?php

namespace App\Repository;

use App\Model\PropProductModel;

class CountPageRepository
{
    /**
     * Get all
     * @return mixed
     */
    public function countPage($amount)
    {
        $count = count(PropProductModel::all());
        return ceil($count / $amount);
    }
}