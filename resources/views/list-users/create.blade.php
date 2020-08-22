@extends('layouts.master')

@section('content')

    <input autocomplete="off" id="searchbar" class="searchbar" type="text" placeholder="Search Users">
    <div class="user-cards"></div>

    <script>
        // Using axios

        window.onload = function(){
            /* Searchbar ------- */
            let search = document.querySelector('#searchbar');
            let userCards = document.querySelector('.user-cards');

            let list = {!! json_encode($list->toArray(), JSON_HEX_TAG) !!};
            
            getAllUsers();

            search.addEventListener('keyup', (e) => {
                if(search.value.trim() != ''){
                    filterUsers();
                } else {
                    getAllUsers();
                }
            });

            function getAllUsers(){
                axios.post(`/lists/${list.id}/users/filter`, {empty: true}).then((response) => {
                    userCards.innerHTML = response.data.html;

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
                });
            }

            function filterUsers(){
                axios.post(`/lists/${list.id}/users/filter`, { query: search.value}).then((response) => {
                    userCards.innerHTML = response.data.html;

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