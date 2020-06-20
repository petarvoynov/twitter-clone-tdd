@extends('layouts.master')

@section('content') 
    <div class="row">
        <div class="col-3">
            <nav>
                <ul class="menu">
                    <li class="menu-item mt-2"><a href="#"><ion-icon class="logo align-middle" name="logo-twitter"></ion-icon></a></li>
                    <li class="menu-item mt-2"><a href="#"><ion-icon class="mr-3 icons align-middle" name="home-sharp"></ion-icon>Home</a></li>
                    <li class="menu-item mt-2"><a href="#"><ion-icon class="mr-3 icons align-middle" name="earth-sharp"></ion-icon>Explore</a></li>
                    <li class="menu-item mt-2"><a href="#"><ion-icon class="mr-3 icons align-middle" name="notifications-outline"></ion-icon>Notifications</a></li>
                    <li class="menu-item mt-2"><a href="#"><ion-icon class="mr-3 icons align-middle" name="mail-outline"></ion-icon>Messages</a></li>
                    <li class="menu-item mt-2"><a href="#"><ion-icon class="mr-3 icons align-middle" name="bookmark-outline"></ion-icon>Bookmarks</a></li>
                    <li class="menu-item mt-2"><a href="#"><ion-icon class="mr-3 icons align-middle" name="document-text-outline"></ion-icon>Lists</a></li>
                    <li class="menu-item mt-2"><a href="#"><ion-icon class="mr-3 icons align-middle" name="person-outline"></ion-icon>Profile</a></li>
                    <li class="menu-item mt-2"><a href="#"><ion-icon class="mr-3 icons align-middle" name="ellipsis-horizontal-circle-outline"></ion-icon>More</a></li>
                    <li class="mt-2"><div class="button text-center mt-4">Tweet</div></li>
                </ul>
            </nav>    
        </div>
        <div class="col-6"></div>
        <div class="col-3">
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

    @foreach ($tweets as $tweet)
        {{ $tweet->body }}
    @endforeach
@endsection


