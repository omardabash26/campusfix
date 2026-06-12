<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Admin account
        User::create([
            'name'            => 'מנהל מערכת',
            'identity_number' => '000000000',
            'email'           => 'admin@college.ac.il',
            'password'        => Hash::make('admin1234'),
            'role'            => 'admin',
            'department'      => 'מינהל',
            'is_active'       => true,
        ]);

        // Sample technician
        User::create([
            'name'            => 'יוסי כהן',
            'identity_number' => '111111111',
            'email'           => 'yosi@college.ac.il',
            'password'        => Hash::make('tech1234'),
            'role'            => 'technician',
            'department'      => 'תחזוקה',
            'phone'           => '050-1111111',
            'is_active'       => true,
        ]);

        // Sample student
        User::create([
            'name'            => 'דנה לוי',
            'identity_number' => '222222222',
            'email'           => 'dana@student.ac.il',
            'password'        => Hash::make('student1234'),
            'role'            => 'student',
            'department'      => 'מדעי המחשב',
            'is_active'       => true,
        ]);
    }
}