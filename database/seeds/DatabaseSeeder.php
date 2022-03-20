<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	$data = 500;
    	$start_time = date('H:i:s');
    	echo 'Start Time : '.$start_time;
        factory(App\Models\Diagnostic\DiagnosticTest::class, $data)->create();
        printf("\n");
    	$end_time = date('H:i:s');
        echo 'End Time : '.$end_time;
        printf("\n");
        echo 'Total '.$data.' row inserted.';
        printf("\n");
	    $total_second = (strtotime($end_time) - strtotime($start_time));
	    echo 'Time Consumed '.$total_second.' Seconds.';
        printf("\n");
    }
}
