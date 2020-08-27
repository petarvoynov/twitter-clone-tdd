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
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @yield('javascript')
</head>
<body style="margin-bottom: 200px">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-12">
                <nav>
                    <ul class="menu">
                        <li class="mt-2 menu-item logo">
                            <a href="#">
                                <svg style="width: 48px;" id="Logo_FIXED" data-name="Logo — FIXED" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400"><defs><style>.cls-1{fill:none;}.cls-2{fill:#1da1f2;}</style></defs><title>Twitter_Logo_Blue</title><rect class="cls-1" width="400" height="400"/><path class="cls-2" d="M153.62,301.59c94.34,0,145.94-78.16,145.94-145.94,0-2.22,0-4.43-.15-6.63A104.36,104.36,0,0,0,325,122.47a102.38,102.38,0,0,1-29.46,8.07,51.47,51.47,0,0,0,22.55-28.37,102.79,102.79,0,0,1-32.57,12.45,51.34,51.34,0,0,0-87.41,46.78A145.62,145.62,0,0,1,92.4,107.81a51.33,51.33,0,0,0,15.88,68.47A50.91,50.91,0,0,1,85,169.86c0,.21,0,.43,0,.65a51.31,51.31,0,0,0,41.15,50.28,51.21,51.21,0,0,1-23.16.88,51.35,51.35,0,0,0,47.92,35.62,102.92,102.92,0,0,1-63.7,22A104.41,104.41,0,0,1,75,278.55a145.21,145.21,0,0,0,78.62,23"/></svg>
                            </a>
                        </li>
                        <li class="menu-item mt-2">
                            <a href="{{ route('tweets.index') }}">
                                <svg style="width: 28px; margin-right: 16px;" viewBox="0 0 20 20" fill="currentColor" class="home w-6 h-6"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>Home
                            </a>
                        </li>
                        <li class="menu-item mt-2">
                            <a href="#">
                                <svg style="width: 28px; margin-right: 16px;" viewBox="0 0 20 20" fill="currentColor" class="hashtag w-6 h-6"><path fill-rule="evenodd" d="M9.243 3.03a1 1 0 01.727 1.213L9.53 6h2.94l.56-2.243a1 1 0 111.94.486L14.53 6H17a1 1 0 110 2h-2.97l-1 4H15a1 1 0 110 2h-2.47l-.56 2.242a1 1 0 11-1.94-.485L10.47 14H7.53l-.56 2.242a1 1 0 11-1.94-.485L5.47 14H3a1 1 0 110-2h2.97l1-4H5a1 1 0 110-2h2.47l.56-2.243a1 1 0 011.213-.727zM9.03 8l-1 4h2.938l1-4H9.031z" clip-rule="evenodd"></path></svg>Explore
                            </a>
                        </li>
                        <li class="menu-item mt-2">
                            <a href="{{ route('notifications.index') }}">
                                <svg style="width: 28px; margin-right: 16px;" viewBox="0 0 20 20" fill="currentColor" class="bell w-6 h-6"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>Notifications
                            </a>
                        </li>
                        <li class="menu-item mt-2">
                            <a href="#">
                                <svg style="width: 28px; margin-right: 16px;" viewBox="0 0 20 20" fill="currentColor" class="mail w-6 h-6"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>Messages
                            </a>
                        </li>
                        <li class="menu-item mt-2">
                            <a href="{{ route('bookmarks.index') }}">
                                <svg style="width: 28px; margin-right: 16px;" viewBox="0 0 20 20" fill="currentColor" class="bookmark w-6 h-6"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path></svg>Bookmarks
                            </a>
                        </li>
                        <li class="menu-item mt-2">
                            <a href="{{ route('twitter-lists.index') }}">
                                <svg style="width: 28px; margin-right: 16px;" viewBox="0 0 20 20" fill="currentColor" class="clipboard-list w-6 h-6"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>Lists
                            </a>
                        </li>
                        <li class="menu-item mt-2">
                            <a href="{{ route('users.show', ['user' => auth()->id()]) }}">
                                <svg style="width: 28px; margin-right: 16px;" viewBox="0 0 20 20" fill="currentColor" class="user w-6 h-6"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>Profile
                            </a>
                        </li>
                        <li class="menu-item mt-2">
                            <a href="#">
                                <svg style="width: 28px; margin-right: 16px;" viewBox="0 0 20 20" fill="currentColor" class="dots-circle-horizontal w-6 h-6"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path></svg>More
                            </a>
                        </li>
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