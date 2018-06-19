<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdPlansTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'ad_plans';

    /**
     * Run the migrations.
     * @table ad_plans
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 45);
            $table->text('description');
            $table->integer('status')->default('1');
            $table->integer('product_id');
            $table->decimal('monthly_price', 10, 2)->nullable()->default('0');
            $table->decimal('annual_price', 10, 2)->nullable()->default('0');
            $table->decimal('quarterly_price', 10, 2)->nullable()->default('0');
            $table->decimal('semi_annual_price', 10, 2)->nullable()->default('0');
            $table->integer('select_period');
            $table->date('due_date');
            $table->date('date_hiring');
            $table->integer('days_of_suspension');

            $table->index(["product_id"], 'fk_plans_to_products_idx');

            $table->foreign('product_id', 'fk_plans_to_products_idx')
                ->references('id')->on('ad_products')
                ->onDelete('no action')
                ->onUpdate('no action');

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
       Schema::dropIfExists($this->set_schema_table);
     }
}
