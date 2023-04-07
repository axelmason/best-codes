<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\ShopType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
        $shopImages = array_diff(scandir(__DIR__ . '/images/codes'), array('..', '.'));

        foreach ($shopImages as $image) {
            $name = fake()->word();
            $values[] = [
                'name' => $name,
                'alias' => Str::slug($name),
                'image' => $image,
                'top' => fake()->boolean(),
                'url' => fake()->url(),
                'description' => fake()->text(300),
                'type_id' => ShopType::all()->random()->id
            ];
        }

        Shop::insert($values);
    }
}
