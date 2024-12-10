<?php

namespace App\Rules;

use App\Models\CategorySizePrice;
use App\Models\MenuItem;
use App\Models\PriceCategory;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PriceCategoryMatch implements ValidationRule
{

    protected int $menuItemId;
    protected int $categorySizePriceId;

    public function __construct(string $menuItemId, string $categorySizePriceId)
    {
        $this->menuItemId = (int)$menuItemId;
        $this->categorySizePriceId = (int)$categorySizePriceId;
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $menuItem = MenuItem::query()->find($this->menuItemId);
        $categorySizePrice = CategorySizePrice::query()->find($this->categorySizePriceId);


        if ($categorySizePrice->priceCategory->id !== $menuItem->priceCategory->id )
        {
            $fail('Поле price_category_id_FK таблицы  Category_size_prices должно быть идентично полю price_category_id_FK таблицы menu_items.');
        }

    }
}
