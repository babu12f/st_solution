<?php

use Faker\Generator as Faker;


$factory->define(App\User::class, function (Faker $faker) {
    static $password;
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        //'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Product::class, function (Faker $faker) {
    
    return [
        'user_id' => App\User::all()->random()->id,
        'name' => $faker->word,
        'price' => $faker->randomFloat(2,1,100),
        'description' => $faker->paragraph(random_int(1,10))
    ];
});
