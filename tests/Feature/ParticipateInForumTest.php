<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{
  use DatabaseMigrations;

  /** @test Usuário autenticado */
  function unauthenticated_users_may_not_add_replies(){

    $this->expectException('Illuminate\Auth\AuthenticationException');

    $thread = factory('App\Thread')->create();

    $reply = factory('App\Reply')->create();

    $this->post($thread->path().'/replies', $reply->toArray());
  }
  /** @test */
  function an_authenticated_user_may_participate_in_forum_threads(){
    //User autorizado
    // $user = factory('App\User')->create();
    $this->be($user = factory('App\User')->create());
    //Existe um post
    $thread = factory('App\Thread')->create();

    $reply = factory('App\Reply')->make();

    $this->post($thread->path().'/replies', $reply->toArray());

    $this->get($thread->path())
        ->assertSee($reply->body);
  }
}