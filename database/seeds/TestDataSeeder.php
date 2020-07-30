<?php

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Employee;

class TestDataSeeder extends Seeder
{
    /**
     * Created a suitable database for testing purposed with pre-arranged numbered datafields
     * for both companys and employees that can be used to make assertions in the tests.
     *
     * This will generate 50 Companies in total (first 20 suitable for programatic testing)
     * + 200 Employees (first 40 suitable for programatic testing)
     * 
     * @return void
     */
    public function run()
    {
        for ($x = 1; $x <= 20; $x++) {
            $c = Company::create([
                'name' => 'Name'.$x,
                'email' => 'company_email'.$x.'@domain'.$x.'.com',
                'website' => 'wwww.website'.$x.'.com',
            ]);
        }
        for ($x = 1; $x <= 40; $x++) {
            Employee::create([
                'first_name' => 'Firstname'.$x,
                'last_name' => 'Lastname'.$x,
                'company_id' => (int) ceil($x/2),
                'email' => 'employee_email'.$x.'@domain'.$x.'.com',
                'phone' => '+44 123456789-'.$x,
                'created_at' => now()
            ]);
        }
        
        factory(Company::class, 30)->create();
        factory(Employee::class, 160)->create();
    }
}
