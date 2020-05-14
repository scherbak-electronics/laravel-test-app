<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;
use App\Repositories\UserRepository;

class UserAuthTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * A index action test.
     *
     * @return void
     */
    public function testAuth()
    {
        $users = new UserRepository;
        $adminUser = $users->getAdminUser();
        Auth::login($adminUser);
        $this->assertEquals(1, $adminUser->admin);
    }

    public function testLoggedIn()
    {
        $users = new UserRepository;
        $adminUser = $users->getAdminUser();
        Auth::login($adminUser);
        $this->assertTrue(Auth::check());
    }

    public function testDatabase()
    {
        $this->assertDatabaseHas('users', ['admin' => true]);
    }
}

