<?php

use App\User;
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
        $user = User::create([
            'name' => 'Marko Nikolić',
            'username' => 'marko',
            'email' => 'marko.nikolic@crta.rs',
            'password' => '12345678',
        ]);

        $user = User::create([
            'name' => 'Miloš Kostić',
            'username' => 'misha',
            'email' => 'milos.kostic@crta.rs',
            'password' => '12345678',
        ]);

        $user->assignRole('Administrator'); //Assigning role to user
    }
}
