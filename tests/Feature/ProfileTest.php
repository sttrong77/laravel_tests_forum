<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfileTest extends TestCase
{
    use DatabaseMigrations;

    /** @thread */
    function a_user_has_a_profile(){
      $user = create('App\User');
      
      $this->get("/profiles/{{$user->name}}")
           ->assertSee($user->name);
    }
}
