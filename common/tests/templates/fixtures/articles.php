<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'author_id' => 1,
    'post_title' => $faker->text(100),
    'slug' => $faker->slug(4),
    'excerpt' => $faker->text(1000),
    'content' => $faker->text(2500),
    'post_status' => 'draft',
    'is_premium' => 0,
    'created_at' => $faker->UnixTime(),
    'updated_at' => $faker->UnixTime(),
    'user_ip' => $faker->ipv4
];