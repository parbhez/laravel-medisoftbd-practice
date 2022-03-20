<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\HR\SalaryInfo;

class CreateSalaryInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('salary_infos', function (Blueprint $table) {
            $table->increments('salary_id');
            $table->integer('user_id')->unsigned();
            $table->tinyInteger('salary_type')->default(1)->comment('1=>Full Time,2=>Part Time,3=>Commission based');
            $table->double('salary_amount', 12, 3);
            $table->double('due', 12, 3);
            $table->double('advanced', 12, 3);
            $table->double('last_payment_amount', 12, 3);
            $table->dateTime('last_payment_date');
            $table->integer('last_payment_by')->unsigned();
            $table->timestamps();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
        });


        //Restore data
        if (file_exists(dirname(__FILE__) . '/old_data/CreateSalary_infosTable.tbl')) {
            $data = file_get_contents(dirname(__FILE__) . '/old_data/CreateSalary_infosTable.tbl');
            $data = json_decode($data, true);
            if (is_array($data) && count($data) > 0) {
                $tableData = [];
                foreach ($data as $key => $value) {
                    $tableData [] = $value;
                }
                \Illuminate\Support\Facades\DB::table('salary_infos')->insert($tableData);
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
        $data = \Illuminate\Support\Facades\DB::table('salary_infos')->get()->toJson();
        file_put_contents(dirname(__FILE__) . '/old_data/CreateSalary_infosTable.tbl', $data);
                      
        Schema::dropIfExists('salary_infos');
    }
}
