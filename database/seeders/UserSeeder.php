<?php
 
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
 
class UserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Christian Roy Mabilin',
            'email' => 'admin@gmail.com',
            'contact_number' => '09922583516',
            'capabilities' => '1, 2',
            'password' => Hash::make('password'),
        ]);
    }
}