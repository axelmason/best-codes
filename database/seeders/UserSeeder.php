<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo "\n\tAdmin password is 123\n\n";

        User::create([
            'name' => 'admin',
            'login' => 'admin',
            'email' => 'admin@admin.com',
            'password'  => 123,
            'role_id'   => 3
        ]);
    }
}
