<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdClientsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'ad_clients';

    /**
     * Run the migrations.
     * @table ad_clients
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 100);
            $table->integer('document_type');
            $table->string('document', 15);
            $table->string('address', 80);
            $table->integer('city_id');
            $table->integer('state_id');
            $table->integer('zip_code');
            $table->string('complement', 40)->nullable();
            $table->string('im', 45)->nullable();
            $table->string('ie', 45)->nullable();
            $table->string('rg', 25)->nullable();
            $table->integer('number');
            $table->string('email', 45);
            $table->string('site', 45)->nullable();
            $table->string('telephone', 15)->nullable();
            $table->string('cellphone', 15);
            $table->string('fax', 15)->nullable();
            $table->integer('group_id');
            $table->integer('category_client');
            $table->integer('branch_activity')->nullable();
            $table->integer('status')->nullable()->default('1');

            $table->index(["state_id"], 'fk_ad_clients_ad_states1_idx');

            $table->index(["category_client"], 'fk_ad_clients_ad_client_categories_idx');

            $table->index(["group_id"], 'fk_ad_clients_ad_client_groups1_idx');

            $table->index(["city_id"], 'fk_ad_clients_ad_cities1_idx');

            $table->index(["branch_activity"], 'fk_ad_clients_ad_branch_activities1_idx');


            $table->foreign('state_id', 'fk_ad_clients_ad_states1_idx')
                ->references('id')->on('ad_states');

            $table->foreign('city_id', 'fk_ad_clients_ad_cities1_idx')
                ->references('id')->on('ad_cities');

            $table->foreign('group_id', 'fk_ad_clients_ad_client_groups1_idx')
                ->references('id')->on('ad_client_groups');

            $table->foreign('category_client', 'fk_ad_clients_ad_client_categories_idx')
                ->references('id')->on('ad_client_categories');

            $table->foreign('branch_activity', 'fk_ad_clients_ad_branch_activities1_idx')
                ->references('id')->on('ad_branch_activities');

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
