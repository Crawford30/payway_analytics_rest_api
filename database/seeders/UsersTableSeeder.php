<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Truncate the User table first
        User::truncate();


        $faker = \Faker\Factory::create();

        // Making everyone has the same password (For development) and
        // hash it before the loop to make the seeder faster
        $password = Hash::make('payway');

        //Make an admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@payway.com',
            'password' => $password,
        ]);


        //Geneate Fake users
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => $password,
            ]);
        }




    }
}
