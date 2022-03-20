<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EducationalQualifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educational_qualifications', function (Blueprint $table) {
            $table->increments('educational_qualification_id');
            $table->string('educational_qualification_name');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
        });


        //Restore data
        if (file_exists(dirname(__FILE__) . '/old_data/CreateEducational_QualificationsTable.tbl')) {
            $data = file_get_contents(dirname(__FILE__) . '/old_data/CreateEducational_QualificationsTable.tbl');
            $data = json_decode($data, true);
            if (is_array($data) && count($data) > 0) {
                $tableData = [];
                foreach ($data as $key => $value) {
                    $tableData [] = $value;
                }
                \Illuminate\Support\Facades\DB::table('educational_qualifications')->insert($tableData);
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
        $data = \Illuminate\Support\Facades\DB::table('educational_qualifications')->get()->toJson();
        file_put_contents(dirname(__FILE__) . '/old_data/CreateEducational_QualificationsTable.tbl', $data);
                              
        Schema::dropIfExists('educational_qualifications');
    }
}
