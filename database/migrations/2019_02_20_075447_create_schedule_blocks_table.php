<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_blocks', function (Blueprint $table) {
            $table->increments('schedule_block_id');
            $table->integer('schedule_slot_id')->unsigned();
            $table->date('schedule_block_date');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
        });

        //Restore data
        if (file_exists(dirname(__FILE__) . '/old_data/CreateSchedule_BlocksTable.tbl')) {
            $data = file_get_contents(dirname(__FILE__) . '/old_data/CreateSchedule_BlocksTable.tbl');
            $data = json_decode($data, true);
            if (is_array($data) && count($data) > 0) {
                $tableData = [];
                foreach ($data as $key => $value) {
                    $tableData [] = $value;
                }
                \Illuminate\Support\Facades\DB::table('schedule_blocks')->insert($tableData);
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
        $data = \Illuminate\Support\Facades\DB::table('schedule_blocks')->get()->toJson();
        file_put_contents(dirname(__FILE__) . '/old_data/CreateSchedule_BlocksTable.tbl', $data);

        Schema::dropIfExists('schedule_blocks');
    }
}
