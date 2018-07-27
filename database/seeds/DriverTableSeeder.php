<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;


class DriverTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Driver::class, 150)->create();
    }
}
