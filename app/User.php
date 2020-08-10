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
        'name', 'email', 'password', 'profile_picture', 'description', 'location'
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
        return auth()->user()->followings()->where('leader_id', $user->id)->exists();
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
}
