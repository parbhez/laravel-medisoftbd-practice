<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiagnosticTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnostic_tests', function (Blueprint $table) {
            $table->increments('diagnostic_test_id');
            $table->string('diagnostic_test_name')->unique();
            $table->double('diagnostic_test_price', 12, 3)->default(0);
            $table->double('diagnostic_test_sale_price', 12, 3)->default(0);
            $table->tinyInteger('service_category_id');
            $table->tinyInteger('service_sub_category_id')->nullable();
            $table->tinyInteger('diagnostic_test_result_type')->default(1)->comment('1=> Positive/Negative, 2=> Yes/No, 3 => Unit Base');
            $table->string('diagnostic_test_normal_value')->nullable();
            $table->string('diagnostic_test_result_unit')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
        });

        //Restore data
        if (file_exists(dirname(__FILE__) . '/old_data/CreateDiagnostic_TestsTable.tbl')) {
            $data = file_get_contents(dirname(__FILE__) . '/old_data/CreateDiagnostic_TestsTable.tbl');
            $data = json_decode($data, true);
            if (is_array($data) && count($data) > 0) {
                $tableData = [];
                foreach ($data as $key => $value) {
                    $tableData [] = $value;
                }
                \Illuminate\Support\Facades\DB::table('diagnostic_tests')->insert($tableData);
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
        $data = \Illuminate\Support\Facades\DB::table('diagnostic_tests')->get()->toJson();
        file_put_contents(dirname(__FILE__) . '/old_data/CreateDiagnostic_TestsTable.tbl', $data);

        Schema::dropIfExists('diagnostic_tests');
    }
}
