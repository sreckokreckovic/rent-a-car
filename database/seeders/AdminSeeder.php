<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->create([
            'name'=>'admin',
            'email'=>'superadmin@mailinator.com',
            'password'=>'12345678',
            'is_admin'=>true,
        ]);
    }
}
