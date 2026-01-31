<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
public function up()
{
Schema::create('items', function (Blueprint $table) {
$table->bigIncrements('id');
$table->string('name');
$table->integer('quantity')->default(0);
$table->decimal('price', 14, 2)->default(0.00);
$table->text('notes')->nullable();
$table->timestamps();
$table->integer('quantity_available')->default(0);
});
}

public function down()
{
Schema::dropIfExists('items');
}
}