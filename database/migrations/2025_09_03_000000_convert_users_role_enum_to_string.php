<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    // MySQL: change enum to string (varchar)
    Schema::table('users', function (Blueprint $table) {
      // Add a temporary column
      $table->string('role_tmp')->default('user');
    });

    // Copy values
    DB::table('users')->update(['role_tmp' => DB::raw('role')]);

    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn('role');
    });

    Schema::table('users', function (Blueprint $table) {
      $table->string('role')->default('user');
    });

    // Copy back
    DB::table('users')->update(['role' => DB::raw('role_tmp')]);

    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn('role_tmp');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table->enum('role', ['superadmin', 'admin', 'author', 'user'])->default('user');
    });

    DB::table('users')->update(['role' => DB::raw('role')]);

    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn('role');
    });

    Schema::table('users', function (Blueprint $table) {
      $table->enum('role', ['superadmin', 'admin', 'author', 'user'])->default('user');
    });
  }
};
