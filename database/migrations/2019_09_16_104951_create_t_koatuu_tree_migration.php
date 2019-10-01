<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTKoatuuTreeMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        \DB::unprepared( file_get_contents( "protest14.sql" ) );
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
        Schema::dropIfExists('t_koatuu_tree');
    }
}
