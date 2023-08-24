<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            // $table->string('identity_card');
            $table->string('email',100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            // $table->integer('email_is_verifired')->default(0);
            $table->date('birthday');
            $table->string('phone');
            // $table->string('phone_operator')->nullable();

            $table->string('identity_card');
            // $table->string('identity_card_type')->default('dni');

            $table->string('city')->nullable();
            // $table->string('postal_code')->nullable();
            // $table->string('neighborhood')->nullable();

            // $table->enum('gender',['hombre','mujer','no_decirlo']);
            $table->string('password');

            $table->integer('privacy_terms')->default(1);
            $table->integer('whatsapp_consent')->default(0);
            // $table->integer('email_consent')->default(0);
            $table->integer('save_salesforce')->default(0);
            $table->integer('status')->default(1);

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
