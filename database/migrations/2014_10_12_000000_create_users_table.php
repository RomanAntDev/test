<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->rememberToken();
            $table->timestamps();
	        $table->char('territory_id');
        });
	    if (Schema::hasColumn('t_koatuu_tree', 'ter_id'))
	    {
		    Schema::table('users', function (Blueprint $table) {
			    $table->foreign('territory_id')
				    ->references('ter_id')
				    ->on('t_koatuu_tree');
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
	    Schema::dropForeign(['territory_id']);
	    Schema::dropIfExists('users');
    }
}
