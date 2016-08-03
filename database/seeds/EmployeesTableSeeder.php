<?php

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         DB::table('employees')->insert([
            'first_name' => 'super',
            'last_name' => 'admin',
            'email' => 'webdesignandsolution15@gmail.com',
            'username' => 'admin',
            'password' => bcrypt('1s2s2pqr'),
            'created_at' => date('Y-m-d H:s:i'),
            'updated_at' => date('Y-m-d H:s:i'), 
            'is_admin' => 1
        ]);
    }
}
