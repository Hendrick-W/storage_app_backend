<?php

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
        //
        DB::table('users')->insert([
            'nomor_pegawai' => '001',
            'nama' => 'admin',
            'tanggal_lahir' => '1999-09-21',
            'role_id' => 0,
            'password' => bcrypt('admin_001'),
        ]);
    }
}
