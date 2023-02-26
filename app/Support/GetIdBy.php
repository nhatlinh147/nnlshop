<?php

namespace App\Support;

use App\Model\Product;
use Illuminate\Http\Request;
use App\Model\PropProductModel;

class GetIdBy
{
    // *** Class variables
    protected $array;

    protected $key;

    function __construct($array, $key)
    {
        $this->array = $this->addToArrayIf($array);
        $this->key = $key;
    }

    private function addToArrayIf($array)
    {
        $add_to_array = ['2XL', '3XL', '4XL', '5XL'];
        if (is_numeric($array)) {
            return $array;
        } else {
            if (in_array('XL', $array)) {
                $merge = array_merge($array, $add_to_array);
                return  $merge;
            } else {
                return $array;
            }
        }
    }

    public function getIdBySize()
    {
        $prop = PropProductModel::orderBy('Prop_ID', 'DESC');

        foreach ($this->array as $value) {
            $prop_query = $prop->orWhere($this->key, 'LIKE', $value . ',%')->orWhere($this->key, 'LIKE', '%,' . $value)
                ->orWhere($this->key, 'LIKE', '%,' . $value . ',%');
        }
        $array_product_id = json_decode($prop_query->pluck('Prop_Product_ID'), true);
        $array_product_id =  explode(',', implode(',', $array_product_id));
        return $array_product_id;
    }
    public function getAttr()
    {
        $value = $this->array; //lúc này $this->array sẽ lấy giá trị id được truyền vào
        $key_query = $this->key;
        $result = PropProductModel::orWhere('Prop_Product_ID', 'LIKE', $value . ',%')
            ->orWhere('Prop_Product_ID', 'LIKE', '%,' . $value)
            ->orWhere('Prop_Product_ID', 'LIKE', '%,' . $value . ',%')
            ->first();
        if ($result) {
            $get_array_attr = explode(",", $result[$key_query]);
        } else {
            $get_array_attr = "Không";
        }
        return $get_array_attr;
    }
}