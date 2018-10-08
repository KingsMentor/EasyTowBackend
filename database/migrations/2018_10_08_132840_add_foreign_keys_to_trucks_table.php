<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTrucksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('trucks', function(Blueprint $table)
		{
			$table->foreign('type_id', 'truck_category_truck')->references('id')->on('truck_category_types')->onUpdate('CASCADE')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('trucks', function(Blueprint $table)
		{
			$table->dropForeign('truck_category_truck');
		});
	}

}
