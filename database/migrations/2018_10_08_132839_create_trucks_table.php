<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTrucksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trucks', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('company_id')->nullable();
			$table->integer('user_id')->nullable();
			$table->integer('driver_id')->nullable();
			$table->string('manufacturer')->nullable();
			$table->string('model')->nullable();
			$table->string('year', 45)->nullable();
			$table->string('plate_no', 45)->nullable();
			$table->timestamps();
			$table->integer('type_id')->nullable()->index('truck_category_truck_idx');
			$table->string('chasis_no', 45)->nullable();
			$table->string('engine_no', 45)->nullable();
			$table->integer('default')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('trucks');
	}

}
