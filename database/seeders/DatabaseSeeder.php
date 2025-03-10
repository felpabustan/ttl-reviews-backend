<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'BISG Admin',
            'email' => 'hello@beautyinsider.sg',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        DB::table('api_tokens')->insert([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'name' => 'Default Token',
            'token' => hash('sha256', '88afd320556f42670a716b160f0435d9'),
            'last_used_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
