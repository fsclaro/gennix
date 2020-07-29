<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::insert(['title' => 'Acesso à Administração do Site', 'slug' => 'site-management', 'created_at' => now()]);

        Permission::insert(['title' => 'Gestão de Acesso', 'slug' => 'access-management', 'created_at' => now()]);

        Permission::insert(['title' => 'Acessar cadastro de usuários', 'slug' => 'user-access', 'created_at' => now()]);
        Permission::insert(['title' => 'Criar usuário', 'slug' => 'user-create', 'created_at' => now()]);
        Permission::insert(['title' => 'Editar usuário', 'slug' => 'user-edit', 'created_at' => now()]);
        Permission::insert(['title' => 'Exibir usuário', 'slug' => 'user-show', 'created_at' => now()]);
        Permission::insert(['title' => 'Excluir usuário', 'slug' => 'user-delete', 'created_at' => now()]);
        Permission::insert(['title' => 'Editar perfil', 'slug' => 'user-profile', 'created_at' => now()]);

        Permission::insert(['title' => 'Acessar cadastro de permissões', 'slug' => 'permission-access', 'created_at' => now()]);
        Permission::insert(['title' => 'Criar permissão', 'slug' => 'permission-create', 'created_at' => now()]);
        Permission::insert(['title' => 'Editar permissão', 'slug' => 'permission-edit', 'created_at' => now()]);
        Permission::insert(['title' => 'Exibir permissão', 'slug' => 'permission-show', 'created_at' => now()]);
        Permission::insert(['title' => 'Excluir permissão', 'slug' => 'permission-delete', 'created_at' => now()]);

        Permission::insert(['title' => 'Acessar cadastro de papéis', 'slug' => 'role-access', 'created_at' => now()]);
        Permission::insert(['title' => 'Criar papel', 'slug' => 'role-create', 'created_at' => now()]);
        Permission::insert(['title' => 'Editar papel', 'slug' => 'role-edit', 'created_at' => now()]);
        Permission::insert(['title' => 'Exibir papel', 'slug' => 'role-show', 'created_at' => now()]);
        Permission::insert(['title' => 'Excluir papel', 'slug' => 'role-delete', 'created_at' => now()]);
        Permission::insert(['title' => 'Clonar papel', 'slug' => 'role-clone', 'created_at' => now()]);

        Permission::insert(['title' => 'Acessar às atividades', 'slug' => 'activity-access', 'created_at' => now()]);
        Permission::insert(['title' => 'Exibir atividade', 'slug' => 'activity-show', 'created_at' => now()]);

        Permission::insert(['title' => 'Acessar área de suporte', 'slug' => 'support-access', 'created_at' => now()]);
        Permission::insert(['title' => 'Acessar Log-Viewer', 'slug' => 'log-viewer-access', 'created_at' => now()]);
        Permission::insert(['title' => 'Acessar Route-Viewer', 'slug' => 'route-viewer-access', 'created_at' => now()]);

        // Get all permissions
        $permissions = Permission::all();
        Role::findOrFail(1) // Admin Role
            ->permissions()
            ->sync($permissions->pluck('id'));

        // Permission Filter for User Role
        $permissionUser = $permissions->filter(function ($permission) {
            return $permission->slug == 'user-profile' ||
                   $permission->slug == 'activity-access' ||
                   $permission->slug == 'activity-show' ||
                   $permission->slug == 'activity-delete' ||
                   $permission->slug == 'log-access';
        });
        Role::findOrFail(2) // User Role
            ->permissions()
            ->sync($permissionUser->pluck('id'));
    }
}
