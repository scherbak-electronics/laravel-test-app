<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;

class ControllersTest extends TestCase
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
    public function testIndex()
    {
        $response = $this->get('/users');
        $response->assertStatus(200);
    }

    public function testAllUsers()
    {
        $response = $this->get('/users/show');
        $response->assertStatus(200);
    }

    public function testAdminUser()
    {
        $response = $this->json('GET', '/users/admin');
        $response->assertStatus(200)->assertJsonStructure($this->userJsonStructureDataProvider());
    }

    public function testDatabase()
    {
        $this->assertDatabaseHas('users', ['admin' => false]);
    }

    public function testAdminPermissions()
    {
        $response = $this->json('GET', '/users/login/1');
        $response->assertJsonStructure($this->userJsonStructureDataProvider());
        $response = $this->json('GET', '/users/getCurrent');
        $userData = $response->getData();
        $this->assertEquals(1, $userData->id);
        $response = $this->json('GET', '/users/add');
        $response->assertJsonStructure($this->userJsonStructureDataProvider());
    }

    public function testNonAdminPermissions()
    {
        $response = $this->json('GET', '/users/login/3');
        $response->assertJsonStructure($this->userJsonStructureDataProvider());
        $response = $this->json('GET', '/users/getCurrent');
        $userData = $response->getData();
        $this->assertEquals(3, $userData->id);
        $response = $this->json('GET', '/users/add');
        $response->assertSeeText('Only admins can create users.');
    }

    public function userJsonStructureDataProvider()
    {
        return [
            
                "id",
                "name",
                "email",
                "email_verified_at",
                "created_at",
                "updated_at"
        ];
    }
}
