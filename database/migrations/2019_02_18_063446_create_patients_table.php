<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('patient_id');
            $table->integer('user_id')->unsigned();
            $table->string('blood_group')->nullable();
            $table->tinyInteger('age')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
        });

        \Illuminate\Support\Facades\DB::update("ALTER TABLE patients AUTO_INCREMENT = 1001;");

        //Restore data
        if (file_exists(dirname(__FILE__) . '/old_data/CreatePatientsTable.tbl')) {
            $data = file_get_contents(dirname(__FILE__) . '/old_data/CreatePatientsTable.tbl');
            $data = json_decode($data, true);
            if (is_array($data) && count($data) > 0) {
                $tableData = [];
                foreach ($data as $key => $value) {
                    $tableData [] = $value;
                }
                \Illuminate\Support\Facades\DB::table('patients')->insert($tableData);
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
        $data = \Illuminate\Support\Facades\DB::table('patients')->get()->toJson();
        file_put_contents(dirname(__FILE__) . '/old_data/CreatePatientsTable.tbl', $data);

        Schema::dropIfExists('patients');
    }
}
