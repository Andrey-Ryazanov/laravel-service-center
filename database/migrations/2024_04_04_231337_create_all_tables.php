<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTables extends Migration
{
    public function up()
    {
        $this->createUsersTable();
        $this->createUsersDetailsTable();
        $this->createCategoriesTable();
        $this->createServicesTable();
        $this->createServiceDeliveryMethodsTable();
        $this->createCategoryServicesTable();
        $this->createDeadlinesTable();
        $this->createCartsTable();
        $this->createStatusesTable();
        $this->createOrdersTable();
        $this->createStatusChangeHistoryTable();
        $this->createOrderItemsTable();
        $this->createPasswordResetsTable();
    }

    public function down()
    {
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('status_change_history');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('statuses');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('category_services');
        Schema::dropIfExists('service_delivery_methods');
        Schema::dropIfExists('services');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('role_has_permissions');
        Schema::dropIfExists('model_has_roles');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('users_details');
        Schema::dropIfExists('users');
    }

    //Миграция таблицы «Пользователи»
    private function createUsersTable()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('login', 20)->unique();
            $table->string('email', 50)->unique();
            $table->string('phone', 12);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('two_factor_code', 6)->nullable();
            $table->dateTime('two_factor_expires_at')->nullable();
            $table->boolean('two_factor_enabled')->default(false);
            $table->timestamps();
        });
    }
    //Миграция таблицы «Личные данные пользователей»
    private function CreateUsersDetailsTable()
    {
     Schema::create('users_details', function (Blueprint
    $table)
     {
     $table->unsignedBigInteger('user_id')->primary();
     $table->string('surname', 50);
     $table->string('name', 50);
     $table->string('patronymic', 50);
     $table->string('address');
     $table->timestamps();
     });
     Schema::table('users_details', function($table) {
     $table->foreign('user_id')->references('id_user')->on('users')->onDelete('cascade');
     });
    }
    //Миграция таблицы «Категории»
    private function CreateCategoriesTable()
    {
     Schema::create('categories', function (Blueprint $table)
     {
     $table->id('id_category');
     $table->string('title');
     $table->string('category_image')->nullable();
     $table->unsignedBigInteger('parent_id')->nullable();
     $table->timestamps();
     $table->foreign('parent_id')
     ->references('id_category')->on('categories');
     });
    }
    //Миграция таблицы «Услуги»
    private function CreateServicesTable()
    {
     Schema::create('services', function (Blueprint $table) {
     $table->id('id_service');
     $table->decimal('cost_service', 10, 2)->unsigned();
     $table->string('name_service');
     $table->string('description_service');
     $table->timestamps();
     });
    }
    //Миграция таблицы «Способы оказания услуги»
    private function CreateServiceDeliveryMethodsTable()
    {
     Schema::create('service_delivery_methods', function
    (Blueprint $table)
     {
     $table->id('id_sdm');
     $table->string('name_sdm');
     });
    }
    //Миграция таблицы «Услуги в категориях»
    private function CreateCategoryServicesTable()
    {
     Schema::create('category_services', function (Blueprint
    $table) {
     $table->id('id_category_service');
     $table->BigInteger('service_id')->unsigned();
     $table->BigInteger('category_id')->unsigned();
     $table->string('main_image')->nullable();
     $table->timestamps();
     });
     Schema::table('category_services', function($table) {
     $table->foreign('service_id')->references('id_service')->on('services');
     $table->foreign('category_id')->references('id_category')->on('categories');
     });
    }
    //Миграция таблицы «Сроки выполнения услуги»
    private function CreateDeadlinesTable()
    {
     Schema::create('deadlines', function (Blueprint $table) {
     $table->UnsignedBigInteger('category_service_id');
     $table->UnsignedBigInteger('sdm_id');
     $table->datetime('deadline_start');
     $table->datetime('deadline_end');
     $table->timestamps();
    
     $table->primary(array('category_service_id',
    'sdm_id'));
     $table->foreign('category_service_id')->references('id_category_service')->on('category_services');
     $table->foreign('sdm_id')->references('id_sdm')->on('service_delivery_methods');
     });
    }
    //Миграция таблицы «Позиции корзины»
    private function CreateCartsTable()
    {
     Schema::create('carts', function (Blueprint $table) {
     $table->id('id_cart');
     $table ->unsignedBigInteger('category_service_id');
     $table->unsignedBigInteger('user_id');
     $table->unsignedTinyInteger('quantity')->unsigned()->default(1);
     $table->decimal('price',10,2)->default(0);
     $table->timestamps();
     });
     Schema::table('carts',function(Blueprint $table){
     $table->foreign('user_id')->references('id_user')->on('users');
     $table->foreign('category_service_id')->references('id_category_service')->on('category_services');
     });
    }
    //Миграция таблицы «Статусы»
    private function CreateStatusesTable()
    {
     Schema::create('statuses', function (Blueprint $table) {
     $table->id('id_status');
     $table->string('name_status');
     $table->unsignedBigInteger('previous_id')->nullable();
     $table->foreign('previous_id')
     ->references('id_status')->on('statuses');
    });
    }
    //Миграция таблицы «Заказы»
    private function CreateOrdersTable()
    {
     Schema::create('orders', function (Blueprint $table) {
     $table->id('id_order');
     $table->UnsignedBigInteger('user_id');
     $table->string('code', 8)->unique();
     $table->string('address')->nullable();
     $table->string('comment')->nullable();
     $table->decimal('total', 10, 2)->unsigned();
     $table->timestamp('start_date')->nullable();
     $table->timestamp('end_date_plan')->nullable();
     $table->timestamp('end_date_fact')->nullable();
     $table->timestamps();
     });
    
     Schema::table('orders', function($table) {
     $table->foreign('user_id')->references('id_user')->on('users');
     });

    }
    //Миграция таблицы «История изменения статусов»
    private function CreateStatusChangeHistoryTable()
    {

     Schema::create('status_change_history', function
    (Blueprint $table) {
     $table->id('id_status_change');
     $table->BigInteger('order_id')->unsigned();
     $table->BigInteger('status_id')->unsigned();
     $table->timestamp('created_at')->nullable();
     });
     Schema::table('status_change_history', function($table) {
     $table->foreign('order_id')->references('id_order')->on('orders');
     $table->foreign('status_id')->references('id_status')->on('statuses');

     });
    
    }
    //Миграция таблицы «Позиции заказа»
    private function CreateOrderItemsTable()
    {
     Schema::create('order_items', function (Blueprint $table)
     {
     $table->id('id_orderItem');
     $table->UnsignedBigInteger('category_service_id');
     $table->UnsignedBigInteger('order_id');
     $table->decimal('price', 10, 2)->unsigned();
     $table->integer('quantity')->unsigned()->default(1);
     $table->foreign('category_service_id')
     ->references('id_category_service')
     ->on('category_services');
     $table->foreign('order_id')
     ->references('id_order')->on('orders');
     $table->timestamps();
     });
    }
    //Миграция таблицы «Сброс пароля»
    private function CreatePasswordResetsTable()
    {
     Schema::create('password_resets', function (Blueprint
    $table) {
     $table->string('email')->index();
     $table->string('token');
     $table->timestamp('created_at')->nullable();
     });

    }
    
    }   
