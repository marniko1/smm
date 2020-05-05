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
        $user = DB::table('users')->insert([
            'name' => 'Marko Nikolić',
            'username' => 'marko',
            'email' => 'marko.nikolic@crta.rs',
            'password' => Hash::make('M1Q8@4QpZsE*Gv9hdE*ay8#8R'),
        ]);

        $user->syncRoles(['Administrator']); //Assigning role to user
    }
}
