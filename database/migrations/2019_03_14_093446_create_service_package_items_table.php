<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicePackageItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_package_items', function (Blueprint $table) {
            $table->increments('service_package_item_id');
            $table->integer('service_package_id');
            $table->tinyInteger('type')->default(1)->comment("1 = > Service, 2 => Service Group, 3 =. Service Package");
            $table->integer('service_item_id')->unsigned();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
        });

        //Restore data
        if (file_exists(dirname(__FILE__) . '/old_data/Createservice_package_itemsTable.tbl')) {
            $data = file_get_contents(dirname(__FILE__) . '/old_data/Createservice_package_itemsTable.tbl');
            $data = json_decode($data, true);
            if (is_array($data) && count($data) > 0) {
                foreach ($data as $key => $value) {
                    \Illuminate\Support\Facades\DB::table('service_package_items')->insert($value);
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
        $data = \Illuminate\Support\Facades\DB::table('service_package_items')->get()->toJson();
        file_put_contents(dirname(__FILE__) . '/old_data/Createservice_package_itemsTable.tbl', $data);

        Schema::dropIfExists('service_package_items');
    }
}
