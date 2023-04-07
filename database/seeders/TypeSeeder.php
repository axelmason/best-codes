<?php

namespace Database\Seeders;

use App\Models\ShopType;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['title' => 'Магазин', 'alias' => 'shop'],
            ['title' => 'Доставка', 'alias' => 'delivery'],
            ['title' => 'Сервис', 'alias' => 'service'],
            ['title' => 'Продукт', 'alias' => 'product'],
            ['title' => 'Еда', 'alias' => 'food'],
        ];

        ShopType::insert($types);
    }
}
