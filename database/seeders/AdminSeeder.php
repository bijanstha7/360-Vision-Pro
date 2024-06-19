<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usercheck = User::where('email', 'admin@gmail.com')->first();
        if ($usercheck != null) {
            $usercheck->delete();
        }
        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@gmail.com';
        $user->role = 1; // For Admin
        $user->status = 1;
        $user->password = Hash::make('123456');
        $user->save();
    }
}
