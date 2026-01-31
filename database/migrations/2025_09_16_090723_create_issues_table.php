<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuesTable extends Migration
{
public function up()
{
Schema::create('issues', function (Blueprint $table) {
$table->bigIncrements('id');
$table->unsignedBigInteger('request_id');
$table->unsignedBigInteger('storekeeper_id');
$table->timestamp('issued_at')->nullable();
$table->timestamps();

$table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade');
$table->foreign('storekeeper_id')->references('id')->on('users')->onDelete('cascade');
});
}

public function down()
{
Schema::dropIfExists('issues');
}
}
