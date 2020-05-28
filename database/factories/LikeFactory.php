<?php

use App\Models\Status;
use App\User;
use Faker\Generator as Faker;

$factory->define(App\Models\Like::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(User::class)->create();
        },
    ];
});
