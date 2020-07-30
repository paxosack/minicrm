<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EmployeeCRUDTest extends DuskTestCase
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
     * Test that the menu click lands on employees viewing exactly 10 employees (1-10) with a pagination bar for the rest 
     * (total 50 employees in seeder = 5 pagination links)
     *
     * @return void
     */
    public function testEmployeeTableLanding()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1) // user seeder ensures id 1 is first admin user
                ->visit('/home')
                ->assertSeeIn('.sidebar','Employees')
                ->clickLink('Employees')
                ->assertPathIs('/employees')
                ->assertSeeIn('.content-wrapper','Employees')
                ->assertSee('Firstname1')
                ->assertSee('Firstname2')
                ->assertSee('Firstname3')
                ->assertSee('Firstname4')
                ->assertSee('Firstname5')
                ->assertSee('Firstname6')
                ->assertSee('Firstname7')
                ->assertSee('Firstname8')
                ->assertSee('Firstname9')
                ->assertSee('Firstname10')
                ->assertDontSee('Firstname11')
                ->assertSeeLink('›')
                ->assertSeeLink('2')
                ->assertSeeLink('3')
                ->assertSeeLink('4')
                ->assertSeeLink('5')
                ->assertDontSeeLink('21'); // Should be 20 (200 total / 10 per page)
        });
    }
    
    /**
     * Testing the pagination by using programatic data from Test Seeder
     * 
     * @return void
     */
    public function testEmployeeTablePagination()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1) // seeders ensures id 1 is first admin user
            ->visit('/employees')
            ->clickLink('2','a.page-link')
            ->assertDontSee('Firstname10')
            ->assertSee('Firstname11')
            ->assertSee('Firstname12')
            ->assertSee('Firstname13')
            ->assertSee('Firstname14')
            ->assertSee('Firstname15')
            ->assertSee('Firstname16')
            ->assertSee('Firstname17')
            ->assertSee('Firstname18')
            ->assertSee('Firstname19')
            ->assertSee('Firstname20')
            ->assertDontSee('Firstname21');
        });
    }
    
    /**
     * Testing clicking on open button takes user to the view of the employee and then back again
     *
     * @return void
     */
    public function testEmployeeRead()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1) // seeders ensures id 1 is first admin user
            ->visit('/employees')
            ->click('a.btn.open')
            ->assertSee('Firstname1')
            ->assertSee('Lastname1')
            ->assertSee('Name1')
            ->assertSee('employee_email1@domain1.com')
            ->assertSee('+44 123456789-1')
            ->assertPathIs('/employees/1')
            ->clickLink('Back')
            ->assertPathIs('/employees');
        });
    }
    
    /**
     * Testing creating a employee without a firstname, lastname or an inproper formated
     * email address fails validation, otherwise creation succeeds
     *
     * @return void
     */
    public function testEmployeeCreate()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1) // seeders ensures id 1 is first admin user
            ->visit('/employees')
            ->clickLink('Add New')
            ->assertSee('First Name')
            ->assertSee('Last Name')
            ->assertSee('Company')
            ->assertSee('Email')
            ->assertSee('Phone')
            // deliberatly fail it with no firstname, lastname, and a bad email
            ->type('first_name', '')
            ->type('last_name', '')
            ->type('email','badlyfgormatedemailaddress@@@test')
            ->type('phone','0123456798')
            ->select('company_id','3')
            ->click('input[type=submit]')
            ->assertSee('The first name field is required')
            ->assertSee('The last name field is required')
            ->assertSee('The email must be a valid email address')
            // now to succeed
            ->type('first_name', 'New Employee Test Firstname')
            ->type('last_name', 'New Employee Test Lastname')
            ->type('email','newemployeetest@test.com')
            ->click('input[type=submit]')
            ->assertSee('Employee saved successfully')
            ->assertPathIs('/employees')
            // now find it on the table
            ->clickLink('21','a.page-link') // 200 +1 new one = 201 = page 21
            ->assertSee('New Employee Test Firstname');
        });
    }
    
    /**
     * Testing editing a employee details updates the fields
     *
     * @return void
     */
    public function testEmployeeEdit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1) // seeders ensures id 1 is first admin user
            ->visit('/employees')
            ->click('a.btn.edit')
            ->assertSee('First Name')
            ->assertSee('Last Name')
            ->assertSee('Company')
            ->assertSee('Email')
            ->assertSee('Phone')
            ->type('first_name', 'New Employee Test Firstname Renamed')
            ->type('last_name', 'New Employee Test Lastname Renamed')
            ->type('email','newemployeetest@renamed.com')
            ->type('phone','987654321(testupdated)')
            ->select('company_id','20')
            ->click('input[type=submit]')
            ->assertSee('Employee updated successfully')
            ->assertPathIs('/employees')
            ->assertSee('New Employee Test Firstname Renamed')
            ->assertSee('New Employee Test Lastname Renamed')
            ->assertSee('newemployeetest@renamed.com')
            ->assertSee('987654321(testupdated)')
            ->assertSee('Name20'); // the name of the updated company
        });
    }
    
    /**
     * Testing deleting a employee removes the employee
     *
     * @return void
     */
    public function testEmployeeDelete()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1) // seeders ensures id 1 is first admin user
            ->visit('/employees')
            ->click('button.btn.trash')
            ->acceptDialog()
            // check employee is deleted
            ->assertSee('Employee deleted successfully')
            ->assertPathIs('/employees')
            ->assertDontSee('employee_email1@domain1.com');
        });
    }
}
