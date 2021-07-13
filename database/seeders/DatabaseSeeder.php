<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'master',
            'email' => 'master@erp.com',
            'password' => Hash::make('secret'),
            'role_id' => 1
        ]);

        Role::insert([
            ['role' => 'Master'],
            ['role' => 'Admin'],
            ['role' => 'User'],

        ]);

    }
}
