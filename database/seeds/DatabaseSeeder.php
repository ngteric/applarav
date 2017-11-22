<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(SpendsTableSeeder::class);
        $this->call(SpendUserTableSeeder::class);
        $this->call(PartsTableSeeder::class);
        $this->call(BalancesTableSeeder::class);
    }
}
