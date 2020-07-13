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
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            // Тип (роль) пользователя (А может ли она меняться?) (Где описание и особые данные ролей? - Видимо в отдельной таблице вида user_role_admin, user_role_agent)
            // Видимо принадлежность к типу пользователя лучше хранить в отдельной таблице - мало ли надо будет ставить двойную принадлежность в будущем, например Агент и Аналитик
            // Статус пользователя - подтверждена ли регистрация админом, не заблокирован ли пользователь
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
