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
        $admin->name = env('ADMIN_NAME', 'Admin');
        $admin->email = env('ADMIN_EMAIL','admin@admin.com');
        $admin->password = Hash::make(env('ADMIN_PASSWORD', 'qwerty'));
        $admin->save();

    }
}
