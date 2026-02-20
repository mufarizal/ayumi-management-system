<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Administrator',
            'email'=>'admin@ayumi.com',
            'password'=>Hash::make('password'),
            'role'=>'admin',
            'is_active'=>true,
            'created_by'=>null
        ]);
    }
}
