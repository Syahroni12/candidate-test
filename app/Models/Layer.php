<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layer extends Model
{
    protected $table = 'layers';
    protected $guarded = ['id'];

    public function layup()
    {
        return $this->belongsTo(Layup::class, 'layup_id', 'id');
    }
}
