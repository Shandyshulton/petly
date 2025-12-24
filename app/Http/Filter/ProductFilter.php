<?php

namespace App\Http\Filter;

class ProductFilter extends QueryFilter
{

    public function productType($id)
    {
        return $this->builder->where('product_product_type_id', $id);
    }

    public function petType($id)
    {
        return $this->builder->where('pet_pet_types_id', $id);
    }
    
    public function title($name)
    {
        return $this->builder->where('name', 'like', $name . '%');
    }
}
