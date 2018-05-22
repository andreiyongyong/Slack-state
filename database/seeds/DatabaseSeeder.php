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
         $user = factory(App\User::class)->create([
             'username'  => 'admin',
             'email'     => 'ad@gmail.com',
             'password'  => bcrypt('admin'),
             'type'      => '0' ,
             'level'     => '0' , 
             'image'     => ''
         ]);

    }
}
