<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $fillable = [
        'title', 'description'
    ];

    public function variants() {
        return $this->hasMany(ProductVariant::class);
    }

    public function variants_name() {
        return ProductVariant::where('variant_id', $this->id)->select('variant')->distinct()->get();
    }

}
