<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefaultColumnsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('default_columns')) {
            Schema::create('default_columns', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('table_name')->unique();
                $table->text('default_hidden_columns')->nullable()->default('');
                $table->string('prefix')->nullable()->default('');
                $table->enum('append_additional', ['0', '1'])->default('1');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('default_columns');
    }

}
