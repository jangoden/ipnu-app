<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('nia')->unique()->nullable();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('full_name');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->text('address');
            $table->string('province')->default('Jawa Barat');
            $table->string('city')->default('Kabupaten Ciamis');
            $table->foreignId('district_id')->constrained('districts')->cascadeOnDelete();
            $table->foreignId('village_id')->constrained('villages')->cascadeOnDelete();
            $table->string('phone_number');
            $table->string('hobby')->nullable();
            $table->enum('status', ['active', 'inactive', 'banned'])->default('active');
            $table->enum('grade', ['anggota', 'kader_makesta', 'kader_lakmud', 'kader_lakut'])->default('anggota');
            $table->foreignId('alumni_period_id')->nullable()->constrained('alumni_periods')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
