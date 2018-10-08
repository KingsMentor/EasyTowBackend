<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDriversTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('drivers', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('company_id')->nullable()->index('company_id_idx');
			$table->integer('user_id')->nullable()->index('agent_fk_idx');
			$table->string('name', 45)->nullable();
			$table->text('profile_pic', 65535)->nullable();
			$table->text('license', 65535)->nullable();
			$table->string('phone_no', 45)->nullable();
			$table->timestamps();
			$table->string('sms_token', 45)->nullable();
			$table->string('email', 60)->nullable();
			$table->string('password', 60)->nullable();
			$table->float('latitude', 10, 0)->nullable();
			$table->string('api_key', 60)->nullable();
			$table->float('longitude', 10, 0)->nullable();
			$table->integer('online_status')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('drivers');
	}

}
