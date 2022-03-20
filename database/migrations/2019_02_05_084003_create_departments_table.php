<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Settings\Department;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('department_id');
            $table->string('department_name');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
        });

        //Restore data
        if (file_exists(dirname(__FILE__) . '/old_data/CreateDepartmentsTable.tbl')) {
            $data = file_get_contents(dirname(__FILE__) . '/old_data/CreateDepartmentsTable.tbl');
            $data = json_decode($data, true);
            if (is_array($data) && count($data) > 0) {
                $tableData = [];
                foreach ($data as $key => $value) {
                    $tableData [] = $value;
                }
                \Illuminate\Support\Facades\DB::table('departments')->insert($tableData);
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
        $data = \Illuminate\Support\Facades\DB::table('departments')->get()->toJson();
        file_put_contents(dirname(__FILE__) . '/old_data/CreateDepartmentsTable.tbl', $data);
              
        Schema::dropIfExists('departments');
    }
}
