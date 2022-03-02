<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'Admin',
                'username' => 'admin@radiusserver.com',
                'email' => 'admin@radiusserver.com',
                'phone' => '08122787177',
                'utype' => '1',
                'status' => '1',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'User',
                'username' => 'giftbalogun',
                'email' => 'usern@radiusserver.com',
                'phone' => '08122787177',
                'utype' => '0',
                'status' => '0',
                'password' => bcrypt('123456'),
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
