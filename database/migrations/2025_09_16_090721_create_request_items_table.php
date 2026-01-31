<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateRequestItemsTable extends Migration
{
public function up()
{
Schema::create('request_items', function (Blueprint $table) {
$table->bigIncrements('id');
$table->unsignedBigInteger('request_id');
$table->unsignedBigInteger('item_id');
$table->integer('quantity_requested');
$table->timestamps();

$table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade');
$table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
});
}

public function down()
{
Schema::dropIfExists('request_items');
}
}