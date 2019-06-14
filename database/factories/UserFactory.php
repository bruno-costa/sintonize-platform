<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Asset;
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(\App\Models\Radio::class, function (Faker $faker) {
    $r = new \App\Models\Radio();
    $a = Asset::newFromUrl('https://picsum.photos/400/300');
    $a->save();
    $r->id = Str::uuid()->toString();
    $r->avatar_asset_id = $a->id;
    $r->name = $faker->firstName;
    $r->description = '';
    $r->city = $faker->city;
    $r->estate = '';
    $r->themeColor($faker->hexColor);
    $r->streamUrl("http://cast.hoost.com.br:9183/stream");
    return $r->toArray();
});

$factory->define(\App\Models\Content::class, function (Faker $faker) {
    $c = new \App\Models\Content();
    $a = Asset::newFromUrl('https://picsum.photos/400/300');
    usleep(400);
    $a->save();
    $c->id = Str::uuid()->toString();
    $c->radio_id = \App\Models\Radio::inRandomOrder()->first()->id;
    $c->text = $faker->text(60);
    $c->image_asset_id = $a->id;

    $l = new \App\Repositories\Promotions\PromotionLink($c);
    $l->label = "Veja Aqui";
    $l->url = $faker->url;

    $a = new \App\Repositories\Promotions\PromotionAnswer($c);

    $t = new \App\Repositories\Promotions\PromotionTest($c);
    $t->addRawOption($faker->text(12));
    $t->addRawOption($faker->text(12));
    $t->addRawOption($faker->text(13));
    $t->addRawOption($faker->text(14));

    $c->promotion($faker->randomElement([$l, $a, $t]));

    return $c->toArray();
});