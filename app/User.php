<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TweetCreated;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'profile_picture', 'description', 'location', 'message_settings'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tweets()
    {
        return $this->hasMany(Tweet::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'leader_id', 'follower_id')->withTimestamps();
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'leader_id')->withTimestamps();
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function follow($user)
    {    
        $this->followings()->attach($user->id);
    }

    public function unfollow($user)
    {
        return $this->followings()->detach($user->id);
    }

    public function retweets()
    {
        return $this->hasMany('App\Retweet');
    }

    public function activities()
    {
        return $this->hasMany('App\Activity');
    }

    public function profilePicture()
    {
        if($this->profile_picture !== 'noimage.jpg'){
            return  "/storage/{$this->profile_picture}";
        } else {
            return "/default-image/noimage.jpg";
        }
        
    }

    public function getFollowersCountAttribute()
    {
        return $this->followers->count();
    }

    public function getFollowingsCountAttribute()
    {
        return $this->followings->count();
    }

    public function isFollowing($user)
    {
        return !! $this->followings->where('id', $user->id)->count();
    }

    public function getCreatedTweetsCountAttribute()
    {
        return $this->activities->where('description', 'created a tweet')->count();
    }

    public function subscriptions()
    {
        return $this->hasMany('App\Subscription');
    }

    public function subscribe($user)
    {
        $this->subscriptions()->create([
            'subscribed_to' => $user->id
        ]);
    }

    public function isSubscribedTo($user)
    {
        return $this->subscriptions()->where('subscribed_to', $user->id)->exists();
    }

    public function unsubscribe($user)
    {
        $this->subscriptions()->where('subscribed_to', $user->id)->delete();
    }

    public function subscribers()
    {
        return $this->hasMany('App\Subscription', 'subscribed_to');
    }

    public function notifySubscribers($tweet)
    {
        $subscribersIDs = $this->subscribers->pluck('user_id');

        $subscribers = User::whereIn('id', $subscribersIDs)->get();

        Notification::send($subscribers, new TweetCreated($tweet));
    }

    public function lists()
    {
        return $this->hasMany('App\TwitterList');
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function getPinnedListsCountAttribute()
    {
        return \App\TwitterList::where('user_id', $this->id)->where('is_pinned', 1)->get()->count();
    }

    public function sendMessages()
    {
        return $this->hasMany('App\Message', 'from');
    }

    public function receivedMessages()
    {
        return $this->hasMany('App\Message', 'to');
    }

    public function lastMessage($user)
    {
        // Getting the messages that we send to the given user
        $fromMe = $this->sendMessages->where('to', $user->id);

        // Getting the messages that were send to us by the given user
        $fromHim =  $this->receivedMessages->where('from', $user->id);

        // Merge the collections
        $messages = $fromMe->merge($fromHim);

        // Sort then and take the last message in the chat
        $message = $messages->sortByDesc('created_at')->first();

        return $message;
    }

    public function getUnreadMessagesCount()
    {
        // Getting all the users that send us messages
        $usersThatIreceiveMessagesFrom = $this->receivedMessages->map(function($message){
            return $message->sender;
        })->unique();

        $usersThatIreceiveMessagesFrom->load('sendMessages');

        // Get all the messages that are not read
        $messages = $usersThatIreceiveMessagesFrom->filter(function($user){
            return is_null($user->sendMessages->where('to', $this->id)->last()->read_at);
        });

        // Return the count of unread messages
        if($messages->count() > 99){
            return '99+';
        } else {
            return $messages->count();
        }
 
    }

    public function getUnreadNotificationsCount()
    {
        if($this->unreadNotifications()->count() > 99){
            return '99+';
        }
        
        return $this->unreadNotifications()->count();
    }
}
