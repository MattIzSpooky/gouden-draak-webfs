<?php

use App\User;
use App\UserRole;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'badge' => 10,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'user_role_id' => UserRole::ADMIN
        ]);

        User::create([
            'name' => 'Waitress User',
            'badge' => 15,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'user_role_id' => UserRole::WAITRESS
        ]);

        User::create([
            'name' => 'Kassa User',
            'badge' => 20,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'user_role_id' => UserRole::KASSA
        ]);

        factory(User::class, 3)->create();
    }
}
