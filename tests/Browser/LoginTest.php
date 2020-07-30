<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    /**
     * Ensure all browser cookies are detroyed as testing login + run the basic seeder so user can be logged in
     * {@inheritDoc}
     * @see \Laravel\Dusk\TestCase::setUp()
     */
    protected function setUp() : void
    {
        parent::setUp();
        foreach (static::$browsers as $browser) {
            $browser->driver->manage()->deleteAllCookies();
        }
        $this->artisan('db:seed');
    }
    
    /**
     * A testing default lands on home page with login form
     *
     * @return void
     */
    public function testHomePageLandsOnLoginPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertPathIs('/login')
                ->assertSee('Sign in to start your session')
                ->assertGuest();
        });
    }
    
    /**
     * Testing login works
     *
     * @return void
     */
    public function testUserCanLogIn()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
            ->assertPathIs('/login')
            ->type('email','admin@admin.com')
            ->type('password','password')
            ->click('button[type=submit]')
            ->assertPathIs('/home');
        });
    }

    /**
     * Testing incorrect login works
     *
     * @return void
     */
    public function testIncorrectCredentials()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
            ->assertPathIs('/login')
            ->type('email','admin@admin.com')
            ->type('password','incorrect')
            ->click('button[type=submit]')
            ->assertPathIs('/login')
            ->assertSee('These credentials do not match our records.');
        });
    }
    
}
