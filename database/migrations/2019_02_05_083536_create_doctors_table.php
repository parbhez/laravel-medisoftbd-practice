<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->increments('doctor_id');
            $table->integer('user_id')->unsigned();
            $table->integer('department_id')->unsigned();
            $table->integer('designation_id')->unsigned();
            $table->string('educational_qualification_id')->nullable();
            $table->string('medical_degree_id')->nullable();
            $table->string('speciality')->nullable();
            $table->tinyInteger('allow_prescription_fee')->default(1)->comment('0=>Not Allowed, 1=>Allowed');
            $table->decimal('prescription_fee', 9, 3)->default(0);
            $table->tinyInteger('payment_receiving_process')->default(1)->comment('1=>Received By Hospital With Appointment, 2=>Received By Doctor With Appointment');
            $table->tinyInteger('commission_type')->default(1)->comment('1=>Type 1, 2=>Type 2');
            $table->decimal('commission', 9, 3)->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
        });

        //Restore data
        if (file_exists(dirname(__FILE__) . '/old_data/CreateDoctorsTable.tbl')) {
            $data = file_get_contents(dirname(__FILE__) . '/old_data/CreateDoctorsTable.tbl');
            $data = json_decode($data, true);
            if (is_array($data) && count($data) > 0) {
                $tableData = [];
                foreach ($data as $key => $value) {
                    $tableData [] = $value;
                }
                \Illuminate\Support\Facades\DB::table('doctors')->insert($tableData);
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
        $data = \Illuminate\Support\Facades\DB::table('doctors')->get()->toJson();
        file_put_contents(dirname(__FILE__) . '/old_data/CreateDoctorsTable.tbl', $data);
            
        Schema::dropIfExists('doctors');
    }
}
