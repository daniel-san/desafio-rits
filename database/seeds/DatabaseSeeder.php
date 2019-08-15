<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        $admin = new App\User();
        $admin->name = 'Admin Teste';
        $admin->email = 'admin@admin.com';
        $admin->password = Hash::make('qwerty');
        $admin->save();

    }
}
