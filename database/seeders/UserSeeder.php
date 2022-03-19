<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@blog.com',
            'password' => Hash::make('admin123'),
            'role_id' => 1,
        ]);
        
        DB::table('roles')->insert([
            'name' => 'Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
