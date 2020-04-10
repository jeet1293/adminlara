<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
               'name'=>'Admin',
               'email'=>'admin@test.com',
               'is_admin'=>true,
               'password'=> bcrypt('Admin@2020'),
            ],
            [
               'name'=>'User',
               'email'=>'user@test.com',
               'is_admin'=>false,
               'password'=> bcrypt('User@2020'),
            ],
        ];
  
        foreach ($user as $key => $value) {
            $user = User::create($value);
        }
    }
}
