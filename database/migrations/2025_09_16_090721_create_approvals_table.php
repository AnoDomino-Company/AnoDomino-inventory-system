<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalsTable extends Migration
{
public function up()
{
Schema::create('approvals', function (Blueprint $table) {
$table->bigIncrements('id');
$table->unsignedBigInteger('request_id');
$table->unsignedBigInteger('approved_by');
$table->unsignedBigInteger('supervisor_id');
$table->enum('status', ['approved','rejected']);
$table->text('remarks')->nullable();
$table->timestamp('approved_at')->nullable();
$table->timestamps();

$table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade');
$table->foreign('approved_by')->references('id')->on('users')->onDelete('cascade');
$table->foreign('supervisor_id')->references('id')->on('users')->onDelete('cascade');
});
}

public function down()
{
Schema::dropIfExists('approvals');
}
}
