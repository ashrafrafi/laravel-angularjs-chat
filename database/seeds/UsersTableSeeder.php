<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate([
    		'name' 		=> 'Galileo Galilei',
    		'email' 	=> 'galileo_galilei@example.com',
    		'password' 	=> Hash::make('123456')
    	]);

    	User::firstOrCreate([
    		'name' 		=> 'Isaac Newton',
    		'email' 	=> 'isaac_newton@example.com',
    		'password'  => Hash::make('123456')
    	]);

    	User::firstOrCreate([
    		'name' 		=> 'Albert Einstein',
    		'email' 	=> 'albert_einstein@example.com',
    		'password'  => Hash::make('123456')
    	]);

    	User::firstOrCreate([
    		'name' 		=> 'Stephen Hawking',
    		'email' 	=> 'stephen_hawking@example.com',
    		'password'  => Hash::make('123456')
    	]);

    	User::firstOrCreate([
    		'name' 		=> 'Peter Higgs',
    		'email' 	=> 'peter_higgs@example.com',
    		'password'  => Hash::make('123456')
    	]);
    }
}
