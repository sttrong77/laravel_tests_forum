<?php
namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;
    protected $thread;
    public function setUp()
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }
    /** @test */
    public function a_user_can_view_all_threads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }
    /** @test */
    function a_user_can_read_a_single_thread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }
    /** @test */
    function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $reply = factory('App\Reply')
            ->create(['thread_id' => $this->thread->id]);
        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    /** @test Filtrar posts por categoria*/
    function a_can_filter_threads_according_to_a_channel(){
      $channel = create('App\Channel');
      $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
      $threadNotInChannel = create('App\Thread');

       $this->get('/threads/' . $channel->slug)
           ->assertSee($threadInChannel->title)
           ->assertDontSee($threadNotInChannel->title);
    }

    /** @test Usuário filtrar threads de outros usuarios*/
    function a_user_can_filter_threads_by_any_username(){
      $this->signIn(create('App\User', ['name'=>'Rodrigo']));

      $threadByRodrigo = create('App\Thread', ['user_id' => auth()->id()]);
      $threadNotByRodrigo = create('App\Thread');

      $this->get('threads?by=Rodrigo')
           ->assertSee($threadByRodrigo->title)
           ->assertDontSee($threadNotByRodrigo->title);
    }

    /** @test  */
    function a_user_can_filter_threads_by_popularity(){
      $threadWithTwoReplies = create('App\Thread');
      create('App\Reply', ['thread_id'=>$threadWithTwoReplies->id], 2);

      $threadWithThreeReplies = create('App\Thread');
      create('App\Reply', ['thread_id'=>$threadWithThreeReplies->id], 3);

      $threadWithNoReplies = $this->thread;


      $response = $this->getJson('threads?popular=1')->json();
      // $response->assertSee($threadWithThreeReplies->title);
      $this->assertEquals([3,2,0],array_column($response, 'replies_count'));
    }
}
