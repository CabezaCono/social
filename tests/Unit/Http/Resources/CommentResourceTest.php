<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\UserResource;
use App\Models\Comment;
use App\Models\Status;
use App\User;
use Tests\TestCase;
use App\Http\Resources\CommentResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentResourceTest extends TestCase
{
    use RefreshDatabase;
    /** @test */

    function a_comment_resources_must_have_the_necessary_fields()
    {
        $comment = factory(Comment::class)->create();

        $commentresource = CommentResource::make($comment)->resolve();

        $this->assertEquals($comment->id, $commentresource['id']);
        $this->assertEquals($comment->body, $commentresource['body']);
        $this->assertEquals(0, $commentresource['likes_count']);
        $this->assertEquals(false, $commentresource['is_liked']);
        $this->assertInstanceOf(UserResource::class, $commentresource['user']);
        $this->assertInstanceOf(User::class, $commentresource['user']->resource);
    }
}
