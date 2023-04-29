<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    public function group()
    {
        return $this->hasone(InventoryGroup::class, 'id', 'group_id');
    }

    public function itemProperties()
    {
        return $this->hasMany(InventoryProperty::class, 'item_id', 'id');
    }

}
