<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Diagnostic\DiagnosticTest::class, function (Faker $faker) {
    return [
        'service_category_id' 		 => 1,
        'service_sub_category_id' 	 => 1,
        'diagnostic_test_name' 		 => $faker->unique()->name,
        'diagnostic_test_price' 	 => str_shuffle('0234'),
        'diagnostic_test_sale_price' => str_shuffle('9234'),
        'created_by' 				 => 1,
    ];
});
