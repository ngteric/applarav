<?php

use Illuminate\Database\Seeder;

class SpendsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Spend::class,6)->create()->each(function($spend){

            $users = App\User::pluck('id')->all();

            $randomKeys = array_rand( $users, rand(1, count($users)) );
            $selectUsers = [];
            
            if(is_array($randomKeys)){
                for ($i=0; $i < count($randomKeys); $i++) { 
                    array_push($selectUsers, $users[ $randomKeys[$i] ]);
                }
            }
            else{
                $selectUsers[] = $users[$randomKeys]; 
            }
            $price = $spend->price / count($selectUsers);
            
            $spend->users()->attach($selectUsers, ['price' => $price]);

        });
    }
}
