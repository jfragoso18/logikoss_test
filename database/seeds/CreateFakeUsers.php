<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;

class CreateFakeUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('es_ES');
        foreach (range(1,30) as $index){
            $user = new User();
            $user->email = $faker->email;
            $user->password = 'secret';
            $user->name = $faker->name;
            $user->username = $faker->userName;

            $user->save();
        }
    }
}
