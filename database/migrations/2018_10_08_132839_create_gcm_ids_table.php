<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGcmIdsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gcm_ids', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->text('gcm_id', 65535)->nullable();
			$table->integer('user_id')->nullable()->index('user_id_fk_i_idx');
			$table->integer('driver_id')->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('gcm_ids');
	}

}
