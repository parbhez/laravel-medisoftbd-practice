<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_sub_categories', function (Blueprint $table) {
            $table->increments('service_sub_category_id');
            $table->string('service_sub_category_name');
            $table->integer('service_category_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
        });


        //Restore data
        if (file_exists(dirname(__FILE__) . '/old_data/CreateService_sub_CategoriesTable.tbl')) {
            $data = file_get_contents(dirname(__FILE__) . '/old_data/CreateService_sub_CategoriesTable.tbl');
            $data = json_decode($data, true);
            if (is_array($data) && count($data) > 0) {
                foreach ($data as $key => $value) {
                    \Illuminate\Support\Facades\DB::table('service_sub_categories')->insert($value);
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
        $data = \Illuminate\Support\Facades\DB::table('service_sub_categories')->get()->toJson();
        file_put_contents(dirname(__FILE__) . '/old_data/CreateService_sub_CategoriesTable.tbl', $data);

        Schema::dropIfExists('service_sub_categories');
    }
}
