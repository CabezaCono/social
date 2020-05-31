<?php

namespace Tests\Unit\Http\Resources;

use App\Models\Comment;
use App\Models\Status;
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
        $this->assertEquals($comment->user->name, $commentresource['user_name']);
        $this->assertEquals('https://semantic-ui.com/images/wireframe/image.png', $commentresource['user_avatar']);
        $this->assertEquals(0, $commentresource['likes_count']);
        $this->assertEquals(false, $commentresource['is_liked']);
    }
}
