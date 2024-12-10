<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Size::query()->create([
            'slug' => '25 традиционное',
        ]);
        Size::query()->create([
            'slug' => '30 традиционное',
        ]);
        Size::query()->create([
            'slug' => '35 традиционное',
        ]);
        Size::query()->create([
            'slug' => '30 тонкое',
        ]);
        Size::query()->create([
            'slug' => '35 тонкое',
        ]);
        Size::query()->create([
            'slug' => '0,3 л',
        ]);
        Size::query()->create([
            'slug' => '0,5 л',
        ]);
        Size::query()->create([
            'slug' => '1 л',
        ]);
    }
}
