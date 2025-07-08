<?php
namespace Database\Seeders;

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

        // $this->call([
        //     AdminSeeder::class,
        // ]);
        // $this->call(KonsumenSeeder::class);
        // Di DatabaseSeeder.php
        $this->call(OrderSeeder::class);
    }
}
