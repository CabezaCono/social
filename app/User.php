<?php

namespace App;

use App\Models\Friendship;
use App\Models\Status;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    protected $guarded = [];


    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['avatar'];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function link()
    {
        return route('users.show', $this);
    }

    public function avatar()
    {
        return 'https://semantic-ui.com/images/wireframe/image.png';
    }

    public function getAvatarAttribute()
    {
        return $this->avatar();
    }

    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    public function sendFriendRequestTo($recipient)
    {
        return Friendship::firstOrCreate([
            'sender_id' => $this->id,
            'recipient_id' => $recipient->id
        ]);
    }

    public function acceptFriendRequestFrom($sender)
    {
        $friendship = Friendship::where([
            'sender_id' => $sender->id,
            'recipient_id' => $this->id,
        ])->first();
        $friendship->update(['status' => 'accepted']);

        return $friendship;
    }
}
