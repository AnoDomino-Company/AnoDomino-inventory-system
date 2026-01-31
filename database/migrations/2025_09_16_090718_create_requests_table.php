<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
public function up()
{
Schema::create('requests', function (Blueprint $table) {
$table->bigIncrements('id');
$table->unsignedBigInteger('requested_by');
$table->unsignedBigInteger('supervisor_id');
$table->enum('status', ['pending','approved','rejected','authorized','issued'])->default('pending');
$table->text('remarks')->nullable();
$table->timestamps();

$table->foreign('requested_by')->references('id')->on('users')->onDelete('cascade');
$table->foreign('supervisor_id')->references('id')->on('users')->onDelete('cascade');
});
}

public function down()
{
Schema::dropIfExists('requests');
}
}
