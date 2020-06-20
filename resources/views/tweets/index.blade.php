@extends('layouts.master')

@section('content') 
    <div class="row">
        <div class="col-3">
            <nav>
                <ul class="menu-items">
                    <li class="mt-2"><a href="#"><ion-icon class="logo align-middle" name="logo-twitter"></ion-icon></a></li>
                    <li class="mt-2"><a href="#"><ion-icon class="mr-3 icons align-middle" name="home-sharp"></ion-icon>Home</a></li>
                    <li class="mt-2"><a href="#"><ion-icon class="mr-3 icons align-middle" name="earth-sharp"></ion-icon>Explore</a></li>
                    <li class="mt-2"><a href="#"><ion-icon class="mr-3 icons align-middle" name="notifications-outline"></ion-icon>Notifications</a></li>
                    <li class="mt-2"><a href="#"><ion-icon class="mr-3 icons align-middle" name="mail-outline"></ion-icon>Messages</a></li>
                    <li class="mt-2"><a href="#"><ion-icon class="mr-3 icons align-middle" name="bookmark-outline"></ion-icon>Bookmarks</a></li>
                    <li class="mt-2"><a href="#"><ion-icon class="mr-3 icons align-middle" name="document-text-outline"></ion-icon>Lists</a></li>
                    <li class="mt-2"><a href="#"><ion-icon class="mr-3 icons align-middle" name="person-outline"></ion-icon>Profile</a></li>
                    <li class="mt-2"><a href="#"><ion-icon class="mr-3 icons align-middle" name="ellipsis-horizontal-circle-outline"></ion-icon>More</a></li>
                    <li class="mt-2"><div class="button text-center mt-4">Tweet</div></li>
                </ul>
            </nav>    
        </div>
        <div class="col-6"></div>
        <div class="col-3"></div>
    </div>

    @foreach ($tweets as $tweet)
        {{ $tweet->body }}
    @endforeach
@endsection


