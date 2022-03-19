<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach(range(1,100) as $value) {
            $name = $faker->name;
            DB::table('categories')->insert([
                'name' => $name,
                'slug' => Str::slug($name ,'-'),
                'description' => $faker->text,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('tags')->insert([
                'name' => $name,
                'slug' => Str::slug($name ,'-'),
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
