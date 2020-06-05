<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\User;
use Illuminate\Http\Request;

class FriendshipsController extends Controller
{
    public function store(User $recipient)
    {
        $friendship = Friendship::firstOrCreate([
            'sender_id' => auth()->id(),
            'recipient_id' => $recipient->id
        ]);

        return response()->json(['friendship_status' => $friendship->fresh()->status]);
    }

    public function destroy(User $user)
    {
        $deleted = Friendship::where([
            'sender_id' => auth()->id(),
            'recipient_id' => $user->id
        ])->orWhere([
            'sender_id' => $user->id,
            'recipient_id' => auth()->id()
        ])->delete();

        return response()->json(['friendship_status' => $deleted ? 'deleted' : '']);
    }
}