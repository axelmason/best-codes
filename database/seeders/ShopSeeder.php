<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\ShopType;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [];

        for ($i=0; $i < 50; $i++) {
            $values[] = [
                'name' => fake()->word(),
                'image' => 'default.png',
                'top' => fake()->boolean(),
                'url' => fake()->url(),
                'description' => fake()->text(300),
                'type_id' => ShopType::all()->random()->id
            ];
        }

        Shop::insert($values);
    }
}
