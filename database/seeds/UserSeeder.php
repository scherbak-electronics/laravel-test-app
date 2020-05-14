<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Repositories\UserRepository;
use App\Services\TransactionService;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Vadim',
            'email' => 'vadim.scherbak.electronics@gmail.com',
            'password' => Hash::make('q3r5t7i0'),
            'admin' => true
        ]);
        DB::table('users')->insert([
            'name' => 'Maria Scherbak',
            'email' => 'maria.scherbak777@gmail.com',
            'password' => Hash::make('q3r5t7i0'),
            'admin' => false
        ]);
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
            'admin' => false
        ]);
        DB::table('users')->insert([
            'name' => 'ann',
            'email' => 'ann.scherbak@gmail.com',
            'password' => Hash::make('11111111'),
            'admin' => false
        ]);
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
            'admin' => false
        ]);
        $userRepo = new UserRepository;
        $trServ = new TransactionService;
        $faker = \Faker\Factory::create();
        $users = $userRepo->getAllUsers();
        foreach($users as $user) {
            for($count = 5; $count > 0; $count--) {
                $amount = $faker->randomFloat(2, 1, 50); 
                $trServ->createUserTransaction($user, $amount);
            }    
        }
    }
}