<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $users = ['test1', 'test2', 'test3', 'test4', 'test5'];

        foreach($users as $user) {
            factory('App\User')->create([
                'name' => ucfirst($user),
                'email' => $user.'@abv.bg',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]);
        }

        factory('App\Comment',10)->create();

    }
}
