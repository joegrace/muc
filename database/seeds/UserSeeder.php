<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserSeeder extends Seeder 
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Joe',
            'email' => 'joe@w1sk.com',
            'password' => bcrypt('secret'),
            'disabled' => false
        ]);
    }
    
}