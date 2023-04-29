<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryGroup extends Model
{
    use HasFactory;

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'group_id', 'id');
    }
}
