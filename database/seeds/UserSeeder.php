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
            'password' => Hash::make('12345678'),
        ]);

        $user->assignRole('Administrator'); //Assigning role to user
    }
}
