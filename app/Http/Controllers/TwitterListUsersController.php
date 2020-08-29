<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TwitterList;
use App\ListUser;
use App\User;

class TwitterListUsersController extends Controller
{
    public function create(TwitterList $list)
    {
        $followings = auth()->user()->followings;

        return view('list-users.create', compact('list', 'followings'));
    }

    public function store(TwitterList $list, User $user)
    {
        if(auth()->id() != $list->user_id || $list->listUsers->contains('user_id', $user->id)){
            abort(403);
        }


        ListUser::create([
            'user_id' => $user->id,
            'list_id' => $list->id
        ]);

        return response()->json([
            'success' => 'User ' . $user->name . ' has been added to the list'
        ]);
    }

    public function destroy(TwitterList $list, User $user)
    {
        if(auth()->id() != $list->user_id){
            abort(403);
        }
        
        $list->listUsers()->where('user_id', $user->id)->delete();

        return response()->json([
            'success' => 'User ' . $user->name . ' has been removed from the list'
        ]);
    }

    public function filterNames(TwitterList $list)
    {
        if(request()->wantsJson()){

            if(request()->has('empty')){
                $users = auth()->user()->followings;
            } else {
                $users = auth()->user()->followings()->where('name', 'like', '%' . request('query') . '%')->get();
            }

            $html = "<div class='row d-flex justify-content-around'>";

            $count = 0;
            if(count($users) > 0){
                foreach($users as $user){
                    $count++;
                    $displayAdd = 'block';
                    $displayRemove = 'block';
    
                    if($list->holds($user->id)){
                        $displayAdd = 'none';
                        $displayRemove = 'block';
                    } else {
                        $displayAdd = 'block';
                        $displayRemove = 'none';
                    }
                    
    
                    $html .= '<div class="col-6">
                                <div class="card mt-2" style="width: 13rem;">
                                    <img class="card-img-top" src="'. $user->profilePicture() . '" alt="Card image cap">
                                    <div class="card-body">
                                        <p class="card-text text-center">'. $user->name .'</p>
                                        <div style="display:'. $displayAdd .'">
                                            <form action="/lists/'. $list->id .'/users/'. $user->id .'" class="d-flex justify-content-center addUserToList" method="POST">
                                                <button class="btn btn-primary btn-sm">Add to List</button>
                                            </form>
                                        </div>
                                
                                        <div style="display:'. $displayRemove .'">
                                            <form  action="/lists/'. $list->id .'/users/'. $user->id .'" class="d-flex justify-content-center removeUserFromList" method="POST">
                                                <button class="btn btn-primary btn-sm">Remove from List</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                            
                    if($count % 2 == 0) {
                        $html .= ' 
                        </div>
                        <div class="row">
                        ';
                    } 
                }
            } else {
                $html .= '<p>There are no users with name: '. request('query') .'</p>';
            }
            
            $html .= '</div>';

            return response()->json([
                'html' => $html
            ]);
        }
    }
}
