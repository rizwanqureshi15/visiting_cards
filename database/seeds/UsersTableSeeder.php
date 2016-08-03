<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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
            'first_name' => 'Amrin',
            'last_name' => 'Khatri',
            'email' => 'amrin.umar.khatri@gmail.com',
            'username' => 'Amee',
            'password' => bcrypt('amrin'),
            'created_at' => date('Y-m-d H:s:i'),
            'updated_at' => date('Y-m-d H:s:i'), 
            
        ]);
    }
}
