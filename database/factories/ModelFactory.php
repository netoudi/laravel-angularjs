<?php

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

$factory->define(CodeProject\Entities\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(CodeProject\Entities\Client::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'responsible' => $faker->name,
        'email' => strtolower($faker->email),
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'skype' => $faker->word,
        'twitter' => strtolower('@' . $faker->domainWord),
        'facebook' => strtolower($faker->domainWord),
        'google_plus' => strtolower($faker->domainWord),
        'website' => strtolower($faker->domainName),
        'obs' => $faker->paragraph
    ];
});

$factory->define(CodeProject\Entities\Project::class, function (Faker\Generator $faker) {
    return [
        'owner_id' => rand(1, 30),
        'client_id' => rand(1, 30),
        'name' => $faker->word,
        'description' => $faker->text(300),
        'progress' => rand(0, 100),
        'status' => rand(0, 3),
        'start_date' => $faker->dateTime('now'),
        'due_date' => $faker->dateTime($faker->dateTime('now'), '+ 360 days')
    ];
});

$factory->define(CodeProject\Entities\ProjectNote::class, function (Faker\Generator $faker) {
    return [
        'project_id' => rand(1, 30),
        'title' => $faker->word,
        'note' => $faker->paragraph
    ];
});

$factory->define(CodeProject\Entities\ProjectTask::class, function (Faker\Generator $faker) {
    return [
        'project_id' => rand(1, 30),
        'name' => $faker->name,
        'start_date' => $faker->dateTime('now'),
        'due_date' => $faker->dateTime('now'),
        'status' => rand(1, 3)
    ];
});

$factory->define(CodeProject\Entities\ProjectMember::class, function (Faker\Generator $faker) {
    return [
        'project_id' => rand(1, 30),
        'member_id' => rand(1, 30)
    ];
});