<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MentionUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function mentioned_users_in_a_reply_are_notified()
    {
        $this->withoutExceptionHandling();

        $john = create('App\User', ['name' => "JohnDoe"]);

        $this->signIn($john);

        $jane = create('App\User', ['name' => "JaneDoe"]);

        $thread = create('App\Thread');

        $reply = make('App\Reply', [
            'body' => "@JaneDoe look at this."
        ]);

        $this->postJson($thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1, $jane->notifications);
    }

}
