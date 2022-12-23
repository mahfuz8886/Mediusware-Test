<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariantPrice extends Model
{
     public function color() {
          return $this->belongsTo(ProductVariant::class, 'product_variant_one', 'id');
     }

     public function size() {
          return $this->belongsTo(ProductVariant::class, 'product_variant_two', 'id');
     }

     public function style() {
          return $this->belongsTo(ProductVariant::class, 'product_variant_three', 'id');
     }
}
