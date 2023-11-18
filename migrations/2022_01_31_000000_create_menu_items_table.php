<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('menu_items')) {
            Schema::create('menu_items', function (Blueprint $table) {
                $table->id();
                $table->integer('menuheader_id');
                $table->string('name');
                $table->string('route');
                $table->text('routeparams')->nullable();
                $table->string('icon')->nullable();
                $table->text('visible_conditions')->nullable();
                $table->text('active_conditions')->nullable();
                $table->integer('parent');
                $table->integer('num_order');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('menu_items');
    }
}
