<?php

// use Database\Seeders\ProductAndSalesSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(UserRolesPermissionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(UsersRoleTableSeeder::class);
        $this->call(RolesPermissionTableSeeder::class);
        $this->call(ProductAndSalesSeeder::class);
        Model::reguard();
    }
}
