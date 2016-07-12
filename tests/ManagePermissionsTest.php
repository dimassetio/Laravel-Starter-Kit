<?php

use App\Entities\Users\Permission;
use App\Entities\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ManagePermissionsTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function admin_can_entry_permission()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $this->visit('permissions');
        $this->seePageIs('permissions');
        $this->see(trans('permission.permissions'));
        $this->see(trans('permission.create'));
        $this->click(trans('permission.create'));
        // $this->visit('permissions?act=add');
        $this->seePageIs('permissions?act=add');

        // Fill Form
        $this->submitForm(trans('permission.create'), [
            'name' => 'permissionbaru',
            'label' => 'Nama Permission Baru',
            'role' => [1,2]
        ]);

        $this->seePageIs('permissions');
        $this->see(trans('permission.created'));
        $this->seeInDatabase('roles_permissions', [
            'name' => 'permissionbaru',
            'label' => 'Nama Permission Baru',
            'type' => 1
        ]);

        $newPermissionId = DB::table('roles_permissions')->where('name','permissionbaru')->first()->id;

        $this->seeInDatabase('user_role_permission', [
            'permission_id' => $newPermissionId,
            'role_id' => 1,
        ]);

        $this->seeInDatabase('user_role_permission', [
            'permission_id' => $newPermissionId,
            'role_id' => 2,
        ]);

    }

    /** @test */
    public function admin_can_edit_permission_data()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $permission = factory(Permission::class)->create();

        $this->visit('permissions?act=edit&id=' . $permission->id);
        $this->seePageIs('permissions?act=edit&id=' . $permission->id);

        $this->see(trans('permission.edit'));
        $this->see(trans('permission.update'));

        // Fill Form
        $this->type('editedpermission','name');
        $this->type('Permission yang diedit','label');
        $this->press(trans('permission.update'));

        $this->seePageIs('permissions?act=edit&id=' . $permission->id);
        $this->see(trans('permission.updated'));
        $this->seeInDatabase('roles_permissions', [
            'name' => 'editedpermission',
            'label' => 'Permission yang diedit',
            'type' => 1
        ]);
    }

    /** @test */
    public function admin_can_delete_a_permission()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $permission = factory(Permission::class)->create();

        $this->visit('permissions?act=del&id=' . $permission->id);
        $this->see(trans('app.delete_confirm_button'));
        $this->press(trans('app.delete_confirm_button'));
        $this->seePageIs('permissions');
        $this->see(trans('permission.deleted'));
        $this->notSeeInDatabase('roles_permissions', [
            'name' => $permission->name,
            'label' => $permission->label,
            'type' => 1
        ]);
    }

    /** @test */
    public function admin_can_see_all_permissions()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $permissions = factory(Permission::class, 5)->create();
        $this->assertEquals(5, $permissions->count());

        $this->visit('permissions');
        $this->see($permissions[1]->label);
        $this->see($permissions[4]->label);
    }
}
