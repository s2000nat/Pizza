<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Создать Пиццы.
     */
    private function createPizzas(): void
    {
        MenuItem::query()->create
        ([
            'name' => 'Сырная',
            'description' => 'Моцарелла, сыры чеддер и пармезан, фирменный соус альфредо',
            'price_category_id' => 1,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Пепперони фреш',
            'description' => 'Пикантная пепперони , увеличенная порция моцареллы, томаты , фирменный томатный соус',
            'price_category_id' => 1,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Чоризо фреш',
            'description' => 'Острые колбаски чоризо , сладкий перец , моцарелла, фирменный томатный соус',
            'price_category_id' => 1,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Ветчина и сыр',
            'description' => 'Ветчина , моцарелла, фирменный соус альфредо',
            'price_category_id' => 1,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Песто',
            'description' => 'Цыпленок , соус песто, кубики брынзы , томаты , моцарелла, фирменный соус альфредо',
            'price_category_id' => 2,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Карбонара',
            'description' => 'Бекон , сыры чеддер и пармезан , моцарелла, томаты , красный лук , чеснок , фирменный соус альфредо, итальянские травы ',
            'price_category_id' => 2,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Пепперони',
            'description' => 'Пикантная пепперони , увеличенная порция моцареллы, фирменный томатный соус',
            'price_category_id' => 2,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Цыпленок барбекю',
            'description' => 'Цыпленок , бекон , соус барбекю, красный лук , моцарелла, фирменный томатный соус',
            'price_category_id' => 2,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Додо',
            'description' => 'Бекон , митболы , пикантная пепперони , моцарелла, томаты , шампиньоны , сладкий перец , красный лук , чеснок , фирменный томатный соус',
            'price_category_id' => 3,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Диабло',
            'description' => 'Острые колбаски чоризо , острый перец халапеньо , соус барбекю, митболы из говядины , томаты , сладкий перец , красный лук , моцарелла, фирменный томатный соус',
            'price_category_id' => 3,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Цыпленок ранч',
            'description' => 'Цыпленок , ветчина , соус ранч, моцарелла, томаты , чеснок ',
            'price_category_id' => 3,
        ]);


    }

    /**
     * Run the database seeds.
     */
    private function createSoftDrinks(): void
    {
        MenuItem::query()->create
        ([
            'name' => 'Добрый Кола Малина',
            'price_category_id' => 4,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Добрый Кола Ваниль',
            'price_category_id' => 4,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Добрый Кола',
            'price_category_id' => 4,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Добрый Кола без сахара',
            'price_category_id' => 4,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Морс Клюква',
            'price_category_id' => 5,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Морс Черная смородина',
            'price_category_id' => 5,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Морс Вишня',
            'price_category_id' => 5,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Молочный коктейль с печеньем Орео',
            'price_category_id' => 6,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Классический молочный коктейль',
            'price_category_id' => 6,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Шоколадный молочный коктейль',
            'price_category_id' => 6,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Кофе Кокосовый латте',
            'price_category_id' => 7,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Кофе Ореховый латте',
            'price_category_id' => 7,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Кофе Капучино',
            'price_category_id' => 7,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Кофе Карамельный капучино',
            'price_category_id' => 7,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Апельсиновый сок Rich',
            'price_category_id' => 8,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Яблочный сок Rich',
            'price_category_id' => 8,
        ]);
        MenuItem::query()->create
        ([
            'name' => 'Вишневый нектар Rich',
            'price_category_id' => 8,
        ]);


    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createPizzas();
        $this->createSoftDrinks();
    }
}
