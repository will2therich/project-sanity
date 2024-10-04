<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class SubProduct extends Model
{

    protected $guarded = [];

    protected $casts = [];

    public function migration(Blueprint $table) {
        $table->id();
        $table->string('uuid');
        $table->foreignId('product_id');
        $table->foreignId('sub_product_group_id');
        $table->string('name');
        $table->integer('weight')->nullable();
        $table->string('thumbnail_image')->nullable();
        $table->string('external_image')->nullable();
        $table->string('internal_image')->nullable();
        $table->integer('pricing_type')->default(1);
        $table->integer('pricing_value')->default(1);
        $table->longText('conditionals')->nullable();
        $table->longText('inputs')->nullable();
        $table->boolean('flip_entire_image')->default(false);
        $table->boolean('conditionals_or_mode')->default(false);
        $table->timestamps();
        $table->softDeletes();
    }
}
