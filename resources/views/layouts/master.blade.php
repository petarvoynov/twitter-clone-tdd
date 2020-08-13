<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mine.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('javascript')
</head>
<body style="margin-bottom: 200px">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-12">
                <nav>
                    <ul class="menu">
                        <li class="menu-item mt-2"><a href="#"><ion-icon class="logo align-middle" name="logo-twitter"></ion-icon></a></li>
                        <li class="menu-item mt-2"><a href="{{ route('tweets.index') }}"><ion-icon class="mr-3 icons align-middle" name="home-sharp"></ion-icon>Home</a></li>
                        <li class="menu-item mt-2"><a href="#"><ion-icon class="mr-3 icons align-middle" name="earth-sharp"></ion-icon>Explore</a></li>
                        <li class="menu-item mt-2"><a href="{{ route('notifications.index') }}"><ion-icon class="mr-3 icons align-middle" name="notifications-outline"></ion-icon>Notifications</a></li>
                        <li class="menu-item mt-2"><a href="#"><ion-icon class="mr-3 icons align-middle" name="mail-outline"></ion-icon>Messages</a></li>
                        <li class="menu-item mt-2"><a href="#"><ion-icon class="mr-3 icons align-middle" name="bookmark-outline"></ion-icon>Bookmarks</a></li>
                        <li class="menu-item mt-2"><a href="{{ route('twitter-lists.index') }}"><ion-icon class="mr-3 icons align-middle" name="document-text-outline"></ion-icon>Lists</a></li>
                        <li class="menu-item mt-2"><a href="{{ route('users.show', ['user' => auth()->id()]) }}"><ion-icon class="mr-3 icons align-middle" name="person-outline"></ion-icon>Profile</a></li>
                        <li class="menu-item mt-2"><a href="#"><ion-icon class="mr-3 icons align-middle" name="ellipsis-horizontal-circle-outline"></ion-icon>More</a></li>
                        <li class="mt-2"><div class="button text-center mt-4">Tweet</div></li>
                    </ul>
                </nav>    
            </div>
            <div class="col-lg-6 col-sm-12 border border-bottom-0">
                @yield('content')
            </div>
        
            <div class="col-lg-3 col-sm-12">
                <div class="mt-2">
                    <form action="#">
                        <input class="searchbar" type="text" placeholder="Search TwitterClone">
                    </form>
                </div>
                <div class="card bg-light mt-3" style="max-width: 18rem;">
                    <div class="card-header">Threads for you</div>
                    <div class="card-body">
                        <h5 class="card-title">Trending in Bulgaria</h5>
                        <p class="card-text">#forebet</p>
                    </div>
                    <div class="card-footer">
                        <a href="">Show more</a>
                    </div>
                </div>
                <ul class="d-flex flex-wrap mt-3">
                    <li class="mr-2" style="font-size:13px;"><a href="#">Teams</a> </li>
                    <li class="mr-2" style="font-size:13px;"><a href="#">Privacy policy</a></li>
                    <li class="mr-2" style="font-size:13px;"><a href="#">Cookies</a></li>
                    <li class="mr-2" style="font-size:13px;"><a href="#">Ads info</a></li>
                    <li style="font-size:13px;"><a href="#">More</a></li>
                </ul>
                <p></p>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
    @yield('scripts')

</body>
</html>