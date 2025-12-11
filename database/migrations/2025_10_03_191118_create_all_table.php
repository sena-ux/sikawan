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
        // ===== TABEL USERS =====
        Schema::create('t_users', function (Blueprint $table) {
            $table->id();
            $table->string('email', 100)->unique();
            $table->string('username', 50)->unique();
            $table->string('password', 255);
            $table->string('role', 20)->default('pegawai'); // ENUM diganti string
            $table->timestamps();
        });

        // ===== TABEL PEGAWAI =====
        Schema::create('t_pegawai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('t_users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nik', 30);
            $table->string('nip', 30)->nullable();
            $table->string('nama_lengkap', 100);
            $table->string('jabatan', 100)->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp', 15)->nullable();
            $table->boolean('status')->default(true);
            $table->text('profile')->nullable();
            $table->timestamps();
        });

        // ===== TABEL ABSENSI =====
        Schema::create('t_absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('t_users')->onDelete('cascade')->onUpdate('cascade');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('status', 20)->default('hadir');
            $table->timestamps();
        });

        // ===== TABEL IZIN =====
        Schema::create('t_izin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('t_users')->onDelete('cascade')->onUpdate('cascade');
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            $table->integer('id_dokumen')->nullable();
            $table->string('status', 20)->default('pending');
            $table->timestamps();
        });

        // ===== TABEL JURNAL HARIAN =====
        Schema::create('t_jurnal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('t_users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('hari', 20);
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('foto', 255)->nullable();
            $table->integer('id_dokumen')->nullable();
            $table->text('kegiatan');
            $table->text('deskripsi');
            $table->timestamps();
        });

        Schema::create('t_dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('t_users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nama_dokumen', 100);
            $table->string('path_dokumen', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_jurnal');
        Schema::dropIfExists('t_izin');
        Schema::dropIfExists('t_absensi');
        Schema::dropIfExists('t_pegawai');
        Schema::dropIfExists('t_users');
        Schema::dropIfExists('t_dokumen');
    }
};
