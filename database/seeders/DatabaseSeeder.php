<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'pepe',
            'last_name' => 'el gato',
            'document_type' => 1,
            'document_number' => '12345678',
            'email' => 'pepe@gmail.com',
            'phone' => '987654321',
            'password' => bcrypt('12345678')
        ]);

        $this->call([
            FamilySeeder::class,
            OptionSeeder::class,
        ]);
        Product::factory(150)->create();
    }
}
