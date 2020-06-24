<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnSelectionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('column_selections')) {
            Schema::create('column_selections', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('table_name');
                $table->text('columns');
		$table->unsignedInteger('user_id');
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
        Schema::dropIfExists('column_selections');
    }

}
