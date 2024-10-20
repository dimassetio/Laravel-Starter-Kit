<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id'); // Use increments for the primary key in Laravel 5.2
            $table->integer('product_id')->unsigned(); // Define the foreign key field and mark it as unsigned
            $table->integer('quantity');
            $table->decimal('price', 8, 2);
            $table->decimal('total', 10, 2);
            $table->date('sale_date')->nullable();
            $table->timestamps();

            // Add foreign key constraint in a way compatible with older MySQL versions
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
