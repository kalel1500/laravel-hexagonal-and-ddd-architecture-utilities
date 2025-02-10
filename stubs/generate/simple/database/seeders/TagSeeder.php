<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Shared\Infrastructure\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::factory(10)->create();
    }
}
