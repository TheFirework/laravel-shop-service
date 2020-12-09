<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Admin;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


// 头像假数据
$avatars = [
    'https://cdn.learnku.com/uploads/images/201710/14/1/s5ehp11z6s.png',
    'https://cdn.learnku.com/uploads/images/201710/14/1/Lhd1SHqu86.png',
    'https://cdn.learnku.com/uploads/images/201710/14/1/LOnMrqbHJn.png',
    'https://cdn.learnku.com/uploads/images/201710/14/1/xAuDMxteQy.png',
    'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png',
    'https://cdn.learnku.com/uploads/images/201710/14/1/NDnzMutoxX.png',
];

$factory->define(Admin::class, function (Faker $faker) use($avatars){
    $date_time = $faker->date . ' ' . $faker->time;
    return [
        'name' => $faker->name,
        'username' => $faker->userName,
        'nickname' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'remark' => $faker->text,
        'status' => $faker->randomElement([1, 0]),
        'dept_id' => $faker->randomElement([1, 2, 3, 4, 5, 6]),
        'is_delete' => 0,
        'role_id' => $faker->randomElement([1, 2, 3, 4]),
        'avatar' => $faker->randomElement($avatars),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});
