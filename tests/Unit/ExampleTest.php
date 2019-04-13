<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    use DatabaseMigrations;

    public function testBasicTest()
    {
        $this->assertTrue(true);
    }
    public function testDatabase()
    {
        factory(\App\User::class)->create([
            'email'=>'admin@admin.com.br'
        ]);
        $this->assertDatabaseHas('users', [
            'email'=>'admin@admin.com.br'
        ]);
    }
}
