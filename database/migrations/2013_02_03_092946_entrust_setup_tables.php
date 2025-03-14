<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EntrustSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating roles to users (Many-to-Many)
        // Schema::create('role_user', function (Blueprint $table) {
        //     $table->integer('user_id')->unsigned();
        //     $table->integer('role_id')->unsigned();

        //     $table->foreign('user_id')->references('id')->on('users')
        //         ->onUpdate('cascade')->onDelete('cascade');
        //     $table->foreign('role_id')->references('id')->on('roles')
        //         ->onUpdate('cascade')->onDelete('cascade');

        //     $table->primary(['user_id', 'role_id']);
        // });

        // Create table for storing permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->timestamps();
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('permission_role', function (Blueprint $table) {
            $table->integer('permission_id')->unsigned();
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        #store role
        $role = new Role();
        $role->name         = 'Super Admin';
        $role->display_name = 'Super Admin'; // optional
        $role->description  = 'Super Admin'; // optional
        $role->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('permission_role');
        Schema::drop('permissions');
        Schema::drop('role_user');
        Schema::drop('roles');
    }
}
