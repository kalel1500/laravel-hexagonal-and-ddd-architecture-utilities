<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Shared\Infrastructure\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory(9)->create();
    }
}
