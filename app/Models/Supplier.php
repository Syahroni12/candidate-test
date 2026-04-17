<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';
    protected $guarded = ['id'];

    public function layups()
    {
        return $this->hasMany(Layup::class, 'supplier_id', 'id');
    }
}
