<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorizationsTable extends Migration
{
public function up()
{
Schema::create('authorizations', function (Blueprint $table) {
$table->bigIncrements('id');
$table->unsignedBigInteger('request_id');
$table->unsignedBigInteger('authoriser_id');
$table->enum('status', ['authorized','rejected']);
$table->text('remarks')->nullable();
$table->timestamp('authorized_at')->nullable();
$table->timestamps();

$table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade');
$table->foreign('authoriser_id')->references('id')->on('users')->onDelete('cascade');
});
}

public function down()
{
Schema::dropIfExists('authorizations');
}
}