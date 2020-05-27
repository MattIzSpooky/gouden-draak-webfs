<?php

use App\UserRole;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserRole::insert([
            [
                'id' => UserRole::ADMIN,
                'name' => 'admin',
                'dutch_name' => 'Administrator'
            ],
            [
                'id' => UserRole::CUSTOMER,
                'name' => 'customer',
                'dutch_name' => 'klant'
            ],
            [
                'id' => UserRole::WAITRESS,
                'name' => 'waitress',
                'dutch_name' => 'Serveerster'
            ],
            [
                'id' => UserRole::KASSA,
                'name' => 'kassa',
                'dutch_name' => 'Kassamedewerker'
            ]
        ]);
    }
}
