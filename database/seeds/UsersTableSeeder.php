<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $users = factory(App\User::class, 3)->create();


        DB::Table('users')->insert(array(
            [
                'name' => 'Eric',
                'email' => 'nongeric@gmail.com',
                'password'=> Hash::make('root'),
                'role'=> 'admin',
            ],

        ));
    }
}
