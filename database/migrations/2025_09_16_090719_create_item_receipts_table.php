<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemReceiptsTable extends Migration
{
public function up()
{
Schema::create('item_receipts', function (Blueprint $table) {
$table->bigIncrements('id');
$table->unsignedBigInteger('item_id');
$table->date('date_received')->nullable();
$table->integer('quantity');
$table->decimal('price', 14, 2)->default(0.00);
$table->unsignedBigInteger('received_by');
$table->text('remarks')->nullable();
$table->timestamps();

$table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
$table->foreign('received_by')->references('id')->on('users')->onDelete('cascade');
});
}

public function down()
{
Schema::dropIfExists('item_receipts');
}
}
