<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        
        $roles = Config::get('default.roles');
        foreach ($roles as $key => $role) {
            Role::create($role);
        }

        $permissions = Config::get('default.permissions');
        foreach ($permissions as $key => $permission) {
            Permission::create($permission);
        }

        $users = Config::get('default.users');
        foreach ($users as $key => $user) {
            $u = User::create($user);
        }

        $this->call(BrandSeeder::class);
    }
}
