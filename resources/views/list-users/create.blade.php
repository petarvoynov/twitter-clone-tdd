@extends('layouts.master')

@section('content')

    <form action="">
        <input type="text" placeholder="Search Users">
    </form>

    @if($followings->count() > 0)
        <div class="row d-flex justify-content-around">
        @foreach ($followings as $following)
            <div class="col-6">
                <div class="card mt-2" style="width: 13rem;">
                    <img class="card-img-top" src="{{ $following->profilePicture() }}" alt="Card image cap">
                    <div class="card-body">
                        <p class="card-text text-center">{{ $following->name }}</p>
                        <div {{ ($list->holds($following->id)) ? 'style=display:none' : ''}}>
                            <form action="{{ route('twitter-list-users.store', ['list' => $list->id, 'user_id' => $following->id]) }}" class="d-flex justify-content-center addUserToList" method="POST">
                                @csrf
                                <button class="btn btn-primary btn-sm">Add to List</button>
                            </form>
                        </div>

                        <div {{ (!$list->holds($following->id)) ? 'style=display:none' : ''}}>
                            <form action="{{ route('twitter-list-users.destroy', ['list' => $list->id, 'user_id' => $following->id]) }}" class="d-flex justify-content-center removeUserFromList" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-primary btn-sm">Remove from List</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            @if($loop->iteration % 2 == 0)
                </div>
                <div class="row">
            @endif
        @endforeach
        </div>
    @endif

    <hr>
    @foreach ($followings as $following)
        {{ $following->name }} <br>
    @endforeach

    <script>
        // Using axios

        window.onload = function(){
            let formToAdd = document.querySelectorAll('.addUserToList');
            let formToRemove = document.querySelectorAll('.removeUserFromList');

            for(let i = 0; i < formToAdd.length; i++){
                formToAdd[i].addEventListener('submit', function(e){
                    e.preventDefault();
                    
                    axios.post(e.target.action).then(function(response){
                        formToAdd[i].parentNode.style.display = 'none';
                        formToRemove[i].parentNode.style.display = 'block';
                    });
                });
            }

            for(let i = 0; i < formToRemove.length; i++){
                formToRemove[i].addEventListener('submit', (e) => {
                    e.preventDefault();

                    axios.delete(e.target.action).then((response) => {
                        formToAdd[i].parentNode.style.display = 'block';
                        formToRemove[i].parentNode.style.display = 'none';
                    });
                });
            }
        };
    </script>

    {{-- <script>
        /* Vanilla js ajax */

        window.onload = function(){
            let formToAdd = document.querySelectorAll('.addUserToList');
            let formToRemove = document.querySelectorAll('.removeUserFromList');

            for(let i = 0; i < formToAdd.length; i++){
                formToAdd[i].addEventListener('submit', function(e){
                    e.preventDefault();

                    let xhttp = new XMLHttpRequest();

                    xhttp.onload = function(){
                        if (this.readyState == 4 && this.status == 200) {
                            formToAdd[i].parentNode.style.display = 'none';
                            formToRemove[i].parentNode.style.display = 'block';
                        }
                    }

                    xhttp.open('POST', e.target.action, true);

                    xhttp.setRequestHeader("X-CSRF-TOKEN", document.head.querySelector("[name=csrf-token]").content );

                    xhttp.send();
                });
            }

            for(let i = 0; i < formToRemove.length; i++){
                formToRemove[i].addEventListener('submit', (e) => {
                    e.preventDefault();

                    let xhttp = new XMLHttpRequest();

                    xhttp.onload = function() {
                        if(this.readyState == 4 && this.status == 200){
                            formToAdd[i].parentNode.style.display = 'block';
                            formToRemove[i].parentNode.style.display = 'none';
                        }
                    }

                    xhttp.open('DELETE', e.target.action, true);

                    xhttp.setRequestHeader("X-CSRF-TOKEN", document.head.querySelector("[name=csrf-token]").content );

                    xhttp.send();
                })
            }

        };
    </script> --}}

    {{-- <script>
        // Jquery Ajax

        window.onload = function() {
            let formToAdd = document.querySelectorAll('.addUserToList');
            let formToRemove = document.querySelectorAll('.removeUserFromList');

            for(let i = 0; i < formToAdd.length; i++){
                formToAdd[i].addEventListener('submit', (e) => {
                    e.preventDefault();

                    $.ajax({
                        type: 'POST',
                        url: e.target.action,
                        success: function(data) {
                           formToAdd[i].parentNode.style.display = 'none';
                           formToRemove[i].parentNode.style.display = 'block';
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                });
            }

            for(let i = 0; i < formToRemove.length; i++){
                formToRemove[i].addEventListener('submit', (e) => {
                    e.preventDefault();

                    $.ajax({
                        type: 'DELETE',
                        url: e.target.action,
                        success(){
                            formToAdd[i].parentNode.style.display = 'block',
                            formToRemove[i].parentNode.style.display = 'none'
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                });
            }
        }
    </script> --}}

    {{-- <script>
        // Using fetch API

        window.onload = function() {

            let followings = {!! json_encode($followings->toArray(), JSON_HEX_TAG) !!};
            let list = {!! json_encode($list->toArray(), JSON_HEX_TAG) !!};

            let formToAdd = document.querySelectorAll('.addUserToList');
            let formToRemove = document.querySelectorAll('.removeUserFromList');

            for(let i = 0; i < formToAdd.length; i++){
                formToAdd[i].addEventListener('submit', (e) => {
                    e.preventDefault();

                    fetch(e.target.action, {
                        method: 'POST',
                        headers: {
                            "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                        }
                    }).then((response) => {
                        formToAdd[i].parentNode.style.display="none";
                        formToRemove[i].parentNode.style.display="block";
                    });
                });
            }

            for(let i = 0; i < formToRemove.length; i++){
                formToRemove[i].addEventListener('submit', (e) => {
                    e.preventDefault();

                    fetch(e.target.action, {
                        method: 'DELETE',
                        headers: {
                            "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                        }
                    }).then((response) => {
                        formToAdd[i].parentNode.style.display="block";
                        formToRemove[i].parentNode.style.display="none";
                    });
                });
            }

        }
    </script> --}}
@endsection