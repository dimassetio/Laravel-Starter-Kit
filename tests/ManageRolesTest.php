<?php

use App\Entities\Users\Role;
use App\Entities\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ManageRolesTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function admin_can_entry_role()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $this->visit('roles');
        $this->seePageIs('roles');
        $this->see(trans('role.roles'));
        $this->see(trans('role.create'));
        $this->click(trans('role.create'));

        // Fill Form
        $this->type('rolebaru','name');
        $this->type('Nama Role Baru','label');
        $this->press(trans('role.create'));

        $this->seePageIs('roles');
        $this->see(trans('role.created'));
        $this->seeInDatabase('roles_permissions', [
            'name' => 'rolebaru',
            'label' => 'Nama Role Baru',
            'type' => 0,
        ]);
    }

    /** @test */
    public function admin_can_edit_role_data()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $role = factory(Role::class)->create();

        $this->visit('roles?act=edit&id=' . $role->id);
        $this->seePageIs('roles?act=edit&id=' . $role->id);

        $this->see(trans('role.edit'));
        $this->see(trans('role.update'));

        // Fill Form
        $this->type('editedrole','name');
        $this->type('Role yang diedit','label');
        $this->press(trans('role.update'));

        $this->seePageIs('roles?act=edit&id=' . $role->id);
        $this->see(trans('role.updated'));
        $this->seeInDatabase('roles_permissions', [
            'name' => 'editedrole',
            'label' => 'Role yang diedit',
            'type' => 0
        ]);
    }

    /** @test */
    public function admin_can_delete_a_role()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $role = factory(Role::class)->create();

        $this->visit('roles?act=del&id=' . $role->id);
        $this->see(trans('app.delete_confirm_button'));
        $this->press(trans('app.delete_confirm_button'));
        $this->seePageIs('roles');
        $this->see(trans('role.deleted'));
        $this->notSeeInDatabase('roles_permissions', [
            'name' => $role->name,
            'label' => $role->label,
            'type' => 0
        ]);
    }

    /** @test */
    public function admin_can_see_all_roles()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $roles = factory(Role::class, 5)->create();
        $this->assertEquals(5, $roles->count());

        $this->visit('roles');
        $this->see($roles[1]->label);
        $this->see($roles[4]->label);
    }
}
