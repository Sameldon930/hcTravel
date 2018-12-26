<?php

use Illuminate\Database\Seeder;

class AuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now();

        DB::table('admins')->insert([
            'name' => '管理员',
            'mobile' => '18850503821',
            'password' => bcrypt(123456),
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('roles')->insert([
            'name' => 'admin',
            'display' => '超级管理员',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('admin_role')->insert([
            'admin_id' => 1,
            'role_id' => 1,
        ]);
    }
}
