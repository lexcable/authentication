
<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\withoutMode\events;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // If you want to run your own UserSeeder first:
        $this->call([
            UserSeeder::class,
        ]);
    }
}
