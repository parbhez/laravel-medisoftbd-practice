<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_invoices', function (Blueprint $table) {
            $table->increments('sale_id');
            $table->string('sale_invoice_id')->index();
            $table->integer('cus_id')->nullable();
            $table->integer('payment_type_id')->nullable();
            $table->double('discount', 12, 2)->default(0);
            $table->double('amount', 12, 2)->default(0);
            $table->double('pay', 12, 2)->default(0);
            $table->double('due', 12, 2)->default(0);
            $table->integer('pay_note')->default(0);
            $table->date('date')->nullable();
            $table->tinyInteger('status')->default(1)->comment('o = > Inactive, 1 = > Active');
            $table->smallInteger('year')->default(\Carbon\Carbon::now()->year);
            $table->timestamps();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
        });
        //Restore data
        if (file_exists(dirname(__FILE__) . '/old_data/Createsale_invoicesTable.tbl')) {
            $data = file_get_contents(dirname(__FILE__) . '/old_data/Createsale_invoicesTable.tbl');
            $data = json_decode($data, true);
            if (is_array($data) && count($data) > 0) {
                foreach ($data as $key => $value) {
                    \Illuminate\Support\Facades\DB::table('sale_invoices')->insert($value);
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
        $data = \Illuminate\Support\Facades\DB::table('sale_invoices')->get()->toJson();
        file_put_contents(dirname(__FILE__) . '/old_data/Createsale_invoicesTable.tbl', $data);

        Schema::dropIfExists('sale_invoices');
    }
}
