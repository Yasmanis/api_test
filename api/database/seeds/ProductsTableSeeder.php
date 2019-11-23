<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Customer;

class ProductsTableSeeder extends Seeder
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
            Product::create([
                'issn' => $faker->uuid,
                'name' => $faker->name,
                'customer' => Customer::all()->random()->id
            ]);
        }
    }
}
