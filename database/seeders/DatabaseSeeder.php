<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // insert  10 categories to the database (seeding)
        Category::factory(10)->create();
        // insert  10 products to the database (seeding)
        Product::factory(10)->create();
        // seeding 10 users in database
        User::factory(10)->create();


        // to seed the super admin in database
        User::factory()->create([
             'name' => 'abd',
             'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
            'type'=> 1 ,
        ]);
    }
}
