<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cedula')->unique()->after('email');
            $table->enum('role', ['admin', 'analista_rh', 'empleado'])->default('empleado')->after('cedula');
            $table->string('cargo')->nullable()->after('role');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo')->after('cargo');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cedula', 'role', 'cargo', 'estado']);
        });
    }
};