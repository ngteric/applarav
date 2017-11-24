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
            
            $prices = array();
            $priceMax = 10;
            
            // TODO
            // for ($i=0; $i < count($selectUsers) ; $i++) { 
            //         if($i == 0){
            //             $prices[$i] = rand( $priceMax , $spend->price - ($priceMax * count($selectUsers)) );
            //         }
            //         else{
            //             // if i < nbuser
            //             if($i < count($selectUsers)){
            //                 if( (($spend->price - $priceMax * count($selectUsers)) - array_sum($prices)) > $priceMax ){
            //                     $prices[$i] = rand( $priceMax , (($spend->price - ($priceMax * (count($selectUsers) - $i)) ) - array_sum($prices) ) );
            //                 }
                            
            //                 while( (($spend->price - $priceMax * count($selectUsers)) - array_sum($prices)) < $priceMax ){
            //                     $prices[$i] = rand( $priceMax , (($spend->price - ($priceMax * (count($selectUsers) - $i)) ) - array_sum($prices) ) );
            //                 }
                            

            //             }
            //             // if last iteration
            //             else{
            //                 $prices[$i] =  $spend->price - array_sum($prices);
            //             }
            //         }
                    
                
            //     $spend->users()->attach($selectUsers[$i],['price' =>$prices[$i]]);
            // }
            
            $price = $spend->price / count($selectUsers);
            $spend->users()->attach($selectUsers,['price' =>$price ]);

        });
    }
}
