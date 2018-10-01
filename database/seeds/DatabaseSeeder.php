<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);

         //Table Users
        /* DB::table('users')->insert([
             'type'=>'admin',
             'email'=>'admin@npj.co',
             'password'=>bcrypt('1234mudar'),
             'human_id'=>'1'
         ]);


         //table Humans
         DB::table('humans')->insert([
             'status'=>'active',
             'name'=>'Neylanio Soares',
             'user_id'=>'1'
         ]);**/




    }
}
