<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MedicalDegree extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_degrees', function (Blueprint $table) {
            $table->increments('medical_degree_id');
            $table->string('medical_degree_name');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
        });

        //Restore data
        if (file_exists(dirname(__FILE__) . '/old_data/CreateMedical_DegreesTable.tbl')) {
            $data = file_get_contents(dirname(__FILE__) . '/old_data/CreateMedical_DegreesTable.tbl');
            $data = json_decode($data, true);
            if (is_array($data) && count($data) > 0) {
                $tableData = [];
                foreach ($data as $key => $value) {
                    $tableData [] = $value;
                }
                \Illuminate\Support\Facades\DB::table('medical_degrees')->insert($tableData);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Backup Data
        $data = \Illuminate\Support\Facades\DB::table('medical_degrees')->get()->toJson();
        file_put_contents(dirname(__FILE__) . '/old_data/CreateMedical_DegreesTable.tbl', $data);
                                      
        Schema::dropIfExists('medical_degrees');
    }
}
