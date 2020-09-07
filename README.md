## Twitter Clone

### About Twitter Clone
This project is created only for learning purposes and job applications. I've created this project only to improve my backend laravel skills.

#### Used tools
- PHP 7.2.30
- Laravel Framework 6.18.20

#### Build features
1. Registration form (Build in laravel auth)
2. Profile
3. Messages
4. Notifications
5. Bookmarks
6. Lists
7. Tweets, Retweets, Likes, Comments, Follow and Subscribe

#### Installation
1. Clone the project to xampp/htdocs folder
```
    git clone https://github.com/lelemalee/twitter-clone.git
```
2. cd to the project folder
```
    cd twitter-clone
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
    php artisan:migrate
```
9. You can seed the project with data running php artisan db:seed
```
    php artisan db:seed
```