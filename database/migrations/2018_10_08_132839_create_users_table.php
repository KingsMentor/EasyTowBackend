<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('first_name', 45)->nullable();
			$table->string('last_name', 45)->nullable();
			$table->string('email')->nullable();
			$table->string('password')->nullable();
			$table->string('remember_token', 60)->nullable();
			$table->string('phone_no', 45)->nullable();
			$table->text('profile_pic', 65535)->nullable();
			$table->integer('type')->nullable()->comment('0= Individual
1= Company
2= Affiliate Manager');
			$table->integer('status')->nullable();
			$table->text('identification', 65535)->nullable();
			$table->text('address', 65535)->nullable();
			$table->timestamps();
			$table->string('account_name', 45)->nullable();
			$table->string('bank_id', 45)->nullable();
			$table->string('account_no', 45)->nullable();
			$table->softDeletes();
			$table->string('social_id', 45)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
