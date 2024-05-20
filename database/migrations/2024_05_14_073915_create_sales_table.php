<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string("kode",15)->autoIncrement();
            $table->date("tgl");
            $table->foreignId("cust_id");
            $table->integer("jml_qty");
            $table->decimal("subtotal",8,2);
            $table->decimal("diskon",8,2);
            $table->decimal("ongkir",8,2);
            $table->decimal("total_bayar",8,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
