<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceGroupItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_group_items', function (Blueprint $table) {
            $table->increments('service_group_item_id');
            $table->integer('service_group_id');
            $table->integer('diagnostic_test_id');
            $table->timestamps();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
        });

        //Restore data
        if (file_exists(dirname(__FILE__) . '/old_data/CreateService_Groups_ItemTable.tbl')) {
            $data = file_get_contents(dirname(__FILE__) . '/old_data/CreateService_Groups_ItemTable.tbl');
            $data = json_decode($data, true);
            if (is_array($data) && count($data) > 0) {
                foreach ($data as $key => $value) {
                    \Illuminate\Support\Facades\DB::table('service_group_items')->insert($value);
                }
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
        $data = \Illuminate\Support\Facades\DB::table('service_group_items')->get()->toJson();
        file_put_contents(dirname(__FILE__) . '/old_data/CreateService_Groups_ItemTable.tbl', $data);

        Schema::dropIfExists('service_group_items');
    }
}
