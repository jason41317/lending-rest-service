<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issuances', function (Blueprint $table) {
            $table->id();
            $table->string('issuance_no')->default('')->nullable();
            $table->string('location')->default('')->nullable();
            $table->string('issued_to')->default('')->nullable();
            $table->dateTime('datetime')->nullable();
            $table->decimal('total_amount', 19, 5)->default(0)->nullable();
            $table->text('remarks')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issuances');
    }
}
