<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::create([
            'name' => 'Abdallah Hamdy',
            'email' => 'admin@test.com',
            'password' => Hash::make('12345678'), 
        ]);

        $user1->assignRole('admin');

        $user2 = User::create([
            'name' => 'Abdallah mohamed',
            'email' => 'employee@test.com',
            'password' => Hash::make('12345678'), 
        ]);

        $user2->assignRole('employee');
    }
}
