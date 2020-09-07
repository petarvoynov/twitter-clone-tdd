<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Tweet;

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

        $users = ['test1', 'test2', 'test3'];


        // Create custom users and tweets that belongs to them
        foreach($users as $user) {
            $u = factory('App\User')->create([
                'name' => ucfirst($user),
                'email' => $user.'@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]);

            factory('App\Tweet', 5)->create(['user_id' => $u->id]);
        }

        // Create 10 random tweets that belongs to 10 new random users
        factory('App\Tweet', 10)->create();
        
        // Get all users
        $users = User::all();

        // Make them follow each other
        foreach($users as $user) {
            $usersToFollow = User::whereNotIn('id', [$user->id])->get();
            $count = $usersToFollow->count();

            $randomNumber = rand(1, $count);

            $usersToFollow = $usersToFollow->random($randomNumber);

            foreach($usersToFollow as $userToFollow){
                $user->follow($userToFollow);
            }    
        }

        // Comment each other's tweets
        foreach($users as $user){
            $usersToComment = $user->followers;

            $tweets = $user->tweets;

            if(count($usersToComment) > 0 && count($tweets) > 0){
                foreach($usersToComment as $u) {
                    factory('App\Comment')->create([
                        'user_id' => $u->id,
                        'tweet_id' => $tweets->random()->id,
                    ]);
                }
            }
        }


        // Retweet each other's tweets
        foreach($users as $user){
            $usersToRetweet = $user->followers;

            $tweets = $user->tweets;
            if(count($usersToRetweet) > 0 && count($tweets) > 0){
                foreach($tweets as $tweet){
                    factory('App\Retweet')->create([
                        'user_id' => $usersToRetweet->random()->id,
                        'tweet_id' => $tweet->id
                    ]);
                }
            }
        }

        // Like a tweet and comment
        foreach($users as $user){
            $usersToLike = $user->followers;

            $tweetsToLike = $user->tweets;
            $commentsToLike = $user->comments;

            if(count($usersToLike) > 0 && count($tweetsToLike) > 0){
                foreach($usersToLike as $u) {
                    $tweetsToLike->random()->likes()->create([
                        'user_id' => $u->id
                    ]);
                }
            }

            if(count($usersToLike) > 0 && count($commentsToLike) > 0){
                foreach($usersToLike as $u) {
                    $commentsToLike->random()->likes()->create([
                        'user_id' => $u->id
                    ]);
                }
            }
        }
    }
}
