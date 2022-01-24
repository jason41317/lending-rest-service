<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAdjustmentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjustment_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('')->nullable();
            $table->string('description')->default('')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('adjustment_types')->insert([
            [
                'name' => 'In',
                'description' => 'In'
            ],
            [
                'name' => 'Out',
                'description' => 'Out'
            ]
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adjustment_types');
    }
}
