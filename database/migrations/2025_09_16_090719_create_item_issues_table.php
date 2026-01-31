<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemIssuesTable extends Migration
{
public function up()
{
Schema::create('item_issues', function (Blueprint $table) {
$table->bigIncrements('id');
$table->unsignedBigInteger('item_id');
$table->date('date_issued');
$table->unsignedBigInteger('request_id')->nullable();
$table->unsignedBigInteger('issued_by');
$table->integer('quantity');
$table->timestamps();
$table->unsignedBigInteger('issued_to')->nullable();

$table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
$table->foreign('request_id')->references('id')->on('requests')->onDelete('set null');
$table->foreign('issued_by')->references('id')->on('users')->onDelete('cascade');
// note: `issued_to` was not constrained in original dump; left as plain unsignedBigInteger
});
}

public function down()
{
Schema::dropIfExists('item_issues');
}
}