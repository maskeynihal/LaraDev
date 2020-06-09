<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
		DB::table('users')->insert([
			'name' => "Technorio",
			'email' => "technorio@technorio.com",
			'password' => Hash::make('Tec#nori0'),
		]);
        // $this->call(UsersTableSeeder::class);
    }
}
