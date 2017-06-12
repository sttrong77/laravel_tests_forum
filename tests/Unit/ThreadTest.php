<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
{
  use DatabaseMigrations;

  protected $thread;
    /**
     * A basic test example.
     *
     * @return void
     */

     public function setUp(){
       parent::setUp();
       $this->thread = factory('App\Thread')->create();
     }

     /** @test Comentários do post */
    function a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies); //retorna comentários de um post
    }

     /** @test Criador de um post*/
    function a_thread_has_a_creator(){
        $this->assertInstanceOf('App\User',$this->thread->creator); //verifica o criador de um post.
    }

    /** @test Pode add comentário num post*/
    public function a_thread_can_add_a_reply(){
      $this->thread->addReply([
        'body'=>'Foobar',
        'user_id'=>1
      ]);

      $this->assertCount(1,$this->thread->replies);//se encontrar pelo menos um postador
    }

}
