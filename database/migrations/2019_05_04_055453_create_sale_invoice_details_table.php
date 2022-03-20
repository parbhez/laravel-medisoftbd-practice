<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_invoice_details', function (Blueprint $table) {
            $table->increments('sale_details_id')->index();
            $table->string('sale_invoice_id')->index();
            $table->integer('package_id')->nullable();
            $table->integer('group_id')->nullable();
            $table->integer('diagnostic_test_id')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->double('discount', 12, 2)->default(0);
            $table->double('tax', 12, 2)->default(0);
            $table->double('amount', 12, 2)->default(0);
            $table->tinyInteger('status')->default(1)->comment('0 => Inactive, 1 = > Active');
            $table->smallInteger('year')->default(\Carbon\Carbon::now()->year);
            $table->timestamps();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
        });

        //Restore data
        if (file_exists(dirname(__FILE__) . '/old_data/Createsale_invoice_detailsTable.tbl')) {
            $data = file_get_contents(dirname(__FILE__) . '/old_data/Createsale_invoice_detailsTable.tbl');
            $data = json_decode($data, true);
            if (is_array($data) && count($data) > 0) {
                foreach ($data as $key => $value) {
                    \Illuminate\Support\Facades\DB::table('sale_invoice_details')->insert($value);
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
        $data = \Illuminate\Support\Facades\DB::table('sale_invoice_details')->get()->toJson();
        file_put_contents(dirname(__FILE__) . '/old_data/Createsale_invoice_detailsTable.tbl', $data);

        Schema::dropIfExists('sale_invoice_details');
    }
}
