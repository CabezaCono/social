<?php

namespace App\Models;

use App\Traits\HasLikes;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasLikes;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
