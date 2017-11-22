<?php

use Illuminate\Database\Seeder;

class PartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::Table('parts')->insert(array(
            [
                'user_id' => 1,
                'day' => 7.00,
                'started' => date("Y-m-d H:i:s")
            ],
            [
                'user_id' => 2,
                'day' => 7.00,
                'started' => date("Y-m-d H:i:s")
            ],
            [
                'user_id' => 3,
                'day' => 2.00,
                'started' => date("Y-m-d H:i:s")
            ],
        ));
    }
}
