<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\User;
use Illuminate\Http\Request;

class RequestFriendshipsController extends Controller
{
    public function store(User $sender)
    {
        Friendship::where([
            'sender_id' => $sender->id,
            'recipient_id' => auth()->id(),
            'accepted' => false
        ])->update(['accepted' => true]);
    }
}
