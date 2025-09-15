<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name'); 
        $table->text('description')->nullable(); 
        $table->integer('quantity'); 
        $table->decimal('price', 10, 2);
        $table->string('frame_material')->nullable(); 
        $table->string('lens_color')->nullable(); 
        $table->string('lens_material')->nullable(); 
        $table->string('brand')->nullable(); 
        $table->float('weight')->nullable(); 
        $table->unsignedBigInteger('category_id'); 
         $table->string('image_url')->nullable(); 
        $table->timestamps();

        // Khóa ngoại
        $table->foreign('category_id')
              ->references('id')
              ->on('categories')
              ->onDelete('cascade');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
