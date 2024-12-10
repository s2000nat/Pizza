<?php

namespace Database\Seeders;

use App\Models\PriceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PriceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PriceCategory::query()->create
        ([
            'slug' => 'Эконом',
        ]);
        PriceCategory::query()->create
        ([
            'slug' => 'Стандартная',
        ]);
        PriceCategory::query()->create
        ([
            'slug' => 'Премиум',
        ]);
        PriceCategory::query()->create
        ([
            'slug' => 'Газировка',
        ]);
        PriceCategory::query()->create
        ([
            'slug' => 'Морс',
        ]);
        PriceCategory::query()->create
        ([
            'slug' => 'Молочный коктейль',
        ]);
        PriceCategory::query()->create
        ([
            'slug' => 'Кофе',
        ]);
        PriceCategory::query()->create
        ([
            'slug' => 'Сок',
        ]);
    }
}
