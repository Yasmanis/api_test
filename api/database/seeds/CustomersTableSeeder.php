<?php

use Illuminate\Database\Seeder;
use App\Customer;
use App\Product;
class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = \Faker\Factory::create();

        // And now, let's create a few articles in our database:
        for ($i = 0; $i < 50; $i++) {
            Customer::create([
                'uuid' => $faker->uuid,
                'firstName' => $faker->firstName,
                'lastName' => $faker->lastName,
                'dateOfBirth' => $faker->date('Y-m-d H:i:s')
            ]);
        }
    }
}
