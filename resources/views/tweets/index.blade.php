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
        <div class="col-6 border">
            <div class="card">
                <div class="card-header font-weight-bold lead">
                  Home
                </div>
                <div class="card-body">
                  <h5 class="card-title text-muted">What's happening?</h5>
                  <div>
                    <form action="{{ route('tweets.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control" name="body" cols="15" rows="10"></textarea>
                        </div>
                        <button class="btn btn-primary float-right" type="submit">Tweet</button> 
                      </form>
                  </div>
                </div>
              </div>

            @forelse ($tweets as $tweet)
                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between">
                        <h5>{{ $tweet->user->name }}</h5> <small>{{ $tweet->created_at->diffForHumans() }}</small>
                    </div>  
                    <div class="card-body">
                        <p class="card-text">{{ $tweet->body }}</p>
                        <a href="#" class="btn btn-primary btn-sm">Retweet</a>
                        <button id="{{ $tweet->id }}" class="btn btn-primary btn-sm comment-button">Comment</button>
                        <button class="btn btn-primary btn-sm">Like</button>
                    </div>
                    <div id="comment-area-{{ $tweet->id }}" class="comment-area">
                        <form action="{{ route('comments.store', $tweet->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <textarea class="form-control" name="body" id="" cols="30" rows="10"></textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-sm form-control">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
                <ul class="list-group">
                @foreach($comments = getComments($tweet) as $comment)
                    <li class="list-group-item d-flex justify-content-between"><span>{{ $comment->body }}</span><small class="text-secondary">{{ $comment->created_at->diffForHumans() }}</small></li>
                @endforeach  
                </ul>
            @empty
                <p class="lead text-center mt-5">There are no tweets</p>
            @endforelse
            
           
        </div>
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

    <script>
        let textarea = document.querySelectorAll('.comment-area')
        let commentButton = document.querySelectorAll('.comment-button');
        
        for(let i = 0; i < textarea.length; i++){
            textarea[i].style.display = "none";
        }
        
        for(let i = 0; i < commentButton.length; i++){
            commentButton[i].addEventListener('click', function(e) {
                let id = e.target.id;
                let currentCommentAre = document.querySelector('#comment-area-' + id);
                if(currentCommentAre.style.display === 'none'){
                    currentCommentAre.style.display = 'block';
                } else {
                    currentCommentAre.style.display = 'none';
                }
            });
        }
    </script>
@endsection


