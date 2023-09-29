<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Admin User
        $user = User::create([
            'name'          => 'Gaurav Kamal',
            'email'         =>  'admin@admin.com',
            'password'      =>  Hash::make('Admin@123#'),
            'image'         => '/assets/admin/img/user_placeholder.jpg',
            'mobile_number' =>  '9028187696',
            'role_id'       => 1
        ]);
    }
}
