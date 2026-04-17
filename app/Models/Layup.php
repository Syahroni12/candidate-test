<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layup extends Model
{
    protected $table = 'layups';
    protected $guarded = ['id'];
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function layers()
    {
        return $this->hasMany(Layer::class, 'layup_id', 'id')->orderBy('layer_order');
    }

}
