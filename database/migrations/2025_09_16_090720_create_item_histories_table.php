<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemHistoriesTable extends Migration
{
public function up()
{
Schema::create('item_histories', function (Blueprint $table) {
$table->bigIncrements('id');
$table->unsignedBigInteger('item_id');
$table->enum('action', ['restocked','issued']);
$table->integer('quantity');
$table->integer('balance');
$table->unsignedBigInteger('done_by');
$table->timestamps();
$table->decimal('price', 10, 2)->nullable();
$table->unsignedBigInteger('user_id')->nullable();
$table->string('type')->default('restock');

$table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
$table->foreign('done_by')->references('id')->on('users')->onDelete('cascade');
$table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
});
}

public function down()
{
Schema::dropIfExists('item_histories');
}
}
