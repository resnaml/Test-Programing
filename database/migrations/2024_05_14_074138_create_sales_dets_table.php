<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesDetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_dets', function (Blueprint $table) {
            $table->id();
            $table->foreignId("sales_id");
            $table->foreignId("barang_id");
            $table->decimal("harga_bandrol",8,2);
            $table->integer("qty");
            $table->decimal("diskon_pct",8,2);
            $table->decimal("diskon_nilai",8,2);
            $table->decimal("harga_diskon",8,2);
            $table->decimal("total",8,2);
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
        Schema::dropIfExists('sales_dets');
    }
}
