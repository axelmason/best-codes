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
        $values = [];
        $types = ['shop', 'delivery', 'service', 'product', 'food'];

        foreach ($types as $type) {
            $values[] = [
                'title' => $type
            ];
        }

        ShopType::insert($values);
    }
}
