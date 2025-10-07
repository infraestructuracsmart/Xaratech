<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'SUPER',
            'lastname' => 'ADMIN',
            'birthdate' => '1997-05-10',
            'email' => 'nolbertogonzalezc@gmail.com',
            'identification' => '1234188646',
            'password' => bcrypt('1234188646'),
        ]);
    }
}
