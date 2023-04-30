<?php

namespace Database\Seeders;

use App\Models\Code;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Seeder;

class CodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [];
        $types = ['code', 'promo', 'other'];

        for ($i=0; $i < 300; $i++) {
            $values[] = [
                'shop_id' => Shop::all()->random()->id,
                'code' => '#'.fake()->text(10),
                'title' => fake()->text(30),
                'description' => fake()->realText(300),
                'type' => $types[array_rand($types)],
                'user_id' => User::all()->random()->id,
                'views_count' => random_int(0, 5000),
                'usages_count' => random_int(0, 5000),
            ];
        }

        Code::insert($values);
    }
}
