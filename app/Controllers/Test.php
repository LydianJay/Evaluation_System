<?php

namespace App\Controllers;

class Test extends BaseController
{
    public function index()
    {
        // return view('welcome_message');

        echo 'ok';

        var_dump($this->fake());
    }

    public function fake()
    {
        $faker = \Faker\Factory::create();

        $data = array();
        for ($i = 0; $i < 50; $i++) {
            $data[]  = array(
                'idno'      => $faker->randomNumber(8, true),
                'fname'     => $faker->firstName(),
                'mname'     => $faker->firstName(),
                'lname'     => $faker->lastName(),
                'course'    => $faker->jobTitle(),
                'yr_lvl'    => $faker->numberBetween(1, 4),
            );
        }

        return $data;
    }
}
