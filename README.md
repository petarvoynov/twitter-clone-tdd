## Twitter Clone TDD

### About Twitter Clone
This project is created only for learning purposes and job applications. I've created this project only to improve my backend laravel skills.
During this project I wrote 124 test with 180 assertions.

#### Used tools
- PHP 7.2.30
- Laravel Framework 6.18.20
- Bootstrap 4
- svgs from https://heroicons.dev/

#### Build features
1. Registration form (Build in laravel auth)
2. Profile
3. Messages
4. Notifications
5. Bookmarks
6. Lists
7. Tweets
8. Retweets
9. Likes
10. Comments
11. Follow
12. Subscribe

#### Installation
1. Clone the project to xampp/htdocs folder
```
    git clone https://github.com/lelemalee/twitter-clone-tdd.git
```
2. cd to the project folder
```
    cd twitter-clone-tdd
```
3. Run composer install
```
    composer install
```
4. Copy the .env.example file and name it .env
```
    copy .env.example .env
```
5. Generate the app key
```
    php artisan key:generate
```
6. Create a database
7. Open .env file and fill your database information
8. Run php artisan migrate
```
    php artisan migrate
```
9. You can seed the project with data running php artisan db:seed
```
    php artisan db:seed
```

This will give you 13 users with random amount of tweet, retweets, comments, likes and follows.
All users password will be "password".
The first 3 users will be:
```
    username: test1 | email: test1@example.com | password: password
    username: test2 | email: test2@example.com | password: password
    username: test3 | email: test3@example.com | password: password  
```