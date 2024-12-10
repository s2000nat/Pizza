<?php

namespace Database\Seeders;

use App\Models\CategorySizePrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySizePriceSeeder extends Seeder
{
    /**
     * Создание CategorySizePrice с price_category 'эконом'.
     */
    private function createEconomyCategorySizePrices(): void
    {
        CategorySizePrice::query()->create
        ([
            'price_category_id' => 1,
            'size_id' => 1,
            'price' => 299,
        ]);
        CategorySizePrice::query()->create
        ([
            'price_category_id' => 1,
            'size_id' => 2,
            'price' => 539,
        ]);
        CategorySizePrice::query()->create
        ([
            'price_category_id' => 1,
            'size_id' => 4,
            'price' => 539,
        ]);
        CategorySizePrice::query()->create
        ([
            'price_category_id' => 1,
            'size_id' => 3,
            'price' => 649,
        ]);
        CategorySizePrice::query()->create
        ([
            'price_category_id' => 1,
            'size_id' => 5,
            'price' => 649,
        ]);
    }

    /**
     * Создание CategorySizePrice с price_category 'эконом'.
     */
    private function createStandardCategoryPrices(): void
    {
        CategorySizePrice::query()->create
        ([
            'price_category_id' => 2,
            'size_id' => 1,
            'price' => 539,
        ]);
        CategorySizePrice::query()->create
        ([
            'price_category_id' => 2,
            'size_id' => 2,
            'price' => 799,
        ]);
        CategorySizePrice::query()->create
        ([
            'price_category_id' => 2,
            'size_id' => 4,
            'price' => 799,
        ]);
        CategorySizePrice::query()->create
        ([
            'price_category_id' => 2,
            'size_id' => 3,
            'price' => 969,
        ]);
        CategorySizePrice::query()->create
        ([
            'price_category_id' => 2,
            'size_id' => 5,
            'price' => 969,
        ]);
    }

    /**
     * Создание CategorySizePrice с price_category 'эконом'.
     */
    private function createPremiumCategoryPrices(): void
    {
        CategorySizePrice::query()->create
        ([
            'price_category_id' => 3,
            'size_id' => 1,
            'price' => 689,
        ]);
        CategorySizePrice::query()->create
        ([
            'price_category_id' => 3,
            'size_id' => 2,
            'price' => 999,
        ]);
        CategorySizePrice::query()->create
        ([
            'price_category_id' => 3,
            'size_id' => 4,
            'price' => 999,
        ]);
        CategorySizePrice::query()->create
        ([
            'price_category_id' => 3,
            'size_id' => 3,
            'price' => 1169,
        ]);
        CategorySizePrice::query()->create
        ([
            'price_category_id' => 3,
            'size_id' => 5,
            'price' => 1169,
        ]);
    }
    /**
     * Создание CategorySizePrice с price_category
     * 'Газировка', 'Морс', 'Молочный коктейль', 'Кофе', 'Сок'.
     */
    private function createSoftDrinksCategoryPrices(): void
    {
        CategorySizePrice::query()->create
        ([
            'price_category_id' => 4,
            'size_id' => 7,
            'price' => 139,
        ]);
        CategorySizePrice::query()->create
        ([
            'price_category_id' => 5,
            'size_id' => 7,
            'price' => 149,
        ]);
        CategorySizePrice::query()->create
        ([
            'price_category_id' => 6,
            'size_id' => 6,
            'price' => 220,
        ]);
        CategorySizePrice::query()->create
        ([
            'price_category_id' => 7,
            'size_id' => 6,
            'price' => 159,
        ]);
        CategorySizePrice::query()->create
        ([
            'price_category_id' => 8,
            'size_id' => 8,
            'price' => 259,
        ]);
    }
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $this->createEconomyCategorySizePrices();
        $this->createStandardCategoryPrices();
        $this->createPremiumCategoryPrices();
        $this->createSoftDrinksCategoryPrices();
    }
}
