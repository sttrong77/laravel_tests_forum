<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
  use DatabaseMigrations;

  /** @test Testa a criação de threads se o usuário tiver logado */
  function guests_may_not_create_threads(){

    $this->withExceptionHandling();

    $this->get('/threads/create')
         ->assertRedirect('/login');

    $this->post('/threads')
         ->assertRedirect('/login');
  }

  /** @test Testa a criação de threads */
  function an_authenticated_user_can_create_new_forum_threads(){

    $this->signIn();//está logado?

    $thread = make('App\Thread');


    $response = $this->post('/threads',$thread->toArray());

    $this->get($response->headers->get('Location'))
         ->assertSee($thread->title)
         ->assertSee($thread->body);
  }

  /** @test titulo obrigatorio*/
  function a_thread_requires_a_title(){

    $this->publishThread(['title'=>null])
         ->assertSessionHasErrors('title');

  }

  /** @test texto obrigatorio*/
  function a_thread_requires_a_body(){

    $this->publishThread(['body'=>null])
         ->assertSessionHasErrors('body');

  }

  /** @test canal válido*/
  function a_thread_requires_a_channel_valide(){

    $this->publishThread(['channel_id'=>null])
         ->assertSessionHasErrors('channel_id');

  }

  public function publishThread($overrides =  []){
     $this->withExceptionHandling()->signIn();//está logado?
    //
    $thread = make('App\Thread', $overrides);


    return $this->post('/threads',$thread->toArray());
  }
}
