<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGcmIdsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('gcm_ids', function(Blueprint $table)
		{
			$table->foreign('user_id', 'user_id_fk_i')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('gcm_ids', function(Blueprint $table)
		{
			$table->dropForeign('user_id_fk_i');
		});
	}

}
