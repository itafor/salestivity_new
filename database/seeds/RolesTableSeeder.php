<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['id' => 1, 'name' => 'Super Admin'],
            ['id' => 2, 'name' => 'Admin'],
            ['id' => 3, 'name' => 'General Users'],
        ];

        foreach($roles as $role) {
            Role::updateOrCreate(['id' => $role['id']], $role);
        }
    }
}
