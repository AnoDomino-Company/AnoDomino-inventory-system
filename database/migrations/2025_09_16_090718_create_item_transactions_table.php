<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTransactionsTable extends Migration
{
public function up()
{
Schema::create('item_transactions', function (Blueprint $table) {
$table->bigIncrements('id');
$table->timestamps();
});
}

public function down()
{
Schema::dropIfExists('item_transactions');
}
}
