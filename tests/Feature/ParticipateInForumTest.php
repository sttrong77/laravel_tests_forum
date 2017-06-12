<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{
  use DatabaseMigrations;

  /** @test Usuário autenticado */
  function unauthenticated_users_may_not_add_replies(){

    // $this->expectException('Illuminate\Auth\AuthenticationException');

    $this->withExceptionHandling()
              ->post('/threads/some-channel/1/replies', [])
              ->assertRedirect('/login');
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

  /** @test */
  function a_reply_requires_a_body(){
    $this->withExceptionHandling()->signIn();
    $thread = create('App\Thread');

    $reply = make('App\Reply',['body'=>null]);
    $this->post($thread->path().'/replies', $reply->toArray())
         ->assertSessionHasErrors('body');


  }
}
