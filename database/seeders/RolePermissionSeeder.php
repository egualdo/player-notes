<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // // Limpiar caché de permisos
        // app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Crear Permisos
        $permissions = [
            // Permisos para notas de jugador
            'view-player-notes',
            'create-player-notes',
            'edit-player-notes',
            'delete-player-notes',

            // Permisos para perfil de jugador
            'view-player-profile',
            'edit-player-profile',
            'ban-players',
            'view-player-purchases',
            'view-player-activity',

            // Permisos administrativos
            'manage-roles',
            'manage-permissions',
            'view-audit-logs',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // 2. Crear Roles y asignar permisos

        // Rol: Admin (todos los permisos)
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo(Permission::all());

        // Rol: Support Manager (gestión completa de soporte)
        $supportManagerRole = Role::create(['name' => 'support_manager', 'guard_name' => 'web']);
        $supportManagerRole->givePermissionTo([
            'view-player-notes',
            'create-player-notes',
            'edit-player-notes',
            'delete-player-notes',
            'view-player-profile',
            'edit-player-profile',
            'ban-players',
            'view-player-purchases',
            'view-player-activity',
        ]);

        // Rol: Support Agent (solo lectura y creación)
        $supportAgentRole = Role::create(['name' => 'support_agent', 'guard_name' => 'web']);
        $supportAgentRole->givePermissionTo([
            'view-player-notes',
            'create-player-notes',
            'view-player-profile',
            'view-player-purchases',
            'view-player-activity',
        ]);

        // Rol: Viewer (solo lectura)
        $viewerRole = Role::create(['name' => 'viewer', 'guard_name' => 'web']);
        $viewerRole->givePermissionTo([
            'view-player-notes',
            'view-player-profile',
            'view-player-purchases',
            'view-player-activity',
        ]);

        // 3. Asignar roles a usuarios existentes (ejemplo)
        // Asignar admin al usuario con ID 1
        $adminUser = User::find(1);
        if ($adminUser) {
            $adminUser->assignRole('admin');
        }

        // Asignar support manager al usuario con ID 2
        $managerUser = User::find(2);
        if ($managerUser) {
            $managerUser->assignRole('support_manager');
        }
    }
}
