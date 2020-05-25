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

        $this->assertEquals($comment->body, $commentresource['body']);
    }
}
