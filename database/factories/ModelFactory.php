<?php

use App\Entities\Users\Permission;
use App\Entities\Users\Role;
use App\Entities\Users\User;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'username' => $faker->username,
        'email' => $faker->email,
        'password' => 'member',
        'remember_token' => str_random(10),
    ];
});

$factory->define(Role::class, function (Faker\Generator $faker) {
    return [
        'name' => implode('', $faker->words(2)),
        'label' => implode(' ', $faker->words(2)),
        'type' => 0
    ];
});

$factory->define(Permission::class, function (Faker\Generator $faker) {
    return [
        'name' => implode('', $faker->words(3)),
        'label' => implode(' ', $faker->words(3)),
        'type' => 1
    ];
});
