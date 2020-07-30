<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CompanyCRUDTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    protected function setUp() : void 
    {
        parent::setUp();
        
        //run the Base User Seeder to add the admin@admin.com user
        $this->artisan('db:seed');
        
        // run the testdata seeder to add more data -> see \TestDataSeeder::class
        // Note, this contains programatically testable data - updating this test seeder may require updaing
        // this test, especially with pagination link testing as the number of records is used during the test
        $this->artisan('db:seed --class=TestDataSeeder');
    }

    protected function tearDown() : void {
        parent::tearDown();
    }
    
    /**
     * Test that the menu click lands on companies viewing exactly 10 companies (1-10) with a pagination bar for the rest 
     * (total 50 companies in seeder = 5 pagination links)
     *
     * @return void
     */
    public function testCompanyTableLanding()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1) // user seeder ensures id 1 is first admin user
                ->visit('/home')
                ->assertSeeIn('.sidebar','Companies')
                ->clickLink('Companies')
                ->assertPathIs('/companies')
                ->assertSeeIn('.content-wrapper','Companies')
                ->assertSee('Name1')
                ->assertSee('Name2')
                ->assertSee('Name3')
                ->assertSee('Name4')
                ->assertSee('Name5')
                ->assertSee('Name6')
                ->assertSee('Name7')
                ->assertSee('Name8')
                ->assertSee('Name9')
                ->assertSee('Name10')
                ->assertDontSee('Name11')
                ->assertSeeLink('›')
                ->assertSeeLink('2')
                ->assertSeeLink('3')
                ->assertSeeLink('4')
                ->assertSeeLink('5')
                ->assertDontSeeIn('.pagination','6');
        });
    }
    
    /**
     * Testing the pagination by using programatic data from Test Seeder
     * 
     * @return void
     */
    public function testCompanyTablePagination()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1) // seeders ensures id 1 is first admin user
            ->visit('/companies')
            ->clickLink('2','a.page-link')
            ->assertDontSee('Name10')
            ->assertSee('Name11')
            ->assertSee('Name12')
            ->assertSee('Name13')
            ->assertSee('Name14')
            ->assertSee('Name15')
            ->assertSee('Name16')
            ->assertSee('Name17')
            ->assertSee('Name18')
            ->assertSee('Name19')
            ->assertSee('Name20')
            ->assertDontSee('Name21');
        });
    }
    
    /**
     * Testing clicking on open button takes user to the view of the company and then back again
     *
     * @return void
     */
    public function testCompanyRead()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1) // seeders ensures id 1 is first admin user
            ->visit('/companies')
            ->click('a.btn.open')
            ->assertSee('Name1')
            ->assertSee('company_email1@domain1.com')
            ->assertSee('wwww.website1.com')
            ->assertPathIs('/companies/1')
            ->clickLink('Back')
            ->assertPathIs('/companies');
        });
    }
    
    /**
     * Testing creating a company with a logo over 100x100 or without a name or an 
     * inproper formated email address fails validation, otherwise creation succeeds
     *
     * @return void
     */
    public function testCompanyCreate()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1) // seeders ensures id 1 is first admin user
            ->visit('/companies')
            ->clickLink('Add New')
            ->assertSee('Name')
            ->assertSee('Email')
            ->assertSee('Website')
            ->assertSee('Logo')
            // deliberatly fail it with no name, a bad email and an 99x99 image
            ->type('name', '')
            ->type('email','badlyfgormatedemailaddress@@@test')
            ->type('website','www.newcompanytext.com')
            ->attach('logo_file', app_path('../tests/Browser/assets/99x99.png'))
            ->click('input[type=submit]')
            ->assertSee('The name field is required')
            ->assertSee('The email must be a valid email address')
            ->assertSee('The logo file has invalid image dimensions')
            // now to succeed
            ->type('name', 'New Company Test')
            ->type('email','newcompanytest@test.com')
            ->type('website','www.newcompanytedt.com')
            ->attach('logo_file', app_path('../tests/Browser/assets/101x101.png'))
            ->click('input[type=submit]')
            ->assertSee('Company saved successfully')
            ->assertPathIs('/companies')
            // now find it on the table
            ->clickLink('6','a.page-link') // 50 +1 new one = 51 = page 6
            ->assertSee('New Company Test');
        });
    }
    
    /**
     * Testing editing a company details updates the fields
     *
     * @return void
     */
    public function testCompanyEdit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1) // seeders ensures id 1 is first admin user
            ->visit('/companies')
            ->click('a.btn.edit')
            ->assertSee('Name')
            ->assertSee('Email')
            ->assertSee('Website')
            ->assertSee('Logo')
            ->type('name', 'New Company Test Renamed')
            ->type('email','newcompanytest@renamed.com')
            ->type('website','www.newcompanyrenamed.com')
            ->click('input[type=submit]')
            ->assertSee('Company updated successfully')
            ->assertPathIs('/companies')
            ->assertSee('New Company Test Renamed')
            ->assertSee('newcompanytest@renamed.com')
            ->assertSee('www.newcompanyrenamed.com');
        });
    }
    
    /**
     * Testing deleting a company removes the company and its employees
     *
     * @return void
     */
    public function testCompanyDelete()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1) // seeders ensures id 1 is first admin user
            ->visit('/companies')
            ->click('button.btn.trash')
            ->acceptDialog()
            // check company is deleted
            ->assertSee('Company deleted successfully')
            ->assertPathIs('/companies')
            ->assertDontSee('company_email1@domain1.com')
            // now check that the first 2 employees have been deleted aswell
            ->clickLink('Employees')
            ->assertDontSee('employee_email1@domain1.com')
            ->assertDontSee('employee_email2@domain2.com');
        });
    }
}
