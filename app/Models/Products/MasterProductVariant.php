<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class MasterProductVariant extends Model
{

    protected $guarded = [];

    protected $casts = [];

    public function migration(Blueprint $table) {
        $table->id();
        $table->string('uuid');
        $table->foreignId('product_id');
        $table->string('name');
        $table->timestamps();
        $table->softDeletes();
    }
}
