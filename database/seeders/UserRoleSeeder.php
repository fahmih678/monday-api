<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['manager', 'keeper', 'customer'];

        $permissions = ['create role', 'update role', 'delete role', 'view role'];

        foreach ($roles as $key => $roleName) {
            $role = Role::firstOrcreate(['name' => $roleName]);
        }

        foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);
        }

        $managerRole = Role::where('name', 'manager')->first();
        $managerRole->givePermissionTo($permissions);

        foreach ($roles as $roleName) {
            $user = User::factory()->create([
                'name' => $roleName . ' User',
                'email' => $roleName . '@gmail.com',
                'phone' => fake()->unique()->phoneNumber(),
                'photo' => fake()->imageUrl(640, 480, 'pe ople'),
                'password' => Hash::make('password'),
            ]);

            $user->assignRole($roleName);
        }
    }
}
