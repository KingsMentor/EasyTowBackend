<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTripsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trips', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('driver_id')->nullable();
			$table->integer('user_id')->nullable();
			$table->string('to_gps_lat', 45)->nullable();
			$table->string('to_gps_lng', 45)->nullable();
			$table->integer('status')->nullable();
			$table->integer('payment_type')->nullable();
			$table->string('from_gps_lat', 25)->nullable();
			$table->string('from_gps_lng', 25)->nullable();
			$table->string('truck_type', 12)->nullable();
			$table->string('tow_type', 5)->nullable();
			$table->timestamps();
			$table->integer('amount')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('trips');
	}

}
